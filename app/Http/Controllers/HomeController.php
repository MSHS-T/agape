<?php

namespace App\Http\Controllers;

use App\EvaluationOffer;
use App\ProjectCall;
use App\User;
use App\Enums\UserRole;
use App\Exports\ApplicationsExport;
use App\Exports\ProjectCallsExport;
use App\Exports\UsersExport;
use App\Notifications\ContactMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

use PDF;
use RecursiveIteratorIterator;
use ZipArchive;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (Auth::user()->role) {
            case UserRole::Candidate:
                $open_calls = ProjectCall::with(['applications' => function ($query) {
                    $query->where('applicant_id', Auth::id());
                }])->whereDoesntHave('applications', function ($query) {
                    $query->whereNotNull('devalidation_message');
                })->open()->get();
                $old_calls = ProjectCall::with(['applications' => function ($query) {
                    $query->where('applicant_id', Auth::id());
                }])->old()->userApplied()->get();
                $unsubmitted_applications = ProjectCall::with(['applications' => function ($query) {
                    $query->where('applicant_id', Auth::id());
                }])->whereHas('applications', function ($query) {
                    $query->whereNotNull('devalidation_message');
                })->userHasNotSubmitted()->get();
                $data = compact('open_calls', 'old_calls', 'unsubmitted_applications');
                break;
            case UserRole::Admin:
                $projectcalls = ProjectCall::with('applications')->open()->get();
                $data = compact('projectcalls');
                break;
            case UserRole::Expert:
                $offers = EvaluationOffer::where('accepted', null)
                    ->where('expert_id', Auth::id())
                    ->openCalls()
                    ->get();
                $accepted = EvaluationOffer::where('accepted', true)
                    ->openCalls()
                    ->where('expert_id', Auth::id())
                    ->whereDoesntHave('evaluation', function (Builder $query) {
                        $query->whereNotNull('submitted_at')
                            ->orWhereNotNull('devalidation_message');
                    })
                    ->get();
                $done = EvaluationOffer::with('evaluation')
                    ->where('accepted', true)
                    ->where('expert_id', Auth::id())
                    ->whereHas('evaluation', function (Builder $query) {
                        $query->whereNotNull('submitted_at');
                    })
                    ->get();
                $unsubmitted = EvaluationOffer::with('evaluation')
                    ->where('accepted', true)
                    ->where('expert_id', Auth::id())
                    ->whereHas('evaluation', function (Builder $query) {
                        $query->whereNull('submitted_at')->whereNotNull('devalidation_message');
                    })
                    ->get();
                $data = compact('offers', 'accepted', 'done', 'unsubmitted');
        }
        return view('home', $data);
    }

    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('user.edit', [
            "user"        => Auth::user(),
            "mode"        => "edit",
            "form_action" => route('profile.save')
        ]);
    }

    /**
     * Updates the contents of a user's profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('profile')
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->only(['first_name', 'last_name', 'email', 'phone']);
        $user->fill($data);

        if ($request->filled(['password', 'password_confirmation'])) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect()->route('home')
            ->with('success', __('actions.profile_edited'));
    }

    /**
     * Show the legal information.
     *
     * @return \Illuminate\Http\Response
     */
    public function legal()
    {
        return view('legal');
    }

    /**
     * Show the contact form.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('contact', [
            "user"        => Auth::user(),
            "form_action" => route('contact.send')
        ]);
    }

    /**
     * Send the contents of the contact form
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendContact(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255'],
            'message'              => ['required', 'string'],
            'g-recaptcha-response' => 'recaptcha',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->route('contact')
                ->withErrors($validator)
                ->withInput();
        }
        $data = (object) $request->only(['name', 'email', 'message']);
        $data->visitor = !Auth::check();
        Notification::send(User::admins()->get(), new ContactMessage($data));

        return redirect()->route(Auth::check() ? 'home' : 'login')
            ->with('success', __('actions.contact_sent'));
    }

    public function globalExcelExport()
    {
        return new \App\Exports\GlobalExport();
    }

    public function globalZipExport()
    {
        set_time_limit(3600);

        $dirname = 'export_' . date('YmdHis');
        Storage::disk('public')->makeDirectory($dirname);

        Excel::store(
            new ProjectCallsExport(),
            $dirname . '/' . __('actions.projectcall.list') . '.xlsx',
            'public'
        );
        Excel::store(
            new UsersExport(),
            $dirname . '/' . __('actions.user.list') . '.xlsx',
            'public'
        );

        $projectcalls = ProjectCall::all();
        foreach ($projectcalls as $projectcall) {
            Storage::disk('public')->makeDirectory($dirname . '/' . $projectcall->reference);

            Excel::store(
                new ApplicationsExport($projectcall),
                $dirname . '/' . $projectcall->reference . '/' . __('actions.application.list') . '.xlsx',
                'public'
            );

            foreach ($projectcall->applications as $application) {
                Storage::disk('public')->makeDirectory($dirname . '/' . $projectcall->reference . '/' . $application->reference);

                if ($application->files->isNotEmpty()) {
                    Storage::disk('public')->makeDirectory($dirname . '/' . $projectcall->reference . '/' . $application->reference . '/attachments');

                    foreach ($application->files as $file) {
                        Storage::disk('public')->copy(
                            $file->filepath,
                            $dirname . '/' . $projectcall->reference . '/' . $application->reference . '/attachments/' . $file->order . ' - ' . $file->name
                        );
                    }
                }

                Storage::disk('public')->put(
                    $dirname . '/' . $projectcall->reference . '/' . $application->reference . '/' . __('exports.evaluations.list') . '.pdf',
                    PDF::loadView('export.evaluations_application', [
                        'application' => $application,
                        'projectcall' => $projectcall,
                        'anonymized' => false
                    ])->output()
                );
                Storage::disk('public')->put(
                    $dirname . '/' . $projectcall->reference . '/' . $application->reference . '/' . __('exports.evaluations.list_anonymous') . '.pdf',
                    PDF::loadView('export.evaluations_application', [
                        'application' => $application,
                        'projectcall' => $projectcall,
                        'anonymized' => true
                    ])->output()
                );
            }
        }

        if (Storage::disk('public')->exists('export_zip')) {
            Storage::disk('public')->deleteDirectory('export_zip');
        }
        Storage::disk('public')->makeDirectory('export_zip');

        $filename = config('app.name') . '-' . __('exports.global.name') . '-' . date('Ymd-His') . '.zip';
        $filepath = Storage::disk('public')->path('export_zip/' . $filename);
        touch($filepath);

        $zip = new \ZipArchive();

        if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $files = Storage::disk('public')->allFiles($dirname);
            foreach ($files as $file) {
                $zip->addFile(Storage::disk('public')->path($file), $file);
            }
            $zip->close();
        }

        Storage::disk('public')->deleteDirectory($dirname);

        return response()->download($filepath, $filename, [
            'Content-Length' => filesize($filepath),
            'Content-Type' => 'application/zip'
        ]);
    }

    public function error()
    {
        abort(500);
    }
}

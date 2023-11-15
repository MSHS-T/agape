<?php

namespace App\Http\Controllers;

use App\Models\EvaluationOffer;
use App\Models\ProjectCall;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::user()->hasAnyRole(['administrator', 'manager'])) {
            return redirect()->route('filament.admin.pages.dashboard');
        }
        if (Auth::user()->hasRole('expert')) {
            // $offers = EvaluationOffer::where('accepted', null)
            //     ->where('expert_id', Auth::id())
            //     ->openCalls()
            //     ->get();
            // $accepted = EvaluationOffer::where('accepted', true)
            //     ->openCalls()
            //     ->where('expert_id', Auth::id())
            //     ->whereDoesntHave('evaluation', function (Builder $query) {
            //         $query->whereNotNull('submitted_at')
            //             ->orWhereNotNull('devalidation_message');
            //     })
            //     ->get();
            // $done = EvaluationOffer::with('evaluation')
            //     ->where('accepted', true)
            //     ->where('expert_id', Auth::id())
            //     ->whereHas('evaluation', function (Builder $query) {
            //         $query->whereNotNull('submitted_at');
            //     })
            //     ->get();
            // $unsubmitted = EvaluationOffer::with('evaluation')
            //     ->where('accepted', true)
            //     ->where('expert_id', Auth::id())
            //     ->whereHas('evaluation', function (Builder $query) {
            //         $query->whereNull('submitted_at')->whereNotNull('devalidation_message');
            //     })
            //     ->get();
            // $data = compact('offers', 'accepted', 'done', 'unsubmitted');
            $data = [];
        } else {
            $open_calls = ProjectCall::with(['projectCallType', 'applications' => function ($query) {
                $query->where('applicant_id', Auth::id());
            }])
                ->open()
                ->get()
                ->filter(fn (ProjectCall $projectCall) => $projectCall->canApply() || $projectCall->applications->isNotEmpty());

            // $old_calls = ProjectCall::with(['applications' => function ($query) {
            //     $query->where('applicant_id', Auth::id());
            // }])->old()->userApplied()->get();

            // $unsubmitted_applications = ProjectCall::with(['applications' => function ($query) {
            //     $query->where('applicant_id', Auth::id());
            // }])->whereHas('applications', function ($query) {
            //     $query->where('applicant_id', Auth::id())
            //         ->whereNotNull('devalidation_message');
            // })->userHasNotSubmitted()->get();
            return view('home-candidate', compact('open_calls'));
        }
    }
}

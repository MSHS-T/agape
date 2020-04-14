<?php

namespace App\Http\Controllers;

use App\Application;
use App\Evaluation;
use App\EvaluationOffer;
use App\Invitation;
use App\User;
use App\Enums\UserRole;
use App\Notifications\OfferAccepted;
use App\Notifications\OfferCreated;
use App\Notifications\OfferDeclined;
use App\Notifications\OfferRetry;
use App\Notifications\UserInvitationOffer;
use App\Notifications\UserInvitationRetry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class EvaluationOfferController extends Controller
{
    /**
     * Assign an expert to an application
     *
     * @param  Application  $application
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Application $application, Request $request)
    {
        $application->load(['projectcall', 'offers', 'offers.expert']);
        if (!is_null($expert_id = $request->input('expert_id', null))) {
            $expert = User::findOrFail();
            $offer = $application->offers()->firstOrNew(['expert_id' => $expert->id]);
            $offer->save();
            $expert->notify(new OfferCreated($application->projectcall));
            $success = __('actions.application.expert_assigned');
        } else if (!!strlen($expert_mail = $request->input('expert_email', ''))) {
            // Check if user already exists
            $user = User::where('email', $expert_mail)->first();
            if ($user !== null) {
                // User has an account, return error
                $error = __('actions.application.invite_user_exists');
            } else {
                // Check if user has already been invited
                $existingInvite = Invitation::where('email', $expert_mail)->first();
                if ($existingInvite == null) {
                    // Send invite
                    do {
                        $invitationCode = Str::random(32);
                    } while (Invitation::find($invitationCode) !== null);

                    $invitation = new Invitation([
                        'invitation' => $invitationCode,
                        'email'      => $request->input('expert_email'),
                        'role'       => (int) UserRole::Expert,
                    ]);
                    $invitation->save();

                    $offer = $application->offers()->firstOrNew(['invitation_code' => $invitation->invitation]);
                    $offer->save();

                    $invitation->notify(new UserInvitationOffer($invitation, $application->projectcall));
                    $success = __('actions.application.expert_invited_assigned');
                } else if ($existingInvite->role == UserRole::Expert) {
                    // User has already been invited as expert (on another offer), assign and send notification 
                    $existingInvite->touch();
                    $existingInvite->notify(new UserInvitationRetry($existingInvite));

                    $success = __('actions.user.invite_sent_again');
                } else {
                    // User has already been invited, but not as expert, return error
                    $error = __('actions.application.invite_exist_with_different_role');
                }
            }
        }

        $response = redirect()->route('application.assignations', ['application' => $application]);
        if (isset($success) && !empty($success)) {
            return $response->with('success', $success);
        }
        if (isset($error) && !empty($error)) {
            return $response->with('error', $error);
        }
        return $response;
    }

    /**
     * Remove an assignation
     *
     * @param  EvaluationOffer $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationOffer $offer)
    {
        $application = $offer->application;
        $offer->delete();
        return redirect()->route('application.assignations', ['application' => $application])
            ->with('success', __('actions.application.expert_unassigned'));
    }

    /**
     * Sends a reminder email to expert to process the evaluation offer
     *
     * @param  EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retry(EvaluationOffer $offer, Request $request)
    {
        if ($offer->expert) {
            $offer->expert->notify(new OfferRetry($offer));
        } else if ($offer->invitedExpert) {
            $offer->invitedExpert->touch();
            $offer->invitedExpert->notify(new UserInvitationRetry($offer->invitedExpert));
        }

        return redirect()->route('application.assignations', ['application' => $offer->application])
            ->with('success', __('actions.evaluationoffers.reminder_sent'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \App\EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(EvaluationOffer $offer, Request $request)
    {
        if (!$offer->application->projectcall->canEvaluate()) {
            return redirect()->route('home')
                ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        if ($offer->accepted != null) {
            return redirect()->route('home')
                ->withErrors([__('actions.evaluationoffers.already_answered')]);
        }
        $offer->accepted = true;
        $evaluation = $offer->evaluation()->first() ?? $offer->evaluation()->save(new Evaluation);
        $offer->save();
        Notification::send(User::admins()->get(), new OfferAccepted($offer));
        return redirect()->route('evaluation.edit', ["evaluation" => $evaluation])
            ->with('success', __('actions.evaluationoffers.accepted'));
    }

    /**
     * Accepts the evaluation offer.
     *
     * @param  \App\EvaluationOffer  $offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decline(EvaluationOffer $offer, Request $request)
    {
        if (!$offer->application->projectcall->canEvaluate()) {
            return redirect()->route('home')
                ->withErrors([__('actions.projectcall.cannot_evaluate_anymore')]);
        }
        if ($offer->accepted != null) {
            return redirect()->route('home')
                ->withErrors([__('actions.evaluationoffers.already_answered')]);
        }
        $offer->accepted = false;
        $offer->justification = $request->input('justification');
        $offer->save();
        Notification::send(User::admins()->get(), new OfferDeclined($offer));
        return redirect()->route('home')
            ->with('success', __('actions.evaluationoffers.declined'));
    }
}

<?php

namespace App\Actions;

use App\Models\Application;
use App\Models\EvaluationOffer;
use App\Models\Invitation;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class InviteExpert
{
    public static function handle(Application $application, ?int $expertId = null, ?string $invitationEmail = null)
    {
        // TODO : check if invitation email is already linked to an account with the role expert
        if (filled($invitationEmail)) {
            $expert = User::where('email', $invitationEmail)->first();
            if ($expert && $expert->hasRole('expert')) {
                $expertId = $expert->id;
            }
        }
        if (filled($expertId)) {
            $existingInvitation = EvaluationOffer::where('application_id', $application->id)
                ->where('expert_id', $expertId)
                ->first();
            if ($existingInvitation) {
                return self::existingInvitation();
            }

            EvaluationOffer::create([
                'application_id' => $application->id,
                'expert_id'      => $expertId,
            ]);
            Notification::make()
                ->title(__('admin.evaluation_offer.success_sent'))
                ->success()
                ->send();
        } else if (filled($invitationEmail)) {
            $existingInvitation = EvaluationOffer::where('application_id', $application->id)
                ->whereHas('invitation', fn($query) => $query->where('email', $invitationEmail))
                ->first();
            if ($existingInvitation) {
                return self::existingInvitation();
            }

            $invitation = Invitation::where('email', $invitationEmail)->first();
            if ($invitation) {
                $message = __('admin.evaluation_offer.success_linked');
            } else {
                $invitation = InviteUser::handle($invitationEmail, 'expert', quietly: true);
                $message = __('admin.evaluation_offer.success_invited');
            }
            EvaluationOffer::create([
                'application_id' => $application->id,
                'invitation_id'  => $invitation->id,
            ]);
            Notification::make()
                ->title($message)
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title(__('admin.evaluation_offer.error_no_expert_or_email'))
                ->error()
                ->send();
        }
    }

    private static function existingInvitation()
    {
        Notification::make()
            ->title(__('admin.evaluation_offer.error_existing_invitation'))
            ->danger()
            ->send();
    }
}

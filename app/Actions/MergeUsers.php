<?php

namespace App\Actions;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class MergeUsers
{
    public static function handle(User $recipient, User $merged)
    {
        $belongsToManyRelationships = [
            'projectCallTypes',
        ];
        $hasManyRelationships = [
            'applications'     => 'creator',
            'evaluationOffers' => 'creator',
            'invitations'      => 'creator',
            'laboratories'     => 'creator',
            'studyFields'      => 'creator',
        ];

        // Preload relationships for performance
        $recipient->load(array_merge($belongsToManyRelationships, $hasManyRelationships));
        $merged->load(array_merge($belongsToManyRelationships, $hasManyRelationships));

        // Merge belongsToMany relationship
        foreach ($belongsToManyRelationships as $relationship) {
            foreach ($merged->{$relationship} as $relatedModel) {
                if (!$recipient->{$relationship}()->contains($relatedModel)) {
                    $recipient->{$relationship}()->attach($relatedModel, $relatedModel->pivot);
                }
            }
        }

        // Merge hasMany relationships
        foreach ($hasManyRelationships as $relationship => $foreignRelationship) {
            foreach ($merged->$relationship as $relatedModel) {
                if (!$recipient->$relationship()->contains($relatedModel)) {
                    $relatedModel->{$foreignRelationship}()->associate($recipient);
                }
            }
        }

        $merged->delete();
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\Auth;

class UserInteractionService
{

    const INTERACTION_TYPE_VIEW = 'view';
    const INTERACTION_TYPE_PURCHASE = 'purchase';
    const INTERACTION_TYPE_SEARCH = 'search';

    public function trackInteraction($userId, $interactionType, $interactionValue)
    {
        // Avoid logging duplicate interactions within 5 minutes
        $recentInteraction = UserInteraction::where('user_id', $userId)
            ->where('interaction_type', $interactionType)
            ->where('interaction_value', $interactionValue)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();

        if ($recentInteraction) {
            return;
        }

        // Log the interaction
        UserInteraction::create([
            'user_id' => $userId,
            'interaction_type' => $interactionType,
            'interaction_value' => $interactionValue,
        ]);

        // Automatically update user preferences
        $this->updateUserPreferences($userId, $interactionValue, $interactionType);
    }

    protected function updateUserPreferences($userId, $category, $interactionType)
    {
        // Determine the score increment based on interaction type
        $scoreIncrement = $this->getScoreIncrement($interactionType);

        // Update or create the user preference
     //   $user = Auth::find($userId);
        $user = User::find($userId);
        $user->preferences()->updateOrCreate(
            ['preference' => $category],
            ['score' => \DB::raw("score + {$scoreIncrement}")]
        );
    }

    protected function getScoreIncrement($interactionType)
    {
        switch ($interactionType) {
            case self::INTERACTION_TYPE_PURCHASE:
                return 10;
            case self::INTERACTION_TYPE_SEARCH:
                return 5;
            case self::INTERACTION_TYPE_VIEW:
            default:
                return 1;
        }
    }
}


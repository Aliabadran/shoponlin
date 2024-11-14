<?php

namespace App\Listeners;

use App\Events\UserInteractionLogged;
use App\Services\UserInteractionService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserPreferences
{

        protected $interactionService;

        public function __construct(UserInteractionService $interactionService)
        {
            $this->interactionService = $interactionService;
        }

        public function handle(UserInteractionLogged $event)
        {
            $this->interactionService->trackInteraction($event->userId, $event->interactionType, $event->interactionValue);
        }

}

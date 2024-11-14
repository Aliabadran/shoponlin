<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserPreference;
use Carbon\Carbon;


class DecayUserPreferences extends Command
{




    protected $signature = 'preferences:decay {--decay=1} {--threshold=1}';
    protected $description = 'Decay user preferences based on their scores';

    public function handle()
    {
        $decayAmount = $this->option('decay');
        $threshold = $this->option('threshold');

        $preferences = UserPreference::where('score', '>', $threshold)->get();

        foreach ($preferences as $preference) {
            $preference->decrement('score', $decayAmount);
        }

        $this->info('Decayed user preferences successfully.');
    }

}

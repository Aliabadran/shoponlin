<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Add your scheduled command here
        $schedule->command('preferences:decay')->daily(); // Decay preferences daily
    }
   protected function commands()
  {      $this->load(__DIR__.'/Commands');  }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Commands\Inspire::class,
        'App\Console\Commands\Viajes',
        'App\Console\Commands\CerrarViajes'
    ];

    protected function schedule(Schedule $schedule)
    {
        
    }
}

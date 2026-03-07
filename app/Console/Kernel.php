<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Laravel\Passport\Console\InstallCommand::class,
        \Laravel\Passport\Console\KeysCommand::class,
        \Laravel\Passport\Console\ClientCommand::class,
        \Laravel\Passport\Console\HashCommand::class,
        \Laravel\Passport\Console\PurgeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    /**
     * Get the Artisan application instance.
     *
     * We override this to ensure commands registered via default names
     * (via the Symfony AsCommand attribute) are properly resolvable.
     *
     * @return \Illuminate\Console\Application
     */
    protected function getArtisan()
    {
        $artisan = parent::getArtisan();
        $artisan->setContainerCommandLoader();
        return $artisan;
    }
}

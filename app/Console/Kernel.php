<?php

namespace App\Console;

use Illuminate\Support\Facades\Config;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// put this on cron job
// * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

class Kernel extends ConsoleKernel
{
	protected $commands = [
		'App\Console\Commands\ScheduleToDoListMonthly',
		'App\Console\Commands\ScheduleToDoListYearly',
	];

	protected function schedule(Schedule $schedule) {
		$schedule->command('todo:monthly')->monthly()->sendOutputTo(storage_path().'log.log');
		$schedule->command('todo:yearly')->yearly()->sendOutputTo(storage_path().'log.log');
	}

	protected function commands()
	{
		$this->load(__DIR__.'/Commands');
		require base_path('routes/console.php');
	}
}

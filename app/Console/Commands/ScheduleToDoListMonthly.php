<?php
namespace App\Console\Commands;

// load model
use \App\Model\ToDoSchedule;
use \App\Model\ToDoList;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ScheduleToDoListMonthly extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	*/
	protected $signature = 'todo:monthly';

	/**
	 * The console command description.
	 *
	 * @var string
	*/
	protected $description = 'Set Monthly Reminder';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	*/
	public function handle()
	{
		$n = Carbon::now();
		$nm = $n->addMonth();

		$tds = ToDoSchedule::where([['active', 1], ['category_id', 3]])->get();
		foreach ($tds as $k) {
			// kira dateline
			$d = Carbon::parse($k->dateline)->day;
			$dateline = Carbon::create($nm->year, $nm->month, $d);

			// kira reminder
			$reminder = $dateline->copy()->subDays($k->period_reminder);

			ToDoList::create([
				'schedule_id' => $k->id,
				'reminder' => $reminder,
				'dateline' => $dateline,
				'priority_id' => $k->priority_id
			]);
		}
	}
}
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:checkslastatus')->everyMinute();
Schedule::command('app:generate-daily-report')->dailyAt('14:29');
Schedule::command('app:leader-daily-performance-report')->dailyAt('14:29');


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

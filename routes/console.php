<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:checkslastatus')->everyFifteenSeconds();
Schedule::command('app:generate-daily-report')->everyFifteenSeconds();
Schedule::command('app:leader-daily-performance-report')->everyFifteenSeconds();


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

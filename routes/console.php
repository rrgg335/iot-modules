<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\{
    CheckModuleStatus,
    RecordMeasurements
};

Schedule::command(CheckModuleStatus::class)->everyThirtySeconds();
Schedule::command(RecordMeasurements::class)->everyTwentySeconds();
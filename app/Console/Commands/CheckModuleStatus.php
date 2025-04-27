<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
    ModuleMeasurement,
    Module
};

class CheckModuleStatus extends Command
{
    protected $signature = 'app:check-module-status';

    protected $description = 'Randomly changing module statuses';

    public function handle(){
        // Fetch all working modules and malfunctioned modules at same time
        $all_modules = Module::whereIn('current_status',['working','malfunctioned'])->get();
        foreach($all_modules as $module){
            switch($module->current_status){
                case 'working':
                    if(empty(mt_rand(0,1))){
                        // 50% chance it stops working
                        $module->current_status = 'malfunctioned';
                        $module->save();
                    }
                break;
                case 'malfunctioned':
                    if(!empty(mt_rand(0,1))){
                        // 50% chance it starts working back again
                        $module->current_status = 'working';
                        $module->save();
                    }
                break;
            }
        }
        // We do not disturb user acted statuses i.e. stopped and paused, nor is their measurements recorded
    }
}

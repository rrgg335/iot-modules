<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
    MeasurementResult,
    ModuleMeasurement,
    Module
};

class RecordMeasurements extends Command
{
    protected $signature = 'app:record-measurements';

    protected $description = 'Recording Random Values';

    public function handle(){
        // Get all measurements for only working modules
        $module_measurements = ModuleMeasurement::select('module_measurements.*')->join('modules',function($query){
            $query->on('modules.id','module_measurements.module_id');
            $query->where('modules.current_status','working');
        })->get();
        foreach($module_measurements as $measurement){
            $measurement_value = mt_rand(!empty($measurement->min_value) ? $measurement->min_value : 0,!empty($measurement->max_value) ? $measurement->max_value : 1000);
            $condition = mt_rand(1,4);
            switch($condition){
                case 1:
                    // 25% chance of optimal value
                    if(isset($measurement->optimal_value)){
                        $measurement_value = $measurement->optimal_value;
                    }else{
                        // If optimal value is not set, we just take the average
                        $measurement_value = ($measurement->min_value ?? 0 + $measurement->max_value ?? 1000) / 2;
                    }
                break;
                case 2:
                    // 25% chance of value too low
                    $measurement_value = ($measurement->min_value ?? 0) - ((mt_rand(0,100) / 100) * $measurement_value);
                break;
                case 3:
                    // 25% chance of value too low
                    $measurement_value = ($measurement->max_value ?? 1000) + ((mt_rand(0,100) / 100) * $measurement_value);
                break;
                // case 4 is left as 25% chance of not overriding whatever value was picked randomly
            }
            $measurement->current_value = $measurement_value;
            $measurement->save();
            MeasurementResult::create([
                'module_measurement_id' => $measurement->id,
                'value' => $measurement_value
            ]);
        }
    }
}

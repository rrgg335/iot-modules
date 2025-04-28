<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{
	MeasurementType,
	MeasurementUnit,
	ModuleMeasurement,
	Module
};
use Carbon\Carbon;

class ModuleController extends Controller {

	public function index(Request $request){
		$modules = Module::get();
		$measurement_types = MeasurementType::get();
		$measurement_units = [];
		$all_measurement_units = MeasurementUnit::get();
		foreach($all_measurement_units as $measurement_unit){
			$measurement_units[$measurement_unit->measurement_type->name][] = $measurement_unit;
		}
		return response()->view('modules.index',compact('modules','measurement_types','measurement_units'));
	}

	public function show(Request $request,$id){
		$module = Module::findOrFail($id);
		return response()->view('modules.show',compact('module'))->header('Refresh','30');
	}

	public function edit(Request $request,$id){
		$module = Module::findOrFail($id);
		$measurement_types = MeasurementType::get();
		$measurement_units = [];
		$all_measurement_units = MeasurementUnit::get();
		foreach($all_measurement_units as $measurement_unit){
			$measurement_units[$measurement_unit->measurement_type->name][] = $measurement_unit;
		}
		return view('modules.form',compact('module','measurement_types','measurement_units'));
	}

	public function store(Request $request){
		$request->validate([
			'module_name' => 'required|max:255',
			'module_description' => 'nullable|max:1000',
			'measurements' => 'nullable|array',
			'measurements.*' => 'nullable|array',
			'measurements.*.measurement_type' => 'nullable|exists:measurement_types,id',
			'measurements.*.measurement_unit' => 'nullable|exists:measurement_units,id',
			'measurements.*.minimum_value' => 'nullable',
			'measurements.*.optimal_value' => 'nullable',
			'measurements.*.maximum_value' => 'nullable',
		]);
		DB::beginTransaction();
			$module = new Module;
			$module->name = trim($request->module_name);
			$module->description = trim($request->module_description);
			$module->save();
			if(!empty($request->measurements)){
				foreach($request->measurements as $measurement){
					$module_measurement = new ModuleMeasurement;
					$module_measurement->module_id = $module->id;
					$module_measurement->measurement_type_id = $measurement['measurement_type'];
					$module_measurement->measurement_unit_id = $measurement['measurement_unit'];
					$module_measurement->min_value = $measurement['minimum_value'];
					$module_measurement->optimal_value = $measurement['optimal_value'];
					$module_measurement->max_value = $measurement['maximum_value'];
					$module_measurement->save();
				}
			}
		DB::commit();
		return redirect()->route('modules.index')->with('success','Module created successfully');
	}

	public function update(Request $request){
		$request->validate([
			'module_id' => 'required|exists:modules,id',
			'module_name' => 'required|max:255',
			'module_description' => 'nullable|max:1000',
			'measurements' => 'nullable|array',
			'measurements.*' => 'nullable|array',
			'measurements.*.measurement_type' => 'nullable|exists:measurement_types,id',
			'measurements.*.measurement_unit' => 'nullable|exists:measurement_units,id',
			'measurements.*.minimum_value' => 'nullable',
			'measurements.*.optimal_value' => 'nullable',
			'measurements.*.maximum_value' => 'nullable',
		]);
		DB::beginTransaction();
			$module = Module::findOrFail($request->module_id);
			$module->name = trim($request->module_name);
			$module->description = trim($request->module_description);
			$module->save();
			$module_measurement_ids = [];
			if(!empty($request->measurements)){
				foreach($request->measurements as $measurement){
					$module_measurement = ModuleMeasurement::updateOrCreate([
						'module_id' => $module->id,
						'measurement_type_id' => $measurement['measurement_type'],
						'measurement_unit_id' => $measurement['measurement_unit']
					],[
						'min_value' => $measurement['minimum_value'] ?? null,
						'optimal_value' => $measurement['optimal_value'] ?? null,
						'max_value' => $measurement['maximum_value'] ?? null,
					]);
					$module_measurement_ids[] = $module_measurement->id;
				}
			}
			ModuleMeasurement::where('module_id',$module->id)->whereNotIn('id',$module_measurement_ids)->delete();
		DB::commit();
		return redirect()->route('modules.index')->with('success','Module updated successfully');
	}

	public function action(Request $request,$module_id,$action){
		$module = Module::findOrFail($module_id);
		switch($action){
			case 'start':
				$module->current_status = 'working';
			break;
			case 'stop':
				$module->current_status = 'stopped';
			break;
			case 'pause':
				$module->current_status = 'paused';
			break;
		}
		$module->save();
		return redirect()->route('modules.index')->with('success','Module status updated successfully');
	}

	public function delete(Request $request,$id){
		$module = Module::findOrFail($id);
		$module->delete();
		if($request->expectsJson()){
			return response()->json([
				'success' => true,
				'message' => 'Module deleted successfully'
			]);
		}
		return redirect()->route('modules.index')->with('success','Module deleted successfully');
	}

}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	MeasurementType,
	MeasurementUnit
};
use Carbon\Carbon;

class MeasurementUnitController extends Controller {

	public function index(Request $request){
		$measurement_types = MeasurementType::get();
		$measurement_units = MeasurementUnit::get();
		return view('measurement-units.index',compact('measurement_types','measurement_units'));
	}

	public function edit(Request $request,$id){
		$measurement_types = MeasurementType::get();
		$measurement_unit = MeasurementUnit::findOrFail($id);
		return view('measurement-units.form',compact('measurement_types','measurement_unit'));
	}

	public function store(Request $request){
		$request->validate([
			'measurement_type_id' => 'required|exists:measurement_types,id',
			'measurement_unit_name' => 'required|max:255',
			'measurement_unit_prefix' => 'nullable|max:255',
			'measurement_unit_suffix' => 'required|max:255',
		]);
		$measurement_unit = new MeasurementUnit;
		$measurement_unit->measurement_type_id = $request->measurement_type_id;
		$measurement_unit->name = trim($request->measurement_unit_name);
		$measurement_unit->prefix = $request->measurement_unit_prefix;
		$measurement_unit->suffix = $request->measurement_unit_suffix;
		$measurement_unit->save();
		return redirect()->route('measurement-units.index')->with('success','Measurement Unit created successfully');
	}

	public function update(Request $request){
		$request->validate([
			'measurement_unit_id' => 'required|exists:measurement_units,id',
			'measurement_type_id' => 'required|exists:measurement_types,id',
			'measurement_unit_name' => 'required|max:255',
			'measurement_unit_prefix' => 'nullable|max:255',
			'measurement_unit_suffix' => 'required|max:255',
		]);
		$measurement_unit = MeasurementUnit::findOrFail($request->measurement_unit_id);
		$measurement_unit->measurement_type_id = $request->measurement_type_id;
		$measurement_unit->name = trim($request->measurement_unit_name);
		$measurement_unit->prefix = $request->measurement_unit_prefix;
		$measurement_unit->suffix = $request->measurement_unit_suffix;
		$measurement_unit->save();
		return redirect()->route('measurement-units.index')->with('success','Measurement Unit updated successfully');
	}

	public function delete(Request $request,$id){
		$measurement_unit = MeasurementUnit::findOrFail($id);
		$measurement_unit->delete();
		if($request->expectsJson()){
			return response()->json([
				'success' => true,
				'message' => 'Measurement Unit deleted successfully'
			]);
		}
		return redirect()->route('measurement-units.index')->with('success','Measurement Unit deleted successfully');
	}

}
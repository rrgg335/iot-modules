<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\{
	MeasurementType,
	MeasurementUnit
};
use Carbon\Carbon;

class MeasurementTypeController extends Controller {

	public function index(Request $request){
		$measurement_types = MeasurementType::get();
		return view('measurement-types.index',compact('measurement_types'));
	}

	public function edit(Request $request,$id){
		$measurement_type = MeasurementType::findOrFail($id);
		return view('measurement-types.form',compact('measurement_type'));
	}

	public function store(Request $request){
		$request->validate([
			'measurement_type_name' => 'required|max:255',
			'measurement_type_description' => 'nullable|max:1000',
			'measurement_type_value_type' => 'required|in:text,number',
		]);
		$measurement_type = new MeasurementType;
		$measurement_type->name = trim($request->measurement_type_name);
		$measurement_type->description = trim($request->measurement_type_description);
		$measurement_type->value_type = $request->measurement_type_value_type;
		$measurement_type->save();
		return redirect()->route('measurement-types.index')->with('success','Measurement Type created successfully');
	}

	public function update(Request $request){
		$request->validate([
			'measurement_type_id' => 'required|exists:measurement_types,id',
			'measurement_type_name' => 'required|max:255',
			'measurement_type_description' => 'nullable|max:1000',
			'measurement_type_value_type' => 'required|in:text,number',
		]);
		$measurement_type = MeasurementType::findOrFail($request->measurement_type_id);
		$measurement_type->name = trim($request->measurement_type_name);
		$measurement_type->description = trim($request->measurement_type_description);
		$measurement_type->value_type = $request->measurement_type_value_type;
		$measurement_type->save();
		return redirect()->route('measurement-types.index')->with('success','Measurement Type updated successfully');
	}

	public function delete(Request $request,$id){
		DB::beginTransaction();
			$measurement_type = MeasurementType::findOrFail($id);
			MeasurementUnit::where('measurement_type_id',$id)->delete();
			$measurement_type->delete();
		DB::commit();
		if($request->expectsJson()){
			return response()->json([
				'success' => true,
				'message' => 'Measurement Type deleted successfully'
			]);
		}
		return redirect()->route('measurement-types.index')->with('success','Measurement Type deleted successfully');
	}

}
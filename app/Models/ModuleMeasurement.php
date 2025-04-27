<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
	Module,
	MeasurementResult,
	MeasurementType,
	MeasurementUnit,
	User
};

class ModuleMeasurement extends Model {

	use SoftDeletes;

	protected $table = 'module_measurements';

	protected $guarded = [];

	public function module(){
		return $this->belongsTo(Module::class,'module_id','id');
	}

	public function measurement_type(){
		return $this->belongsTo(MeasurementType::class,'measurement_type_id','id');
	}

	public function measurement_unit(){
		return $this->belongsTo(MeasurementUnit::class,'measurement_unit_id','id');
	}

	public function results(){
		return $this->hasMany(MeasurementResult::class,'module_measurement_id','id');
	}

}
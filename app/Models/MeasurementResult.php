<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModuleMeasurement;

class MeasurementResult extends Model {

	use SoftDeletes;

	protected $table = 'measurement_results';

	protected $guarded = [];

	public function module_measurement(){
		return $this->belongsTo(ModuleMeasurement::class,'module_measurement_id','id');
	}

}
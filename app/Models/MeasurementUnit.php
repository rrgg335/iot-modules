<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    MeasurementType,
    User
};

class MeasurementUnit extends Model {

    use SoftDeletes;

    protected $table = 'measurement_units';

	protected $guarded = [];

    public function measurement_type(){
		return $this->belongsTo(MeasurementType::class,'measurement_type_id','id');
	}

}
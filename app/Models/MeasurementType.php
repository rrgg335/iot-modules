<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    MeasurementUnit,
    User
};

class MeasurementType extends Model {

    use SoftDeletes;

    protected $table = 'measurement_types';

	protected $guarded = [];

    public function measurement_units(){
		return $this->hasMany(MeasurementUnit::class,'measurement_type_id','id');
	}

}
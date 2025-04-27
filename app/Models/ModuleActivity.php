<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class ModuleActivity extends Model {

	use SoftDeletes;

	protected $table = 'module_activity';

	protected $guarded = [];

	public function module(){
		return $this->belongsTo(Module::class,'module_id','id');
	}

}
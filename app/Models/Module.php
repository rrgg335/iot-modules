<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
	ModuleActivity,
	ModuleMeasurement
};

class Module extends Model {

	use SoftDeletes;

	protected $table = 'modules';

	protected $guarded = [];

	protected static function boot(){
		parent::boot();
		static::updating(function($module){
			if($module->isDirty('current_status')){
				$activity_type = 'info';
				switch($module->current_status){
					case 'stopped':
						$activity_type = 'warning';
					break;
					case 'paused':
						$activity_type = 'warning';
					break;
					case 'working':
						$activity_type = 'success';
					break;
					case 'malfunctioned':
						$activity_type = 'danger';
					break;
				}
				ModuleActivity::create([
					'module_id' => $module->id,
					'activity' => 'Module status was changed from '.ucfirst($module->getOriginal('current_status')).' to '.ucfirst($module->current_status),
					'activity_type' => $activity_type
				]);
            }
		});
	}

	public function activity(){
		return $this->hasMany(ModuleActivity::class,'module_id','id');
	}

	public function measurements(){
		return $this->hasMany(ModuleMeasurement::class,'module_id','id');
	}

	public function currentStatusBadge(): Attribute {
		return Attribute::make(
			function(){
				switch($this->current_status){
					case 'stopped':
						return '<span class="badge bg-warning">Stopped</span>';
					break;
					case 'paused':
						return '<span class="badge bg-warning">Paused</span>';
					break;
					case 'working':
						return '<span class="badge bg-success">Working</span>';
					break;
					case 'malfunctioned':
						return '<span class="badge bg-danger">Malfunctioned</span>';
					break;
				}
			}
		);
	}

	public function currentStatusDot(): Attribute {
		return Attribute::make(
			function(){
				switch($this->current_status){
					case 'stopped':
						return '<span class="status-dot bg-warning"> </span>';
					break;
					case 'paused':
						return '<span class="status-dot bg-warning"> </span>';
					break;
					case 'working':
						return '<span class="status-dot bg-success"> </span>';
					break;
					case 'malfunctioned':
						return '<span class="status-dot bg-danger"> </span>';
					break;
				}
			}
		);
	}

}
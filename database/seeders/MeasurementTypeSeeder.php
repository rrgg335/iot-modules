<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeasurementType;

class MeasurementTypeSeeder extends Seeder {
	public function run(){
		$measurement_types = [
			'Length' => [
				'description' => 'Measure of how long something is',
				'value_type' => 'number'
			],
			'Temperature' => [
				'description' => 'Measure of how hot something is',
				'value_type' => 'number'
			],
			'Weight' => [
				'description' => 'Measure of how heavy something is',
				'value_type' => 'number'
			],
			'Volume' => [
				'description' => 'Measure of how big something is',
				'value_type' => 'number'
			],
			'Speed' => [
				'description' => 'Measure of how fast something is',
				'value_type' => 'number'
			],
		];
		foreach($measurement_types as $measurement_type_key => $measurement_type){
			if(!MeasurementType::where('name',$measurement_type_key)->exists()){
				MeasurementType::create(array_merge([
					'name' => $measurement_type_key
				],$measurement_type));
			}
		}
	}
}
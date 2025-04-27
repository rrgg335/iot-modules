<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
	MeasurementType,
	MeasurementUnit
};

class MeasurementUnitSeeder extends Seeder {
	public function run(){
		$measurement_units = [
			'Length' => [
				'Centimeter' => [
					'suffix' => 'cm'
				],
				'Meter' => [
					'suffix' => 'm'
				],
				'Yard' => [
					'suffix' => 'yard(s)'
				]
			],
			'Temperature' => [
				'Celcius' => [
					'suffix' => '°C'
				],
				'Fahrenheit' => [
					'suffix' => '°F'
				],
				'Kelvin' => [
					'suffix' => 'K'
				]
			],
			'Weight' => [
				'Kilogram' => [
					'suffix' => 'Kg'
				],
				'Pound' => [
					'suffix' => 'lbs'
				],
				'Gram' => [
					'suffix' => 'g'
				]
			],
			'Volume' => [
				'Liters' => [
					'suffix' => 'L'
				],
				'Cubic centimeters' => [
					'suffix' => 'cc'
				],
				'Cubic meters' => [
					'suffix' => 'm³'
				]
			],
			'Speed' => [
				'Miles per hour' => [
					'suffix' => 'mph'
				],
				'Kilometers per hour' => [
					'suffix' => 'km/h'
				],
				'Meters per second' => [
					'suffix' => 'm/s'
				]
			],
		];
		foreach($measurement_units as $measurement_type => $measurement_units){
			$measurement_type = MeasurementType::where('name',$measurement_type)->first();
			if(empty($measurement_type)){
				continue;
			}
			foreach($measurement_units as $measurement_unit_key => $measurement_unit){
				if(!MeasurementUnit::where('name',$measurement_unit_key)->where('measurement_type_id',$measurement_type->id)->exists()){
					MeasurementUnit::create(array_merge([
						'measurement_type_id' => $measurement_type->id,
						'name' => $measurement_unit_key,
					],$measurement_unit));
				}
			}
		}
	}
}
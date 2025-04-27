<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ModuleController,
    MeasurementTypeController,
    MeasurementUnitController
};

Route::middleware('guest:web')->group(function(){
	Route::redirect('/','dashboard');
	Route::prefix('dashboard')->controller(DashboardController::class)->name('dashboard.')->group(function(){
		Route::get('/','index')->name('index');
	});
	Route::prefix('modules')->controller(ModuleController::class)->name('modules.')->group(function(){
		Route::get('/','index')->name('index');
		Route::get('action/{module_id}/{action}','action')->name('action')->where('action','stop|pause|start');
		Route::get('edit/{module_id?}','edit')->name('edit');
		Route::get('delete/{module_id}','delete')->name('delete');
		Route::get('{module_id}','show')->name('show');
		Route::post('store','store')->name('store');
		Route::put('update','update')->name('update');
	});
	Route::prefix('measurement-types')->controller(MeasurementTypeController::class)->name('measurement-types.')->group(function(){
		Route::get('/','index')->name('index');
		Route::get('edit/{measurement_type_id?}','edit')->name('edit');
		Route::get('delete/{measurement_type_id}','delete')->name('delete');
		Route::post('store','store')->name('store');
		Route::put('update','update')->name('update');
	});
	Route::prefix('measurement-units')->controller(MeasurementUnitController::class)->name('measurement-units.')->group(function(){
		Route::get('/','index')->name('index');
		Route::get('edit/{measurement_unit_id?}','edit')->name('edit');
		Route::get('delete/{measurement_unit_id}','delete')->name('delete');
		Route::post('store','store')->name('store');
		Route::put('update','update')->name('update');
	});
});
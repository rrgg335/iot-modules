@extends('layouts.master')
@section('title','Modules')
@section('styles')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 my-3">
			<div class="mb-5">
				<h3 class="mb-0">Modules <button type="button" class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</button></h3>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Current Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($modules) && $modules->isNotEmpty())
						@foreach($modules as $module)
							<tr>
								<td>{{ $module->name }} {!! $module->current_status_dot !!}</td>
								<td>
									<p class="d-block mb-0 maw-250p text-truncate">{{ $module->description }}</p>
								</td>
								<td>{!! $module->current_status_badge !!}</td>
								<td>
									<a href="{{ route('modules.show',['module_id'=>$module->id]) }}" class="text-primary" ><i data-feather="eye"></i></a>
									<div class="d-inline-block dropdown">
										<a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown">
											<i data-feather="more-horizontal"></i>
										</a>
										<div class="dropdown-menu right">
											@if(in_array($module->current_status,['paused','stopped','malfunctioned']))
												<a href="javascript:void(0)" class="dropdown-item text-info" confirm-href="{{ route('modules.action',['module_id'=>$module->id,'action'=>'start']) }}" confirm-text="Start Module {{ $module->name }}?">Start Module</a>
											@endif
											@if(in_array($module->current_status,['working','paused','malfunctioned']))
												<a href="javascript:void(0)" class="dropdown-item text-info" confirm-href="{{ route('modules.action',['module_id'=>$module->id,'action'=>'stop']) }}" confirm-text="Stop Module {{ $module->name }}?">Stop Module</a>
											@endif
											@if(in_array($module->current_status,['working','malfunctioned']))
												<a href="javascript:void(0)" class="dropdown-item text-info" confirm-href="{{ route('modules.action',['module_id'=>$module->id,'action'=>'pause']) }}" confirm-text="Pause Module {{ $module->name }}?">Pause Module</a>
											@endif
											<a href="javascript:void(0)" class="dropdown-item text-warning update-module" data-module-id="{{ $module->id }}">Edit Module</a>
											<a href="javascript:void(0)" class="dropdown-item text-danger" confirm-href="{{ route('modules.delete',$module->id) }}" confirm-text="Delete Module {{ $module->name }}?">Delete Module</a>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">
								No Modules Yet.
								<a href="javascript:void(0)" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</a>
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('modals')
<div id="addModuleModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Module</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('modules.store') }}">
					@csrf
					@include('modules.form',['module'=>null])
				</form>
			</div>
		</div>
	</div>
</div>
<div id="editModuleModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Module</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('modules.update') }}">
					@csrf
					@method('put')
					<div class="col-12">
						<div id="module-edit-form" class="row"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).on('click','.update-module',function(){
		var this_id = $(this).attr('data-module-id');
		$.ajax({
			'url':'{{ route("modules.edit") }}/'+this_id,
			'type':'get',
			'dataType':'html',
			'beforeSend':function(){
				$('#editModuleModal').modal('show');
				$('#module-edit-form').empty();
			},
			'success':function(response){
				$('#module-edit-form').html(response);
				fixMeasurementForm($('#module-edit-form').closest('form'));
			},
			'error':function(){
				$('#module-edit-form').html('@include("elements.error-loading-modal")');
			}
		});
	});
	$(document).on('click','.add-measurement',function(){
		$(this).closest('form').find('.module-measurements').append(`@include("modules.measurement")`);
		if(typeof feather != 'undefined'){
			feather.replace();
		}
		fixMeasurementForm($(this).closest('form'));
	});
	$(document).on('click','.remove-measurement',function(){
		var this_form = $(this).closest('form');
		$(this).closest('.measurement-row').remove();
		fixMeasurementForm(this_form);
	});
	function fixMeasurementForm(formElement){
		formElement.find('.measurement-type-select').trigger('change');
		formElement.find('.measurement-numeric-index').each(function(index){
			$(this).html(index + 1);
		});
		formElement.find('.measurement-row').each(function(index){
			$(this).find('.measurement-type-select').attr('name','measurements['+index+'][measurement_type]');
			$(this).find('.measurement-unit-select').attr('name','measurements['+index+'][measurement_unit]');
			$(this).find('.measurement-minimum-value').attr('name','measurements['+index+'][minimum_value]');
			$(this).find('.measurement-optimal-value').attr('name','measurements['+index+'][optimal_value]');
			$(this).find('.measurement-maximum-value').attr('name','measurements['+index+'][maximum_value]');
		});
	}
	$(document).on('change','.measurement-row .measurement-type-select',function(){
		var this_value = $(this).val();
		var this_measurement_unit_select = $(this).closest('.measurement-row').find('.measurement-unit-select');
		this_measurement_unit_select.find('option').each(function(){
			$(this).prop('disabled',!($(this).attr('data-measurement-type-filter') == this_value));
		});
		if(this_measurement_unit_select.find('option:selected').is(':disabled')){
			this_measurement_unit_select.find('option:not(:disabled)').first().prop('selected',true);
		}
	});
</script>
@endsection
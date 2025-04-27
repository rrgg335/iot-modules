@extends('layouts.master')
@section('title','Measurement Units')
@section('styles')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 my-3">
			<div class="mb-5">
				<h3 class="mb-0">Measurement Units <button type="button" class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMeasurmentUnitModal">Add Measurement Unit</button></h3>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Measurement Type</th>
						<th>Prefix</th>
						<th>Suffix</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($measurement_units) && $measurement_units->isNotEmpty())
						@foreach($measurement_units as $measurement_unit)
							<tr>
								<td>{{ $measurement_unit->name }}</td>
								<td>{{ !empty($measurement_unit->measurement_type) ? $measurement_unit->measurement_type->name : '' }}</td>
								<td>{{ $measurement_unit->prefix }}</td>
								<td>{{ $measurement_unit->suffix }}</td>
								<td>
									<div class="d-inline-block dropdown">
										<a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown">
											<i data-feather="more-horizontal"></i>
										</a>
										<div class="dropdown-menu right">
											<a href="javascript:void(0)" class="dropdown-item text-warning update-measurment-unit" data-measurement-unit-id="{{ $measurement_unit->id }}">Edit</a>
											<a href="javascript:void(0)" class="dropdown-item text-danger" confirm-href="{{ route('measurement-units.delete',$measurement_unit->id) }}" confirm-text="Delete Module {{ $measurement_unit->name }}?">Delete</a>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">
								No Measurment Units Yet.
								<a href="javascript:void(0)" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addMeasurmentUnitModal">Add Measurment Unit</a>
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
<div id="addMeasurmentUnitModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Measurment Unit</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('measurement-units.store') }}">
					@csrf
					@include('measurement-units.form',['measurement_unit'=>null])
				</form>
			</div>
		</div>
	</div>
</div>
<div id="editMeasurmentUnitModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Measurment Unit</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('measurement-units.update') }}">
					@csrf
					@method('put')
					<div class="col-12">
						<div id="measurement-unit-edit-form" class="row"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).on('click','.update-measurment-unit',function(){
		var this_id = $(this).attr('data-measurement-unit-id');
		$.ajax({
			'url':'{{ route("measurement-units.edit") }}/'+this_id,
			'type':'get',
			'dataType':'html',
			'beforeSend':function(){
				$('#editMeasurmentUnitModal').modal('show');
				$('#measurement-unit-edit-form').empty();
			},
			'success':function(response){
				$('#measurement-unit-edit-form').html(response);
			},
			'error':function(){
				$('#measurement-unit-edit-form').html('@include("elements.error-loading-modal")');
			}
		});
	});
	$(document).ready(function(){
		@if(request('action') == 'create')
			$('#addMeasurmentUnitModal').modal('show');
			@if(!empty(request('measurement_type_id')))
				$('#addMeasurmentUnitModal [name="measurement_type_id"] option[value="{{ request('measurement_type_id') }}"]').prop('selected',true);
			@endif
		@endif
	});
</script>
@endsection
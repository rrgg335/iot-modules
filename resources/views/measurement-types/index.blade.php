@extends('layouts.master')
@section('title','Measurement Types')
@section('styles')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 my-3">
			<div class="mb-5">
				<h3 class="mb-0">Measurement Types <button type="button" class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMeasurmentTypeModal">Add Measurement Type</button></h3>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Value Type</th>
						<th>Units</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@if(!empty($measurement_types) && $measurement_types->isNotEmpty())
						@foreach($measurement_types as $measurement_type)
							<tr>
								<td>{{ $measurement_type->name }}</td>
								<td>
									<p class="d-block mb-0 maw-250p text-truncate">{{ $measurement_type->description }}</p>
								</td>
								<td>{{ ucfirst($measurement_type->value_type) }}</td>
								<td>{!! (!empty($measurement_type->measurement_units) && $measurement_type->measurement_units->isNotEmpty()) ? implode(',',$measurement_type->measurement_units->pluck('name')->toArray()) : '<a href="'.route('measurement-units.index',['action'=>'create','measurement_type_id'=>$measurement_type->id]).'">Add New</a>' !!}</td>
								<td>
									<div class="d-inline-block dropdown">
										<a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown">
											<i data-feather="more-horizontal"></i>
										</a>
										<div class="dropdown-menu right">
											<a href="javascript:void(0)" class="dropdown-item text-warning update-measurment-type" data-measurement-type-id="{{ $measurement_type->id }}">Edit</a>
											<a href="javascript:void(0)" class="dropdown-item text-danger" confirm-href="{{ route('measurement-types.delete',$measurement_type->id) }}" confirm-text="Delete Module {{ $measurement_type->name }}?">Delete</a>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">
								No Measurment Types Yet.
								<a href="javascript:void(0)" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addMeasurmentTypeModal">Add Measurment Type</a>
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
<div id="addMeasurmentTypeModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Measurment Type</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('measurement-types.store') }}">
					@csrf
					@include('measurement-types.form',['measurement_type'=>null])
				</form>
			</div>
		</div>
	</div>
</div>
<div id="editMeasurmentTypeModal" class="modal fade">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Measurment Type</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<form class="row" method="post" action="{{ route('measurement-types.update') }}">
					@csrf
					@method('put')
					<div class="col-12">
						<div id="measurement-type-edit-form" class="row"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).on('click','.update-measurment-type',function(){
		var this_id = $(this).attr('data-measurement-type-id');
		$.ajax({
			'url':'{{ route("measurement-types.edit") }}/'+this_id,
			'type':'get',
			'dataType':'html',
			'beforeSend':function(){
				$('#editMeasurmentTypeModal').modal('show');
				$('#measurement-type-edit-form').empty();
			},
			'success':function(response){
				$('#measurement-type-edit-form').html(response);
			},
			'error':function(){
				$('#measurement-type-edit-form').html('@include("elements.error-loading-modal")');
			}
		});
	});
</script>
@endsection
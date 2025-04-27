@if(!empty($module))
	<input type="hidden" name="module_id" value="{{ $module->id }}">
@endif
<div class="col-md-12 pt-3 pb-4">
	<div class="mb-4">
		<label for="module_name">Module Name</label>
		<input id="module_name" type="text" class="form-control" placeholder="Enter Module Name" name="module_name" required="required" value="{{ $module->name ?? '' }}" autocomplete="off">
	</div>
	<div class="mb-4">
		<label for="module_description">Description</label>
		<textarea id="module_description" class="form-control" name="module_description" placeholder="Enter Module Description" autocomplete="off">{{ $module->description ?? '' }}</textarea>
	</div>
	<h6>Module Measurements</h6>
	<div class="module-measurements">
		@if(!empty($module->measurements))
			@foreach($module->measurements as $module_measurement)
				@include('modules.measurement',['module_measurement'=>$module_measurement,'loop_index'=>$loop->index])
			@endforeach
		@endif
	</div>
	<a href="javascript:void(0)" class="badge bg-primary add-measurement">Add Measurement</a>
</div>
<div class="col-md-8 mx-auto mb-4">
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn w-100 btn-primary">Add Module</button>
		</div>
		<div class="col-md-6">
			<button type="button" class="btn w-100 btn-danger" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
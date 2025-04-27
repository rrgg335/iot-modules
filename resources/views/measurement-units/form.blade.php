@if(!empty($measurement_unit))
	<input type="hidden" name="measurement_unit_id" value="{{ $measurement_unit->id }}">
@endif
<div class="col-md-12 pt-2 pb-4">
	<div class="mb-3">
		<label>Measurement Type</label>
		<select class="form-control" name="measurement_type_id" placeholder="Select Measurement Type" required="required">
			@foreach(($measurement_types ?? []) as $measurement_type)
				<option value="{{ $measurement_type->id }}" @selected(!empty($measurement_unit->measurement_type_id) && $measurement_unit->measurement_type_id == $measurement_type->id)>{{ $measurement_type->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="mb-3">
		<label>Measurement Unit Name</label>
		<input type="text" class="form-control mb-1" placeholder="Enter Measurment Unit Name" name="measurement_unit_name" required="required" value="{{ $measurement_unit->name ?? '' }}" autocomplete="off">
		<small class="text-muted">Example: Celcius, Kilogram, Pound</small>
	</div>
	<div class="mb-3">
		<label>Measurement Unit Prefix</label>
		<input type="text" class="form-control mb-1" placeholder="Enter Measurment Unit Prefix" name="measurement_unit_prefix" value="{{ $measurement_unit->prefix ?? '' }}" autocomplete="off">
		<small class="text-muted">Example: $</small>
	</div>
	<div class="mb-3">
		<label>Measurement Unit Suffix</label>
		<input type="text" class="form-control mb-1" placeholder="Enter Measurment Unit Suffix" name="measurement_unit_suffix" value="{{ $measurement_unit->suffix ?? '' }}" autocomplete="off">
		<small class="text-muted">Example: Kg, °C</small>
	</div>
</div>
<div class="col-md-10 mx-auto mb-4">
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn w-100 btn-primary">{{!empty($measurement_unit) ? 'Update' : 'Add'}} Measurment Unit</button>
		</div>
		<div class="col-md-6">
			<button type="button" class="btn w-100 btn-danger" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
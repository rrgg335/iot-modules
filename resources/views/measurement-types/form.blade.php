@if(!empty($measurement_type))
	<input type="hidden" name="measurement_type_id" value="{{ $measurement_type->id }}">
@endif
<div class="col-md-12 pt-2 pb-4">
	<div class="mb-3">
		<label>Measurement Type Name</label>
		<input type="text" class="form-control mb-1" placeholder="Enter Measurment Type Name" name="measurement_type_name" required="required" value="{{ $measurement_type->name ?? '' }}" autocomplete="off">
		<small class="text-primary">Example: Temperature, Weight</small>
	</div>
	<div class="mb-3">
		<label>Description</label>
		<textarea class="form-control" name="measurement_type_description" placeholder="Enter Measurment Type Description" autocomplete="off">{{ $measurement_type->description ?? '' }}</textarea>
	</div>
	<div class="mb-3">
		<label>Value Type</label>
		<select class="form-control" name="measurement_type_value_type" placeholder="Select Value Type" required="required" autocomplete="off">
			<option value="text" @selected(($measurement_type->value_type ?? '') == 'text')>Text</option>
			<option value="number" @selected(($measurement_type->value_type ?? '') == 'number')>Number</option>
		</select>
	</div>
</div>
<div class="col-md-10 mx-auto mb-4">
	<div class="row">
		<div class="col-md-6">
			<button type="submit" class="btn w-100 btn-primary">{{!empty($measurement_type) ? 'Update' : 'Add'}} Measurment Type</button>
		</div>
		<div class="col-md-6">
			<button type="button" class="btn w-100 btn-danger" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
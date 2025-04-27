<div class="row mb-4 measurement-row">
	<div class="col-1 measurement-numeric-index">{{ !empty($loop_index) ? ($loop_index + 1 ): '' }}</div>
	<div class="col-10">
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label>Measurement Type</label>
					<select class="form-control measurement-type-select" placeholder="Select Measurement Type" required="required" autocomplete="off">
						@foreach(($measurement_types ?? []) as $measurement_type)
							<option value="{{ $measurement_type->id }}" @selected(!empty($module_measurement) && $module_measurement->measurement_type_id == $measurement_type->id)>{{ $measurement_type->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3">
					<label>Measurement Unit</label>
					<select class="form-control measurement-unit-select" placeholder="Select Measurement Unit" required="required" autocomplete="off">
						@foreach(($measurement_units ?? []) as $measurement_type => $measurement_type_units)
							<optgroup label="{{ $measurement_type }}">
								@foreach($measurement_type_units as $measurement_type_unit)
									<option value="{{ $measurement_type_unit->id }}" data-measurement-type-filter="{{ $measurement_type_unit->measurement_type_id }}" @selected(!empty($module_measurement) && $module_measurement->measurement_unit_id == $measurement_type_unit->id)>{{ $measurement_type_unit->name }}</option>
								@endforeach
							</optgroup>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="mb-3">
					<label>Minimum Value (If applicable)</label>
					<input type="text" class="form-control measurement-minimum-value" placeholder="Enter Minimum Value" autocomplete="off" value="{{ isset($module_measurement->min_value) ? $module_measurement->min_value : '' }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="mb-3">
					<label>Optimal Value (If applicable)</label>
					<input type="text" class="form-control measurement-optimal-value" placeholder="Enter Optimal Value" autocomplete="off" value="{{ isset($module_measurement->optimal_value) ? $module_measurement->optimal_value : '' }}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="mb-3">
					<label>Maximum Value (If applicable)</label>
					<input type="text" class="form-control measurement-maximum-value" placeholder="Enter Maximum Value" autocomplete="off" value="{{ isset($module_measurement->max_value) ? $module_measurement->max_value : '' }}">
				</div>
			</div>
		</div>
	</div>
	<div class="col-1 measurement-deletion-btn">
		<a href="javascript:void(0)" class="badge bg-danger svg-wh-15p remove-measurement">
			<i data-feather="trash-2"></i>
		</a>
	</div>
</div>
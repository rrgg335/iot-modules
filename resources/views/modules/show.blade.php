@extends('layouts.master')
@section('title','Module Details')
@section('content')
<div class="container-fluid">
	<h3 class="mb-5 mt-3">Module: {{ !empty($module->name) ? $module->name : '' }}<span class="float-end">{!! !empty($module->current_status_badge) ? $module->current_status_badge : '' !!}</span></h3>
	<div class="row">
		@if(!empty($module->measurements) && $module->measurements->isNotEmpty())
			@foreach($module->measurements as $measurement)
				@if(!empty($measurement->results) && $measurement->results->isNotEmpty())
					<div class="col-12 mb-3">
						<div class="card h-100">
							<div class="card-body">
								<div class="mb-5">
									<h5 class="text-center mb-3">{{ $measurement->measurement_type->name }} ({{ $measurement->measurement_unit->name }})</h5>
									<canvas class="w-100 chart-{{ $measurement->id }}"></canvas>
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		@endif
		<div class="col-12 col-xl-6 mb-3">
			<div class="card h-100">
				<div class="card-body">
					<h5 class="mb-4 mt-3">Details</h5>
					@if(!empty($module->name))
						<div class="details-section">
							<div>Name</div>
							<div>{{ $module->name }}</div>
						</div>
					@endif
					@if(!empty($module->current_status_badge))
						<div class="details-section">
							<div>Current Status</div>
							<div>{!! $module->current_status_badge !!}</div>
						</div>
					@endif
					@if(!empty($module->description))
						<div class="details-section">
							<div>Description</div>
							<div>{!! nl2br(e($module->description)) !!}</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		@if(!empty($module->measurements) && $module->measurements->isNotEmpty())
			<div class="col-12 col-xl-6 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<h5 class="mb-4 mt-3">Measurements</h5>
						<ol>
							@foreach($module->measurements as $measurement)
								<li class="mb-2">
									@if(!empty($measurement->measurement_type->name))
										<p class="mb-0">Measurement Type: {{ $measurement->measurement_type->name }}</p>
									@endif
									@if(!empty($measurement->measurement_unit->name))
										<p class="mb-0">Measurement Unit: {{ $measurement->measurement_unit->name }}</p>
									@endif
									@if(isset($measurement->min_value))
										<p class="mb-0">Maximum: {{ $measurement->measurement_unit->prefix }}{{ $measurement->min_value }}{{ $measurement->measurement_unit->suffix }}</p>
									@endif
									@if(isset($measurement->optimal_value))
										<p class="mb-0">Maximum: {{ $measurement->measurement_unit->prefix }}{{ $measurement->optimal_value }}{{ $measurement->measurement_unit->suffix }}</p>
									@endif
									@if(isset($measurement->max_value))
										<p class="mb-0">Maximum: {{ $measurement->measurement_unit->prefix }}{{ $measurement->max_value }}{{ $measurement->measurement_unit->suffix }}</p>
									@endif
								</li>
							@endforeach
						</ol>
					</div>
				</div>
			</div>
			<div class="col-12 col-xl-6 mb-3">
				<div class="card h-100">
					<div class="card-body">
						<h5 class="mb-4 mt-3">Current Values</h5>
						<ol>
							@foreach($module->measurements as $measurement)
								@if(isset($measurement->current_value))
									<li class="mb-2">
											<p class="mb-0">{{ $measurement->measurement_type->name }}: {{ $measurement->measurement_unit->prefix }}{{ $measurement->current_value }}{{ $measurement->measurement_unit->suffix }}</p>
									</li>
								@endif
							@endforeach
						</ol>
					</div>
				</div>
			</div>
		@endif
		@if(!empty($module->activity) && $module->activity->isNotEmpty())
			<div class="col-12 col-xl-6 mb-3">
				<div class="card">
					<div class="card-body">
						<h5 class="mb-4 mt-3">Activity</h5>
						<div class="mah-250p overflow-auto pe-3">
							@foreach($module->activity->sortByDesc('created_at') as $activity)
								<div class="mb-3">
									<div class="text-{{ $activity->activity_type }}">{{ $activity->activity }}</div>
									<div class="text-muted">{{ $activity->created_at->diffForHumans() }}</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('js/chart.min.js') }}"></script>
	<script>
		@if(!empty($module->measurements) && $module->measurements->isNotEmpty())
			@foreach($module->measurements as $measurement)
				@if(!empty($measurement->results) && $measurement->results->isNotEmpty())
					new Chart($('.chart-{{ $measurement->id }}').get(0),{
						type: 'line',
						data: {
							labels: [
								'{!! implode("','",$measurement->results->sortByDesc("created_at")->take(10)->pluck("created_at")->map(fn($date) => now()->parse($date)->format("h:i:s A"))->reverse()->toArray()) !!}'
							],
							datasets: [
								{
									label: 'Recorded Value',
									data: ['{!! implode("','",$measurement->results->sortByDesc("created_at")->take(10)->pluck("value")->reverse()->toArray()) !!}'],
									borderColor: 'rgba(54,162,235,1)',
									borderWidth: 2,
									fill: false
								},
								@if(isset($measurement->optimal_value))
								{
									label: 'Optimal Value',
									data: [{{ implode(",",array_fill(0,min(10,$measurement->results->count()),$measurement->optimal_value)) }}],
									borderColor: 'rgba(75, 192, 192, 1)',
									borderWidth: 2,
									borderDash: [2,5],
									fill: false
								},
								@endif
								@if(isset($measurement->min_value))
								{
									label: 'Minimum Value',
									data: [{{ implode(",",array_fill(0,min(10,$measurement->results->count()),$measurement->min_value)) }}],
									borderColor: 'rgba(255, 159, 64, 1)',
									borderWidth: 2,
									borderDash: [2,5],
									fill: false
								},
								@endif
								@if(isset($measurement->max_value))
								{
									label: 'Maximum Value',
									data: [{{ implode(",",array_fill(0,min(10,$measurement->results->count()),$measurement->max_value)) }}],
									borderColor: 'rgba(255, 99, 132, 1)',
									borderWidth: 2,
									borderDash: [2,5],
									fill: false
								},
								@endif
							]
						},
						options: {
							plugins:{
								legend:{
									display: true,
								},
								tooltip: {
									displayColors: false,
									enabled: true,
									callbacks: {
										label: function(context){
											return '{{ $measurement->measurement_unit->prefix }}'+context.parsed.y+'{{ $measurement->measurement_unit->suffix }}';
										}
									}
								}
							},
							responsive: true,
							scales: {
								x: {
									beginAtZero: true
								},
								y: {
									beginAtZero: true
								}
							},
						}
					});
				@endif
			@endforeach
		@endif

	</script>
@endsection
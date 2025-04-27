<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">
	<title>@yield('title') - {{ env('APP_NAME','Ball-Bucket System') }}</title>
	@yield('styles')
</head>
<body>
	<div id="navbar" class="bg-light">
		<nav class="navbar">
			<ul class="navbar-nav">
				<li class="nav-item">
					<h5 class="px-3 mb-4">IOT Simulator</h5>
				</li>
				<li class="nav-item px-3">
					<a class="nav-link {{ request()->is('modules*') ? 'active' : '' }}" href="{{ route('modules.index') }}">All Modules</a>
				</li>
				<li class="nav-item px-3">
					<a href="javascript:void(0)" class="nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#settingsSubmenu">Settings</a>
					<ul id="settingsSubmenu" class="collapse list-unstyled ps-3 {{ (request()->is('measurement-types*') || request()->is('measurement-units*')) ? 'show' : '' }}">
						<li class="">
							<a class="nav-link {{ (request()->is('measurement-types*')) ? 'active' : '' }}" href="{{ route('measurement-types.index') }}">Measurement Types</a>
						</li>
						<li class="">
							<a class="nav-link {{ (request()->is('measurement-units*')) ? 'active' : '' }}" href="{{ route('measurement-units.index') }}">Measurement Units</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
	<div id="content">
		<div class="container-fluid text-end">
			<a href="{{ url()->full() }}" class="btn btn-sm btn-primary">Refresh</a>
		</div>
		@if(session()->has('success') || session()->has('error'))
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-10 mx-auto my-2">
						@if(session()->has('error') && !empty(session()->get('error')))
							<div class="alert alert-danger alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								{{ session()->get('error') }}
							</div>
						@endif
						@if(session()->has('success') && !empty(session()->get('success')))
							<div class="alert alert-success alert-dismissible fade show">
								<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								{{ session()->get('success') }}
							</div>
						@endif
					</div>
				</div>
			</div>
		@endif
		@yield('content')
	</div>
	@yield('modals')
	<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/feather/feather.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>
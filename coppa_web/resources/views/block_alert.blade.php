@if (session('flashDataSuccess'))
	<div class="alert alert-success">
		{{ session('flashDataSuccess') }}
	</div>
@endif
@if (session('flashDataDanger'))
	<div class="alert alert-danger">
		{{ session('flashDataDanger') }}
	</div>
@endif
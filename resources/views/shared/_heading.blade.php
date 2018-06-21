<div class="row mt-4">
	<div class="col">
		<h4>{{ $heading }}</h4>
	</div>
	<div class="col">
		@if($should_show_action)
			<a href="{{ $action_url }}" class="btn btn-primary float-right">{{ $action_name }}</a>
		@endif
	</div>
</div>
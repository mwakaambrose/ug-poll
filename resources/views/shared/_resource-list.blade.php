<div class="row">
	<div class="col">
		<div class="mt-4">
			{{-- <div class="card-body"> --}}
				@if($resources->count() == 0)
					<h4>No resource created yet.</h4>
				@endif
				@foreach($resources as $resource)
					<div class="list-group-item">
						<a href="/{{$route_name}}/{{$resource->id}}"><h5>{{ $resource->name }}</h5></a>
						<p>{{ $resource->description }}</p>
						<p>Send time: {{ $resource->send_time }}</p>
						 
					</div>
				@endforeach
			{{-- </div> --}}
		</div>
	</div>
</div>
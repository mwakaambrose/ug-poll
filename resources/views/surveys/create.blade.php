@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared._heading', [
        'heading' => 'New Survey',
        'should_show_action' => false,
        'action_url' => '/surveys/create',
        'action_name' => 'New Survey'
    ])

    <div class="row">
		<div class="col">
			<div class="card mt-4">
				<div class="card-body">
					@include('surveys.shared._form',[
						'method' => 'POST',
						'url' => '/surveys',
						'survey' => $survey
					])
				</div>
			</div>
		</div>
	</div>

</div>
@endsection
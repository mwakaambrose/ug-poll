@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared._heading', [
        'heading' => 'Surveys',
        'should_show_action' => true,
        'action_url' => '/surveys/create',
        'action_name' => 'New Survey'
    ])

    @include('shared._resource-list', [
        'resources' => $surveys,
        'route_name' => 'surveys'
    ])
</div>
@endsection
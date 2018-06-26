@extends('layouts.app')

@section('content')
    @include('shared._heading', [
        'heading' => 'SMS Actions',
        'should_show_action' => true,
        'action_url' => '/sms-actions/create',
        'action_name' => 'New SMS action'
    ])

    <div class="card mt-3">
        <div class="card-body">
            @foreach($sms as $action)
                <h5>{{ $action->sms_action }}</h5>
                <p class="text-muted small"><span>Min weight <strong>{{ $action->minimum_weight }}</strong></span> | <span>Max weight <strong>{{ $action->maximum_weight }}</strong></span></p>
            @endforeach
        </div>
    </div>
@endsection
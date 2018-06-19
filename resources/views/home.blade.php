@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Surveys</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <strong>You are logged in!</strong> List all the created surveys and provide links to their analytics and 
                    call to actions.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

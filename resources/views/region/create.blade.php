@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create regions</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{route('region.store')}}">
                        @csrf
                        <label>Region Name</label>
                        <input type="text" name="region" class="form-control">
                        <br>
                        <button id="save_region">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
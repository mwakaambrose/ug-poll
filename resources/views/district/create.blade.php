@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Districts in {{$regions->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{route('district.store')}}">
                        @csrf
                        <label> Name</label>
                        <input type="text" name="name" class="form-control">

                        <input type="hidden" name="region_id" value="{{$regions->id}}">
                        <br>
                        <button id="save_region">Save</button>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

    <div class="col-sm-12">
        <h4>Add New Region</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/regions">
                    @csrf
                    <div class="form-group">
                        <label>Region Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection

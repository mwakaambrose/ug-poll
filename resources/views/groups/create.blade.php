@extends('layouts.app')
@section('content')

    <div class="col-sm-12">

        <h4>Create New Survey Group</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/groups">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection

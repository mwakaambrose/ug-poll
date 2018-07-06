@extends('layouts.app')

@section('content')

    <div class="col-sm-12">
        <h4>Add SMS Template to {{$category->name}}</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/category_message">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        <label>Message</label>
                       <textarea name="description" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection
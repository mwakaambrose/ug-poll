@extends('layouts.app_fancy')

@section('content')
    <div class="col-md-12">        
        <div class="card">
            <div class="card-header">
                <blockquote class="blockquote">
                    <p class="mb-0">Add SMS Template to Category: {{$category->name}}</p>
                </blockquote>
            </div>
            <div class="card-body">
                <form method="POST" action="/category_message">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        <label>Message</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    
                    <button class="btn btn-success float-right">Save</button>
                </form>
            </div>
            <div class="card-footer">
                <a class="btn btn-primary float-right" href="{{ url('category',$category->id) }}">View Message</a>
            </div>
        </div>
    </div>

@endsection
@extends('layouts.app_fancy')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <blockquote class="blockquote">
                    <p class="mb-0">All SMS Templates in Category: {{ $category->name }}</p>
                </blockquote>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <ul class="list-group">
                    @foreach($category->categorymessage as $i=>$message)
                        <li class="list-group-item">{{ $i+1 }}. {{ $message->description }}
                            <form class="float-right" action="/category_message/{{ $message->id }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-danger" value="Delete "/>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-footer">
                <a class="btn btn-primary float-right" href="{{ url('category',[$category->id,'edit']) }}">Add Message</a>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h4>All SMS Templates in {{$category->name}}</h4>

               

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     <a class="btn btn-primary" style="float: right;" href="{{route('category.edit',$category->id)}}">Add Message</a>
                     <br><br>

                    <ol>
                        @foreach($category->categorymessage as $message)
                          <li>
                            {{$message->description}}
                             <form style="float: right;" action="/category_message/{{ $message->id }}" method="POST">
                                {{method_field('DELETE')}}
                                {{ csrf_field() }}
                                <span class="glyphicon glyphicon-trash"></span>
                                <input type="submit" class="btn btn-danger" value="Delete "/>
                            </form>
                          </li>
                        @endforeach
                    </ol>                              
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Out Box for {{$survey->name}}</div>

                <a href="{{route('surveys.show',$survey->id)}}">Back</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                       <th>Date</th> <th>phone number</th> <th>Question</th> <th>Status</th> <th>Cost</th>

                         @foreach($my_out_box as $outbox)
                         <tr>
                             <td>{{$outbox->created_at}}</td>
                             <td>{{$outbox->phone_number}}</td>
                             <td>{{$outbox->description}}</td>
                             <td>{{$outbox->status}}</td>
                             <td>{{$outbox->cost}}</td>
                             
                            
                         </tr>
                          
                        @endforeach
                    </table>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
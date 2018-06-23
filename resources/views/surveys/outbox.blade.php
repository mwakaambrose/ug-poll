@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Out Box for {{$survey->name}}
                        </div>
                        <div class="col">
                            <a href="{{route('surveys.show', $survey->id)}}" class="btn btn-default float-right">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
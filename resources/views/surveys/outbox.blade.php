@extends('layouts.app_fancy')
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        Out Box for {{$survey->name}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="data_table">
                    <thead>
                        <th>Date</th> <th>Phone number</th> <th>Question</th> <th>Status</th> <th>Cost</th>
                    </thead>

                    <tbody>
                            @foreach($my_out_box as $outbox)
                            <tr>
                                <td>{{$outbox->created_at}}</td>
                                <td>{{$outbox->phone_number}}</td>
                                <td>{{$outbox->description}}</td>
                                <td>{{$outbox->status}}</td>
                                <td>{{$outbox->cost}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>           
            </div>
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')
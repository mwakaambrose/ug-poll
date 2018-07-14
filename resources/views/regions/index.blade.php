@extends('layouts.app')

@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>Available Regions</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_regions">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Region
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="data_table">
                    <thead>
                        <th>Region</th>
                        <th>Districts</th>
                        <th>Actions</th>
                    </thead>

                    <tbody>

                    @foreach($regions as $region)
                        <tr>
                            <td>{{$region->name}}</td>
                            <td>
                                @foreach($region->districts as $district)
                                    {{ $district->name }},
                                @endforeach
                            </td>
                            <td>
                                <a href="/regions/{{ $region->id }}/edit">Add District</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_regions" tabindex="-1" role="dialog" aria-labelledby="modal_add_regionsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_regionsLongTitle">Add New Region</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_region" class="form-horizontal">
                    @csrf
                    <div class="form-group has-danger" id="add_error">
                        <label>Region Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                        <!-- <form method="POST" action="/regions"> -->
                </form>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_region" class="btn btn-primary">Add Region</button>
            </div>
            </div>
        </div>
    </div>

@endsection
@include('shared._datatable_scripts')

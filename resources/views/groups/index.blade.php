@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Groups</h4>
        </div>
        
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_groups">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Group
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="group_data_table">
                    <thead>
                        <th>Name</th>
                        <th>Respondents</th>
                        <th class="text-center">Actions</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_groups" tabindex="-1" role="dialog" aria-labelledby="modal_add_groupsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_groupsLongTitle">Create New Survey Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_group" class="form-horizontal">
                    @csrf
                    <div class="form-group has-danger" id="add_error">
                        <label>Survey Group</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                </form>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_group" class="btn btn-primary">Add Group</button>
            </div>
            </div>
        </div>
    </div>

@endsection
@include('shared._datatable_scripts')

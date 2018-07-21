@extends('layouts.app')

@section('content')
    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>Surveys</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_survey">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Survey
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="survey_data_table">
                    <thead>
                        <th>Survey Name</th>
                        <th>Description</th>
                        <th class="text-center">Send Date</th>
                        <th class="text-center">Add Question</th>
                        <th class="text-center">Questions</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_survey" tabindex="-1" role="dialog" aria-labelledby="modal_add_surveyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_surveyLongTitle">New Survey</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_survey" class="form-horizontal">
                    @csrf
                    <div id="name_error" class="form-group has-danger">
                        <label>Survey Name <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div id="description_error" class="form-group has-danger">
                        <label>Survey Description <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                
                    <div id="group_id_error" class="form-group  has-danger">
                        <label>Choose a group that will respond to this survey <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <select class="form-control" id="group_id" name="group_id">
                            <option></option>
                            @foreach($group as $groups)
                              <option value="{{$groups->id}}">{{$groups->name}}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div id="send_time_error" class="form-group">
                        <label>What time do we send the survey? <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <input type="date" name="send_time" id="send_time" class="form-control">
                    </div>
                </form>
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_survey" class="btn btn-primary">Add Survey</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')
@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Respondents</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_respondents">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Respondent
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="data_table">
                    <thead>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Language</th>
                        <th>Literacy Level</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Groups</th>
                     </thead>

                    <tbody>
                    @foreach($respondents as $respondent)
                        <tr>
                            <td>{{ $respondent->name }}</td>
                            <td>{{ $respondent->phone_number }}</td>
                            <td>{{$respondent->language}}</td>
                            <td>{{$respondent->level_of_education}}</td>
                            <td>{{ $respondent->address }}</td>
                            <td>{{ $respondent->gender }}</td>
                            <td>{{ $respondent->email_address }}</td>
                            <td>{{ isset($respondent->district) ? $respondent->district->name : '' }}</td>
                            <td>
                                @foreach($respondent->groups as $group)
                                    <a href="/groups/{{ $group->id }}">{{ $group->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_respondents" tabindex="-1" role="dialog" aria-labelledby="modal_add_respondentsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_respondentsLongTitle">Create Respondent Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_respondent" class="form-horizontal">
                    @csrf
                    <!-- <div class="form-group has-danger" id="add_error">
                        <label>Survey Group</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div> -->
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">(Required)</span></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">(Required)</span></label>
                                <input type="number" id="phone_number" name="phone_number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Address <span class="text-danger">(Required)</span></label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Gender <span class="text-danger">(Required)</span></label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email adress (Optional)</label>
                                <input type="email_address" id="email_address" name="email_adress" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>District</label>
                                <select id="district_id" name="district_id" class="form-control">
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose the group</label>
                                <select id="group" name="group[]" class="form-control" multiple="multiple">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose lunguage</label>
                                <select id="language" name="language" class="form-control">
                                    <option></option>
                                    <option value="English">English</option>
                                    <option value="Luganda">Luganda</option>                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose level of literacy</label>
                                <select id="level_of_education" name="level_of_education" class="form-control">
                                    <option></option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>                               
                                </select>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_respondent" class="btn btn-primary">Save</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')

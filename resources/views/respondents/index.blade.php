@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Respondents&nbsp;&nbsp;&nbsp;<span class="fa fa-question-circle"  data-toggle="tooltip" data-placement="bottom" title="RESPONDENTS&#013;&#013;-You Can Add a New Respondent by Clicking Add New Respondent Button&#013;-The Table Below Displays the Registered Respondents with their respective Details and corresponding Groups&#013;-You Can for a  Respondent By Typing the name of that person in the Search Field Below&#013;-You Can Copy ,Export The Respondents as an Excel Sheet,CSV,PDF and even print the Respondent Data&#013;"></span></h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_respondents">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New Respondent
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" width="100%" id="respondents_data_table">
                    <thead>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Language</th>
                        <th>Literacy Level</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>District</th>
                        <th>Groups</th>
                     </thead>
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
            <div class="text-center"><b><span id="error_message" class="text-danger"></span></b></div>
            <div class="modal-body">
                <form id="add_respondent" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div id="name_error" class="form-group has-danger">
                                <label>Name <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div id="phone_number_error" class="form-group has-danger">
                                <label>Phone Number <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                                <input type="number" id="phone_number" name="phone_number" placeholder="2567XXXXXXXX" class="form-control" required>
                            </div>
                            <div id="address_error" class="form-group has-danger">
                                <label>Address <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                                <input type="text" id="address" name="address" class="form-control" required>
                            </div>

                            <div id="gender_error" class="form-group has-danger">
                                <label>Gender <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email adress (Optional)</label>
                                <input type="email" id="email_address" name="email_address" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div id="district_id_error" class="form-group has-danger">
                                <label>District <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                                <select id="district_id" name="district_id" class="form-control">
                                <option></option>
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
@push('scripts')
<script type="text/javascript">
    var respondentTable = $('#respondents_data_table').DataTable({
        "ordering": false,
        "ajax": {
            "url": "{{ url('dt_respondents') }}",
            "dataSrc": ""
        },
        dom: 'Bfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                messageTop: ' '
            },
            {
                extend: 'csv',
                messageTop: ' '
            },
            {
                extend: 'pdf',
                messageTop: ' '
            },
            {
                extend: 'print',
                messageTop: null
            }
        ]
    });

    $('#submit_respondent').click(function(e){
        e.preventDefault();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        
        $.ajax({
            url: "{{ url('/respondents') }}",
            method: "POST",
            data: $('form#add_respondent').serialize(),
            dataType: 'json',
            success: function(msg){
                    $("#modal_add_respondents").modal('hide');
                    $("#add_respondent")[0].reset();
                    respondentTable.ajax.reload(null,false);
                },
            error: function(msg){
                    var error = msg.responseJSON;
                    $("#error_message").html(error.message);
                    var all_errors = error.errors;
                    if('address' in all_errors){
                        $('#address').addClass('is-invalid');
                        if($('#show_address_error').length==0){
                            $('#address_error').append('<span id="show_address_error" style="font-size: 13px;" class="text-danger">'+all_errors.address[0]+' </span>');
                        }else{
                            $('#show_address_error').remove();
                            $('#address_error').append('<span id="show_address_error" style="font-size: 13px;" class="text-danger">'+all_errors.address[0]+' </span>');
                        }
                    }else{
                        $('#address').removeClass('is-invalid');
                        $('#show_address_error').remove();
                    }

                    if('gender' in all_errors){
                        $('#gender').addClass('is-invalid');
                        if($('#show_gender_error').length==0){
                            $('#gender_error').append('<span id="show_gender_error" style="font-size: 13px;" class="text-danger">'+all_errors.gender[0]+' </span>');
                        }else{
                            $('#show_gender_error').remove();
                            $('#gender_error').append('<span id="show_gender_error" style="font-size: 13px;" class="text-danger">'+all_errors.gender[0]+' </span>');
                        }
                    }else{
                        $('#gender').removeClass('is-invalid');
                        $('#show_gender_error').remove();
                    }

                    if('name' in all_errors){
                        $('#name').addClass('is-invalid');
                        if($('#show_name_error').length==0){
                            $('#name_error').append('<span id="show_name_error" style="font-size: 13px;" class="text-danger">'+all_errors.name[0]+' </span>');
                        }else{
                            $('#show_name_error').remove();
                            $('#name_error').append('<span id="show_name_error" style="font-size: 13px;" class="text-danger">'+all_errors.name[0]+' </span>');
                        }
                    }else{
                        $('#name').removeClass('is-invalid');
                        $('#show_name_error').remove();
                    }

                    if('phone_number' in all_errors){
                        $('#phone_number').addClass('is-invalid');
                        if($('#show_phone_number_error').length==0){
                            $('#phone_number_error').append('<span id="show_phone_number_error" style="font-size: 13px;" class="text-danger">'+all_errors.phone_number[0]+' </span>');
                        }else{
                            $('#show_phone_number_error').remove();
                            $('#phone_number_error').append('<span id="show_phone_number_error" style="font-size: 13px;" class="text-danger">'+all_errors.phone_number[0]+' </span>');
                        }
                    }else{
                        $('#phone_number').removeClass('is-invalid');
                        $('#show_phone_number_error').remove();
                    }

                    if('district_id' in all_errors){
                        $('#district_id').addClass('is-invalid');
                        if($('#show_district_id_error').length==0){
                            $('#district_id_error').append('<span id="show_district_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.district_id[0]+' </span>');
                        }else{
                            $('#show_district_id_error').remove();
                            $('#district_id_error').append('<span id="show_district_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.district_id[0]+' </span>');
                        }
                    }else{
                        $('#district_id').removeClass('is-invalid');
                        $('#show_district_id_error').remove();
                    }
                }
        });
    });
</script>
@endpush
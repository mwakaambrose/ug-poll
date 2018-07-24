@extends('layouts.app')
@push('styles')  
	<style>	
		tbody td:nth-child(4), tbody td:nth-child(5), tbody td:nth-child(6), tbody td:nth-child(7){
			text-align: center;
		}
	</style>	
@endpush
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
                <span id="send_info" style="display: none;"><b class='text-success'>The Survey is in progress ...</b></span>
                <table class="nowrap table table-bordered table-striped" id="survey_data_table">
                    <thead>
                        <th>Survey Name</th>
                        <th>Description</th>
                        <th class="text-center">Send Date</th>
                        <th class="text-center">Add Question</th>
                        <th class="text-center">Send Now</th>
                        <th class="text-center">Outbox</th>
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
            <div class="text-center"><b><span id="error_message" class="text-danger"></span></b></div>
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
@push('scripts')
    <script type="text/javascript">
        $('#submit_survey').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            $.ajax({
                url: "{{ url('/surveys') }}",
                method: "POST",
                data: $('form#add_survey').serialize(),
                dataType: 'json',
                success: function(msg){
                        $("#modal_add_survey").modal('hide');
                            $("#add_survey")[0].reset();
                            surveyTable.ajax.reload(null,false);
                        },
                error: function(msg){
                        var error = msg.responseJSON;
                        $("#error_message").html(error.message);
                        var all_errors = error.errors;
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

                        if('description' in all_errors){
                            $('#description').addClass('is-invalid');
                            if($('#show_description_error').length==0){
                                $('#description_error').append('<span id="show_description_error" style="font-size: 13px;" class="text-danger">'+all_errors.description[0]+' </span>');
                            }else{
                                $('#show_description_error').remove();
                                $('#description_error').append('<span id="show_description_error" style="font-size: 13px;" class="text-danger">'+all_errors.description[0]+' </span>');
                            }
                        }else{
                            $('#description').removeClass('is-invalid');
                            $('#show_description_error').remove();
                        }

                        if('group_id' in all_errors){
                            $('#group_id').addClass('is-invalid');
                            if($('#show_group_id_error').length==0){
                                $('#group_id_error').append('<span id="show_group_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.group_id[0]+' </span>');
                            }else{
                                $('#show_group_id_error').remove();
                                $('#group_id_error').append('<span id="show_group_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.group_id[0]+' </span>');
                            }
                        }else{
                            $('#group_id').removeClass('is-invalid');
                            $('#show_group_id_error').remove();
                        }

                        if('send_time' in all_errors){
                            $('#send_time').addClass('is-invalid');
                            if($('#show_send_time_error').length==0){
                                $('#send_time_error').append('<span id="show_send_time_error" style="font-size: 13px;" class="text-danger">'+all_errors.send_time[0]+' </span>');
                            }else{
                                $('#show_send_time_error').remove();
                                $('#send_time_error').append('<span id="show_send_time_error" style="font-size: 13px;" class="text-danger">'+all_errors.send_time[0]+' </span>');
                            }
                        }else{
                            $('#send_time').removeClass('is-invalid');
                            $('#show_send_time_error').remove();
                        }
                    }
            });
        });

        var surveyTable = $('#survey_data_table').DataTable({
            "ordering": false,
            "ajax": {
                "url": "{{ url('dt_surveys') }}",
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

		setInterval(function() {
			verify_response()
		}, 1000);
		
		function verify_response() {
			$.ajax({
                type: "GET",
                url: "{{route('outbox.create')}}",
                data: {                
                    _token: "{{Session::token()}}" },
                success: function(result){
                console.log(result);
                }
            })
		}

        $('#survey_data_table').on("click", '#process_survey', function(e){
            e.preventDefault();
            var id = $(this).attr('href');

            $.ajax({
                beforeSend: function(){
                    $("#send_info").show();
                },
                complete: function(){
                    $("#send_info").hide();
                },
                url: "{{ url('/outbox') }}/",
                method: "POST",
                data: { survey_id: survey_id, _token: '{{csrf_token()}}' },
                dataType: 'json',
                success: function(msg){
                        console.log(result);
                        surveyTable.ajax.reload(null,false);
                    },
                error: function(xhr){
                        console.log(xhr.responseText);
                    }
            });
        });

    </script>
@endpush
@extends('layouts.app')

@section('content')
    
    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>SMS Actions&nbsp;&nbsp;&nbsp;<span class="fa fa-question-circle small" title='SMS Actions&#013;&#013; This Page Displays the Set Call to Action Responses after a Survey is conducted ,The Possible values are numerical values that are summed up and a range is set for particular responses received from the respondents and an appopriate Action is sent to the Respondent after he/She Receives the Airtime Reward&#013; - To set a new Call to SMS action click the New SMS action button&#013;- You can Export the Call to Actions Records as CSV,Excel Sheet and PDF'></span></h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_sms_actions">
            <i class="fa fa-plus" aria-hidden="true"></i> New SMS Action
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="nowrap table table-bordered table-striped" id="sms_action_data_table">
                    <thead>
                        <th>#</th>
                        <th>Survey</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Action Category</th>
                        <th>Action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_sms_actions" tabindex="-1" role="dialog" aria-labelledby="modal_add_sms_actionsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_add_sms_actionsLongTitle">Create SMS Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="text-center"><b><span id="error_message" class="text-danger"></span></b></div>
            <div class="modal-body">
                <form id="add_sms_action" class="form-horizontal">
                    @csrf
                    <div id="survey_id_error" class="form-group has-danger">
                        <label>Choose a survey <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <select id="survey_id" name="survey_id" class="form-control">
                            <option></option>
                            @foreach($survey as $surveys)
                                <option value="{{$surveys->id}}">{{$surveys->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="minimum_weight_error" class="form-group has-danger">
                        <label>Minimum Weight <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <input type="number" step="any" id="minimum_weight" name="minimum_weight" class="form-control">
                    </div>

                    <div id="maximum_weight_error" class="form-group has-danger">
                        <label>Maximum Weight <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <input type="number" step="any" id="maximum_weight" name="maximum_weight" class="form-control">
                    </div>

                    <div id="category_id_error" class="form-group has-danger">
                        <label>SMS Action Category <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <select class="form-control" name="category_id" id="category_id" required="required">
                            <option></option>
                            @foreach($category as $categories)
                                <option value="{{$categories->id}}">{{$categories->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submit_sms_action" class="btn btn-primary">Save</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')
@push('scripts')
    <script type="text/javascript">
        var sms_actionTable = $('#sms_action_data_table').DataTable({
            "ordering": false,
            "ajax": {
                "url": "{{ url('dt_sms_actions') }}",
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
        $('#sms_action_data_table').on("click", '#delete', function(e){
            e.preventDefault();
            var id = $(this).attr('href');

            $.ajax({
                url: "{{ url('/sms-actions') }}/"+id,
                method: "POST",
                data: { _method: 'delete', _token: '{{csrf_token()}}' },
                dataType: 'json',
                success: function(msg){
                        sms_actionTable.ajax.reload(null,false);
                    },
                error: function(xhr){
                        console.log(xhr.responseText);
                    }
            });
        });
        $('#submit_sms_action').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            $.ajax({
                url: "{{ url('/sms-actions') }}",
                method: "POST",
                data: $('form#add_sms_action').serialize(),
                dataType: 'json',
                success: function(msg){
                        $("#modal_add_sms_actions").modal('hide');
                        $("#add_sms_action")[0].reset();
                        sms_actionTable.ajax.reload(null,false);
                    },
                error: function(msg){
                        var error = msg.responseJSON;
                        $("#error_message").html(error.message);

                        var all_errors = error.errors;
                        if('survey_id' in all_errors){
                            $('#survey_id').addClass('is-invalid');
                            if($('#show_survey_id_error').length==0){
                                $('#survey_id_error').append('<span id="show_survey_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.survey_id[0]+' </span>');
                            }else{
                                $('#show_survey_id_error').remove();
                                $('#survey_id_error').append('<span id="show_survey_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.survey_id[0]+' </span>');
                            }
                        }else{
                            $('#survey_id').removeClass('is-invalid');
                            $('#show_survey_id_error').remove();
                        }

                        if('minimum_weight' in all_errors){
                            $('#minimum_weight').addClass('is-invalid');
                            if($('#show_minimum_weight_error').length==0){
                                $('#minimum_weight_error').append('<span id="show_minimum_weight_error" style="font-size: 13px;" class="text-danger">'+all_errors.minimum_weight[0]+' </span>');
                            }else{
                                $('#show_minimum_weight_error').remove();
                                $('#minimum_weight_error').append('<span id="show_minimum_weight_error" style="font-size: 13px;" class="text-danger">'+all_errors.minimum_weight[0]+' </span>');
                            }
                        }else{
                            $('#minimum_weight').removeClass('is-invalid');
                            $('#show_minimum_weight_error').remove();
                        }
                        
                        if('maximum_weight' in all_errors){
                            $('#maximum_weight').addClass('is-invalid');
                            if($('#show_maximum_weight_error').length==0){
                                $('#maximum_weight_error').append('<span id="show_maximum_weight_error" style="font-size: 13px;" class="text-danger">'+all_errors.maximum_weight[0]+' </span>');
                            }else{
                                $('#show_maximum_weight_error').remove();
                                $('#maximum_weight_error').append('<span id="show_maximum_weight_error" style="font-size: 13px;" class="text-danger">'+all_errors.maximum_weight[0]+' </span>');
                            }
                        }else{
                            $('#maximum_weight').removeClass('is-invalid');
                            $('#show_maximum_weight_error').remove();
                        }

                        if('category_id' in all_errors){
                            $('#category_id').addClass('is-invalid');
                            if($('#show_category_id_error').length==0){
                                $('#category_id_error').append('<span id="show_category_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.category_id[0]+' </span>');
                            }else{
                                $('#show_category_id_error').remove();
                                $('#category_id_error').append('<span id="show_category_id_error" style="font-size: 13px;" class="text-danger">'+all_errors.category_id[0]+' </span>');
                            }
                        }else{
                            $('#category_id').removeClass('is-invalid');
                            $('#show_category_id_error').remove();
                        }
                    }
            });
        });
    </script>
@endpush
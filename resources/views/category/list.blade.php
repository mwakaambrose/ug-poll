@extends('layouts.app')
@push('styles')  
	<style>	
		tbody td:nth-child(2), tbody td:nth-child(3), tbody td:nth-child(4){
			text-align: center;
		}
	</style>	
@endpush
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Categories&nbsp;&nbsp;&nbsp;<span class="fa fa-question-circle small" title='List Of Categories&#013;&#013;This Page Displays the List of Registered categories that contain SMS templates that can be resent to Respondents.After they complete the survey&#013;-To Add a New Category of Messages Template Click the Add Category Button&#013;-You Add a new SMS message by clicking the Add Message Button&#013;-You To View all the Saved Messages click the View Message Button &#013;-To Delete The Saved Messages,click the Delete Button&#013;'></span></h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_category">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Category
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">                 
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <table class="nowrap table table-bordered table-striped" id="category_data_table">
                    <thead>
                        <th>Name</th>
                        <th class="text-center">Add Message</th>
                        <th class="text-center">View Message</th>
                        <th class="text-center">Delete Message</th>
                    </thead>
                </table>           
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_add_category" tabindex="-1" role="dialog" aria-labelledby="modal_add_categoryTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_categoryLongTitle">Add SMS Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-center"><b><span id="error_message" class="text-danger"></span></b></div>
                <div class="modal-body">
                    <form id="add_category" class="form-horizontal">
                        @csrf
                        <div id="name_error" class="form-group has-danger">
                            <label>Category <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit_category" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('shared._datatable_scripts')
@push('scripts')
    <script type="text/javascript">
        var categoryTable = $('#category_data_table').DataTable({
            "ordering": false,
            "ajax": {
                "url": "{{ url('dt_categories') }}",
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

        $('#category_data_table').on("click", '#delete', function(e){
            e.preventDefault();
            var id = $(this).attr('href');

            $.ajax({
                url: "{{ url('/category') }}/"+id,
                method: "POST",
                data: { _method: 'delete', _token: '{{csrf_token()}}' },
                dataType: 'json',
                success: function(msg){
                        categoryTable.ajax.reload(null,false);
                    },
                error: function(xhr){
                        console.log(xhr.responseText);
                    }
            });
        });
        
        $('#submit_category').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            $.ajax({
                url: "{{ url('/category') }}",
                method: "POST",
                data: $('form#add_category').serialize(),
                dataType: 'json',
                success: function(msg){
                        $("#modal_add_sms_actions").modal('hide');
                        $("#add_sms_action")[0].reset();
                        categoryTable.ajax.reload(null,false);
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

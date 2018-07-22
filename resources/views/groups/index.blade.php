@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>List of Groups&nbsp;&nbsp;&nbsp;<span class="fa fa-question-circle" title="
                -You Can Add a New Group to Which Respondents Belong&#013;
                -The Table Below Displays the Registered Groups including Name,Respondents and Actions.&#013;
                Where Name is the Name of The Group ,Respondents represents the Numebr of Respondents Registered in that particular Group&#013;
                -You Can Search a Group and Edit Members Details  By clicking the Edit MembersView Details&#013;
                -You Can Copy ,Export The Regions as an Excel Sheet,CSV,PDF and even print the Groups Registered&#013;"></span></h4>
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
            <div class="text-center"><b><span id="error_message" class="text-danger"></span></b></div>
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
@push('scripts')
    <script type="text/javascript">
        var groupTable = $('#group_data_table').DataTable({
            "ordering": false,
            "ajax": {
                "url": "{{ url('dt_groups') }}",
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

        $('#submit_group').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            $.ajax({
                url: "{{ url('/groups') }}",
                method: "POST",
                data: $('form#add_group').serialize(),
                dataType: 'json',
                success: function(msg){
                        if('errors' in msg){
                            $.each(msg.errors, function(key, value){
                                $('#name').addClass('is-invalid');
                                if($('#show_error').length==0){
                                    $('#add_error').append('<span id="show_error" class="text-danger">'+value+' </span>');
                                }else{
                                    $('#show_error').remove();
                                    $('#add_error').append('<span id="show_error" class="text-danger">'+value+' </span>');
                                }
                            });
                        }else{
                            $('#name').removeClass('is-invalid');
                            $('#show_error').remove();
                            $("#modal_add_groups").modal('hide');
                            $("#add_group")[0].reset();
                            groupTable.ajax.reload(null,false);
                        }
                    },

                error: function(){
                        console.log('Failed!');
                    }
            });
        });
    </script>
@endpush
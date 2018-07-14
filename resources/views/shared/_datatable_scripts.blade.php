@section('styles')
    <link rel="stylesheet" href="{{ asset('data-tables/css/dataTables.bootstrap4.min.css') }}" />  
    <link rel="stylesheet" href="{{ asset('data-tables/css/buttons.dataTables.min.css') }}" />
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ asset('data-tables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/js/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('data-tables/other_js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/buttons.flash.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('data-tables/other_js/buttons.print.min.js') }}"></script>

      <script>
        var printCounter = 0;   
        
        var oTable = $('#data_table').DataTable({
            "ordering": false,
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
        
        $('#submit_region').click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            // Use Ajax to submit form data
            $.ajax({
                url: "{{ url('/regions') }}",
                method: "POST",
                data: $('form#add_region').serialize(),
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
                                // oTable.ajax.reload(null,false);
                            });
                        }else{
                            $('#name').removeClass('is-invalid');
                            $('#show_error').remove();
                            console.log('Succesful');
                            // $("#modal_add_regions").modal('hide');
                            // $("#add_region")[0].reset();
                            // oTable.ajax.reload(null,false);
                        }
                    },

                error: function(){
                        console.log('Failed!');
                    }
            });
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

        $('select').attr('style', 'border:hidden; width:100%');
        
        $( "select" ).select2({
            // theme: "bootstrap4",
            placeholder: "Search...",
            allowClear: true
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

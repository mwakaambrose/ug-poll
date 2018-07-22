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
        
        $('select').attr('style', 'border:hidden; width:100%');
        
        $( "select" ).select2({
            // theme: "bootstrap4",
            placeholder: "Search...",
            allowClear: true
        });
    </script>
@endpush
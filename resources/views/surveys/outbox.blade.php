@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div>
                    <div class="row">
                        <div class="col">
                            <h2>Out Box for {{$survey->name}}</h2>
                        </div>
                        <div class="col">
                            <a href="{{route('surveys.show', $survey->id)}}" class="btn btn-info float-right">Survey</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped" id="data_table">
                        <thead>
                            <th>Date</th> <th>phone number</th> <th>Question</th> <th>Status</th> <th>Cost</th>
                        </thead>

                        <tbody>
                            @foreach($my_out_box as $outbox)
                                 <tr>
                                     <td>{{$outbox->created_at}}</td>
                                     <td>{{$outbox->phone_number}}</td>
                                     <td>{{$outbox->description}}</td>
                                     <td>{{$outbox->status}}</td>
                                     <td>{{$outbox->cost}}</td>
                                </tr>
                            @endforeach                            
                        </tbody>                    
                        
                    </table>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')  
   <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> 
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

      <script>
       $(document).ready(function() {
            $('#data_table').DataTable( {
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
            } );
        } );
    </script>
@endpush
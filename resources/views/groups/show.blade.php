@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>{{ $group->name }}</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <form action="/groups/{{ $group->id }}" method="POST">
                {{method_field('DELETE')}}
                {{ csrf_field() }}
                <span class="glyphicon glyphicon-trash"></span>
                <input type="submit" class="btn btn-danger" value="Delete Group"/>
            </form>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row py-3">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $group->respondents->count() }}</h5>
                        <p class="card-text">Respondents</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$group_surveys_count}}</h5>
                        <p class="card-text">Surveys</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Surveys</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped" id="data_table">
                    <thead>
                        <th>Title</th>
                        <th>Participants</th>
                        <th class="text-center">Actions</th>                        
                    </thead>

                    <tbody>
                        @foreach($group_surveys as $survey)
                         <tr>
                             <td><a href="{{route('surveys.show',$survey->id)}}">{{ $survey->name }}</a></td>
                             <td>{{ $survey->respondents_count }}</td>
                             <td class="text-center">
                                 <a href="{{route('surveys.show',$survey->id)}}" class="text-success mx-3">View Statistics</a>
                             </td>
                         </tr>
                        @endforeach                        
                    </tbody>               
                      
                </table>
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

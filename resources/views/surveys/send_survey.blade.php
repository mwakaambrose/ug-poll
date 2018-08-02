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
            <h4>Send a Survey Now</h4>
        </div>

 
        	<div class="table-responsive"> 
                <table class="nowrap table table-bordered table-striped" id="data_table">
                    <thead>
                       <th>#</th> <th>Survey Name</th> <th>Group</th>                  
                     	<th class="text-center">Send Now</th>                                            
                    </thead>

                    <tbody>
                    	@foreach($surveys as $survey)
                    	  <tr>
                    	     <td>{{$survey->id}}</td>	
                             <td>{{$survey->name}}</td> 
                             <td><a href="{{route('groups.edit',$survey->groups->id)}}"></a> {{$survey->groups->name}}</td> 
                             <td><a href="#" class="btn btn-primary" id="send_survey{{$survey->id}}">Send Now</a></td>
                    	  </tr>

                    	  @push('scripts')
                    	    <script type="text/javascript">
                    	    	$('#send_survey{{$survey->id}}').on("click", function(e){
						            e.preventDefault();				            
						            $.ajax({						                 
						                url: "{{ route('outbox.store') }}",
						                method: "POST",
						                	data: { 
						                		survey_id: {{$survey->id}},
						                	 	_token: '{{csrf_token()}}' 
						                	 },
						                dataType: 'json',
						                success: function(msg){
						                    console.log(result);
						                },
						                error: function(xhr){
						                
						                }
						            });
						        });
                    	    </script>
                    	  @endpush
                    	@endforeach
                    </tbody>
                </table>
            </div>   
    	</div>
@endsection
@include('shared._datatable_scripts')
 
 


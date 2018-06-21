@extends('layouts.app')

@section('content')
	<div class="container">
	    @include('shared._heading', [
	        'heading' => 'Survey Details',
	        'should_show_action' => false,
	        'action_url' => '',
	        'action_name' => ''
	    ])


		<a class="btn btn-info pull-right" href="#" data-toggle="modal" data-target="#questions">Add Question</a>
		<a class="btn btn-success" id="process_survey" href="#">Send Now</a> 
		<a class="btn btn-danger"  href="{{route('surveys.edit',$survey->id)}}">OutBox</a> 
		<span id="display_alert"></span>
		<br>
		    	 

	    <div class="card">
	    	<div class="card-body">
	    		<h5>{{ $survey->name }}</h5>
	    		<p class="text-muted">{{$survey->description }}</p>
	    		<hr>
	    		<h5>Survey Questions</h5>
	    		 <!-- I removed it because it meant that a survey can only have one question -->

	    		 <table class="table">
	    		 	<th>#</th><th>Question</th> <th>Answer Type</th> <th>Posible Answers</th> <th>View Answers</th>
	    		 	@foreach($read_Question as $questions)
	    		 	  <tr>
	    		 	  	<td>{{$questions->id}}</td>
	    		 	  	<td>{{$questions->description}}</td>
	    		 	  	<td>{{$questions->answer_type}}</td>
	    		 	  	<td>{{str_replace(",", " OR ", $questions->posible_answers)}}</td>
	    		 	  	<td><a href="{{route('outbox.show',$questions->id)}}">Show answers</a></td>
	    		 	  </tr>
	    		 	@endforeach
	    		 </table>
		    		
	    	 
	    	</div>
	    </div>

	    <!-- Modal -->
		<div class="modal fade" id="questions" tabindex="-1" 
			role="dialog" data-backdrop="static" data-keyboard="false"
			aria-labelledby="questions" aria-hidden="true">
		 	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h5 class="modal-title" id="exampleModalLabel">New Question</h5>
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          			<span aria-hidden="true">&times;</span>
		        		</button>
		      		</div>
		      		<form action="/questions" method="POST">
		      			@csrf
			      		<div class="modal-body">
			      			<input type="hidden" name="survey_id" value="{{$survey->id}}">
		      				<div class="form-group">
		      					<label>Question (<span class="text-danger">Required</span>)	</label>
		      					<input type="text" name="description" class="form-control" required>
		      				</div>
		      				<h6>Question answers</h6>
		      				<hr>
		      				<answer-field></answer-field>
			      		</div>
			      		<div class="modal-footer">
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			        		<button type="submit" class="btn btn-success">Save Question</button>
			      		</div>
		      		</form>
		    	</div>
		  </div>
		</div>
	</div>

@endsection

@push('scripts')
  <script>  
    $(document).ready(function(){
	    $("#process_survey").click(function(){
	        $("#display_alert").html("<b class='text-success'>The Survey is in progress, Please Live this page on.</b>");

	        /* 
	        1. send the first question to all members in the group

	        2. Listen to the Inbox, if any new inbox comes in, find who responded, check the last question he answered, take a record in the InBOX and find the next question. "My Next question is NOT your next Question"
	        */ 

	        $.ajax({
	            type: "POST",
	            url: "{{ route('outbox.store') }}",
	            data: { 
	                survey_id: {{$survey->id}},	                 
	                _token: "{{Session::token()}}" },
	            success: function(result){
	                console.log(result);
	            }
	        })
	    });	    
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
      setInterval(function() {
        verify_response()
      }, 5000);
    });

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
</script>
@endpush


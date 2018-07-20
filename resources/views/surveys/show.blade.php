@extends('layouts.app')

@section('content')
	@include('shared._heading', [
		'heading' => 'Survey Details',
		'should_show_action' => false,
		'action_url' => '',
		'action_name' => ''
	])
	<div class="btn-group" role="group">
		<!-- <a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#questions">Add survey question</a> -->
<a class="btn btn-secondary" href="/load_questionier/{{$survey->id}}">Add survey question</a>
<a class="btn btn-secondary" id="process_survey" href="#">Send survey now</a> 
<a class="btn btn-secondary"  href="{{route('surveys.edit',$survey->id)}}">View outbox</a>
<a class="btn btn-secondary"  href="/template/{{$survey->id}}">Save Survey Template</a>
	&nbsp;&nbsp;<h4><span class="fa fa-question-circle"	title='SURVEY DETAILS&#013;&#013;
This Page Displays All Surveys Particular Details including The Questions and Answers that were Set for that survey&#013;
This page Also Displays the RealTime Answers/inbox from the Sent Survey of which you can filter and Export as Excel Sheet,CSV,PDF for further Data Analysis&#013;
-You Can Add a Question to this Survey by clicking Add question and Filling in More Detail about the question and the Corresponding Answers for that Question.&#013;
-To Send The Survey Click the Send Survey Button. This will run a background process  that will Send the Survey content in Intervals i.e After a Response to a Question ,The Next Question is Sent to the Respondent&#013;
-To View The Sent Survey Questions and the Status click on the View Outbox button &#013;
-To Save the Survey and Resuse it in future click the Save Survey template button&#013;
'></span></h4>
	</div>
	<br>

	<span id="display_alert"></span>

	<div class="card mt-3">
		<div class="card-body">
			<h1>{{ $survey->name }}</h1>
			<p class="text-muted">{{$survey->description }}</p>
			<hr>
			<h5>Survey Questions</h5>
			<hr>
			@if($survey->questions->count() == 0)
				<div class="alert alert-info">
					<strong>No questions added.	</strong> <a href="/load_questionier/{{$survey->id}}">Add</a>
				</div>
			@endif
			@foreach($survey->questions as $question)
				<h3>{{ $question->description }} </h3> <span class="text-muted small">
						{{ $question->answer_type }}
						<a href="/questions/{{$question->id}}/delete" class="text-danger">(Delete)</a>
					</span>

					<ul>
						@foreach($question->response as $responses)
							<li>{{ $responses->answer }} ({{$responses->value}})</li>
						@endforeach						
					</ul>		 
				

		<h2> Answers</h2>
			<table class="table table-hover table-striped" id="answers{{$question->id}}">
				<thead>
					<th>Phone</th> <th>Answer</th> <th>Value</th>
				</thead>
				<tbody>
					@foreach($question->inboxes as $inbox)
					 <tr>
					 	<td>{{$inbox->phone_number}}</td> <td>{{$inbox->answer}}</td>
					 	<td>
					 		<?php

					 		$posible_response = App\Models\Response::select('value')->where('question_id',$inbox->question_id)->where('answer',$inbox->answer)->first();
					 		if (!empty($posible_response)) {
					 			echo $posible_response->value; 
					 		}
					 		
					 		 ?>
					 	</td>
					 </tr>				 
					@endforeach
				</tbody>				
			</table>

			@push('scripts')
			    <script>
			       $(document).ready(function() {
			            $('#answers{{$question->id}}').DataTable( {
			                dom: 'Bfrtip',
			                buttons: [
			                    'copy',
			                    {
			                        extend: 'excel',
			                        messageTop: '{{ $question->description }}'
			                    },
			                    {
			                        extend: 'csv',
			                        messageTop: '{{ $question->description }}'
			                    },
			                    {
			                        extend: 'pdf',
			                        messageTop: '{{$question->description }}'
			                    },
			                    {
			                        extend: 'print',
			                        messageTop: '{{ $question->description }}'
			                    }
			                ]
			            } );
			        } );
    			</script>
			@endpush
		@endforeach
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
				<form action="/surveys/{{$survey->id}}/questions" method="POST">
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
@endsection

@section('styles')  
   <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> 
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
						_token: "{{Session::token()}}" 
					},
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
		}, 10000);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
@endpush
@extends('layouts.app')

@section('content')
	@include('shared._heading', [
		'heading' => 'Survey Details',
		'should_show_action' => false,
		'action_url' => '',
		'action_name' => ''
	])

	<div class="btn-group" role="group">
		<a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#questions">Add survey question</a>
		<a class="btn btn-secondary" id="process_survey" href="#">Send survey now</a>
		<a class="btn btn-secondary"  href="{{route('surveys.edit',$survey->id)}}">View outbox</a>
	</div>

	<div class="card mt-3">
		<div class="card-body">
			<h5 class="row">
				<span class="col-sm-12">{{ $survey->name }} <a href="/surveys/{{ $survey->id }}/results" class="btn btn-success float-right">View Results</a></span>
			</h5>
			<p class="text-muted">{{$survey->description }}</p>
			<hr>
			<h5>Survey Questions</h5>
			<hr>
			@if($survey->questions->count() == 0)
				<div class="alert alert-info">
					<strong>No questions added.</strong> <a href="#" data-toggle="modal" data-target="#questions">Add</a>
				</div>
			@endif
			@foreach($survey->questions as $question)
				<h6>{{ $question->description }} <span class="text-muted small">
						{{ $question->answer_type }}
						<a href="/questions/{{$question->id}}/delete" class="text-danger">(Delete)</a>
					</span>
				</h6>
				@foreach($question->responses as $response)
					<li>{{ $response->answer }}</li>
				@endforeach
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

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
@endpush


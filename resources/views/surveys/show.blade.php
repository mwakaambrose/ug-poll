@extends('layouts.app_fancy')

@section('content')
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<blockquote class="blockquote">
					<p class="mb-0">{{ $survey->name }}</p>
					<footer class="blockquote-footer">{{$survey->description }}</footer>
				</blockquote>
			</div>
			<div class="card-body">
				@include('flash::message')

                @if (session('status'))
                    <div class="col-sm-12 alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                @endif
				@if($survey->questions->count() == 0)
					<div class="alert alert-info">
						<strong>No questions added.	</strong> <a href="/load_questionier/{{$survey->id}}">Add</a>
					</div>
				@endif
				@foreach($survey->questions as $key => $question)
					<div class="card">
						<div class="card-body">
							<span class="lead">{{ $key+1 }}. {{ $question->description }} </span>
							<span class="text-muted small pull-right">
								{{ $question->answer_type }}
								<a href="/questions/{{$question->id}}/delete" class="text-danger">(Delete)</a>
							</span>
							<ul>
								@foreach($question->response as $responses)
									<li>{{ $responses->answer }} ({{$responses->value}})</li>
								@endforeach						
							</ul>
							<em><h5 class="text-center"> Responses</h5></em>
							<table class="nowrap table table-bordered table-striped custom" id="answers{{$question->id}}">
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
						</div>
					</div>
				@endforeach
			</div>
			<div class="card-footer">
				<a class="float-right btn btn-info" href="{{ url('/load_questionier', $survey->id) }}">Add question</a>
			</div>
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
@include('shared._datatable_scripts')
@push('scripts')
	<script type="text/javascript">
		$('.custom').each(function(){
          $id = this.id;
          $($('#'+$id)).DataTable({
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
        });
		
		$("#process_survey").click(function(){
			$("#display_alert").html("<b class='text-success'>The Survey is in progress, Please Live this page on.</b>");

			/* 1. send the first question to all members in the group
			2. Listen to the Inbox, if any new inbox comes in, find who responded, check the last question he answered, take a record in the InBOX and find the next question. "My Next question is NOT your next Question"*/ 
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
	</script>

	<script type="text/javascript">
		setInterval(function() {
			verify_response()
		}, 10000);

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
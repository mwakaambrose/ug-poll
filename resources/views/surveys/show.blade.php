@extends('layouts.app')

@section('content')
	<div class="container">
	    @include('shared._heading', [
	        'heading' => 'Survey Details',
	        'should_show_action' => false,
	        'action_url' => '',
	        'action_name' => ''
	    ])

	    <div class="card">
	    	<div class="card-body">
	    		<h5>{{ $survey->name }}</h5>
	    		<p class="text-muted">{{ $survey->description }}</p>
	    		<hr>
	    		<h5>Survey Questions</h5>
	    		@if($survey->questions->count() == 0)
		    		<div class="alert alert-info">
		    			<strong>No questions added.</strong> <a href="#" data-toggle="modal" data-target="#questions">Add</a>
		    		</div>
	    		@endif
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
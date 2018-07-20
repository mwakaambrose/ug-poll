<div class="row mt-4">
	<div class="col">
		<h4>{{ $heading }}
@if($_SERVER['REQUEST_URI']=='/surveys')
<span  	class="fa fa-question-circle"		title='SURVEYS&#013;&#013;
This Page Displays All the Registered Surveys with their Corresponding Description and the Send Due date time &#013;
-You Can Add a New Survey By Clicking the New Survey Button&#013;
-To View Survey Details Click the Survey Link &#013;
'></span>
@endif
		</h4>
	</div>
	<div class="col">
		@if($should_show_action)
			<a href="{{ $action_url }}" class="btn btn-primary float-right">{{ $action_name }}</a>
		@endif
	</div>
</div>
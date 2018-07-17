@include('layouts.app')
<div class="card mt-3">
		<div class="card-body" >
	<button type="button" id="print_btn" class="btn btn-default">Print Survey</button>
			<hr />
			<h1>
				@foreach($survey as $surv)
					{{$surv->name}}
				@endforeach
			</h1>
			<p class="text-muted">
				@foreach($survey as $surv)
					{{$surv->description}}
					<hr />
					<!-- <a href="/exportPDF/{{$surv->id}}" class='btn btn-success'>Export PDF</a> -->
				@endforeach</p>
			<hr>
 
			<h5>Survey Questions</h5>
			<hr>
			 <?php 
foreach($survey as $surv){
	foreach($surv->questions as $question){
		?>
<h3>{{$question->description}}</h3>
 <span class="text-muted small">
{{ $question->answer_type }}
<a href="/questions/{{$question->id}}/delete" class="text-danger">(Delete)</a>
</span>
	<ul>
	@foreach($question->responses as $response)
		<li>{{ $response->answer }} ({{$response->value}})</li>
	@endforeach						
	</ul>
		<?php 
	}
}
			 ?>
 
		</div>
	</div>
 
@section('styles')  
   <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> 
@endsection	
 
			    <script>
			       $(document).ready(function() {
			       		$('#print_btn').click(function(){  			 
    					window.print();     					 
			        	} );
			       	});
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
			 

<form action="{{ $url }}" method="{{ $method }}" class="form col-6">
	@csrf
	<div class="form-group">
		<label>Survey Name</label>
		<input type="text" name="name" class="form-control" value="{{ old('name', $survey->name) }}">
	</div>
	<div class="form-group">
		<label>Survey Description</label>
		<textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
	</div>
	<button class="btn btn-success">Submit Data</button>
</form>
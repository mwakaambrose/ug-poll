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

	<div class="form-group">
		<label>Choose a group that will respond to this survey</label>
		<select class="form-control" name="group_id">
			@foreach($group as $groups)
			  <option value="{{$groups->id}}">{{$groups->name}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label>What time do we send the survey?</label>
		<input type="date" name="send_time" class="form-control" value="{{ old('time')}}">
	</div>

	<button class="btn btn-success">Submit Data</button>
</form>
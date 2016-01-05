@section('content')
<div class="row">
	<form action="/semester" method="POST">	
		<div class="col-md-4">
			<fieldset>
				<legend>Semester Settings</legend>		
				@include('partials.alert')
				<input type="hidden" name="id" value="{{ $sem->id }}">
				<div class="form-group">
				  <label class="control-label" for="start_date">Start Date</label>
				  <input class="form-control" id="start_date" name="start_date" type="text" value="{{ $sem->start_date }}" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label" for="end_date">End Date</label>
					<input class="form-control" id="end_date" name="end_date" type="text" value="{{ $sem->end_date }}">
				</div>
				<div class="form-group">
					<label class="control-label" for="weeks_per_term">Weeks per term</label>
					<input class="form-control" id="weeks_per_term" name="weeks_per_term" type="number" value="{{ $sem->weeks_per_term }}">
				</div>
				<div class="form-group">
					<button class="btn btn-block btn-primary">Update</button>
				</div>
			</fieldset>
		</div>
	</form>
</div>
@stop
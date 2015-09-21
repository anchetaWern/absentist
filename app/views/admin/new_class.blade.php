@section('content')
<div class="row">
	<form action="/classes/create" method="POST">	
		<div class="col-md-4">
			<fieldset>
				<legend>Create New Class</legend>		
				@include('partials.alert')
				<div class="form-group">
				  <label class="control-label" for="name">Name</label>
				  <input class="form-control" id="name" name="name" type="text" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label" for="details">Details</label>
					<textarea class="form-control" name="details" id="details" rows="3"></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="drop_absences_count">Number of Absences Before Dropping</label>
					<input class="form-control" id="drop_absences_count" name="drop_absences_count" type="text">
				</div>

				<div class="form-group">
					<label class="control-label">Days</label>
					@foreach($days as $day)
					<div class="checkbox">
					  <label>
					    <input type="checkbox" name="days[]" value="{{ $day }}">{{ $day }}
					  </label>
					</div>
					@endforeach
				</div>

				<div class="form-group">
					<label class="control-label" for="time_from">Time From</label>
					<input class="form-control" id="time_from" name="time_from" type="text">
				</div>

				<div class="form-group">
					<label class="control-label" for="time_to">Time To</label>
					<input class="form-control" id="time_to" name="time_to" type="text">
				</div>


				<div class="form-group">
					<button class="btn btn-block btn-primary">Save</button>
				</div>
			</fieldset>
		</div>

		<div class="col-md-8">
			<div class="form-group">
				<label class="control-label" for="students">Students (format: StudentIDLastName, FirstName MiddleInitial. Gender)</label>
				<textarea class="form-control" name="students" id="students" rows="20" placeholder="e.g. 1111111 Asakura, Yoh B. M"></textarea>
			</div>
		</div>
	</form>
</div>
@stop
@section('content')
<div class="row">
		<div class="col-md-4">
			<form action="/class/{{ $class->id }}" method="POST">	
				<fieldset>
					<legend>Update Class</legend>		
					@include('partials.alert')
					<div class="form-group">
					  <label class="control-label" for="name">Name</label>
					  <input class="form-control" id="name" name="name" type="text" value="{{ $class->name }}" autofocus>
					</div>
					<div class="form-group">
						<label class="control-label" for="details">Details</label>
						<textarea class="form-control" name="details" id="details" rows="3" value="{{ $class->details }}">{{ $class->details }}</textarea>
					</div>

					<div class="form-group">
						<label class="control-label" for="drop_absences_count">Number of Absences Before Dropping</label>
						<input class="form-control" id="drop_absences_count" name="drop_absences_count" type="text" value="{{ $class->drop_absences_count }}">
					</div>

					<div class="form-group">
						<label class="control-label">Days</label>
						@foreach($days as $day)
						<div class="checkbox">
						  <label>
						  <?php
						  $checked = '';
						  if(in_array($day, $class_days)){
						  	$checked = 'checked';
						  }
						  ?>
						    <input type="checkbox" name="days[]" value="{{ $day }}" {{ $checked }}>{{ $day }}
						  </label>
						</div>
						@endforeach
					</div>

					<div class="form-group">
						<label class="control-label" for="time_from">Time From</label>
						<input class="form-control" id="time_from" name="time_from" type="text" value="{{ $class->time_from }}">
					</div>

					<div class="form-group">
						<label class="control-label" for="time_to">Time To</label>
						<input class="form-control" id="time_to" name="time_to" type="text" value="{{ $class->time_to }}">
					</div>

					<div class="form-group">
						<button class="btn btn-block btn-primary">Update</button>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="col-md-8">
			<table class="table">
				<thead>
					<tr>
						<th>ID Number</th>
						<th>Student</th>
						<th>Gender</th>
						<th>Remove</th>
					</tr>
				</thead>
				<tbody>
					@foreach($students as $student)
					<tr>
						<td><a href="/absences/{{ $student->student_class_id }}">{{ $student->student_id }}</a></td>
						<td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }}</td>
						<td>{{ $student->gender }}</td>
						<td><button type="button" class="remove-student btn btn-danger" data-id="{{ $student->student_class_id }}" data-name="{{ $student->last_name }}, {{ $student->first_name }}">remove</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
</div>
@stop
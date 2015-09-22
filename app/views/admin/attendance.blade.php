@section('content')
<div class="row">
	<div class="col-md-8">
		<h3>Attendance</h3>
		<table class="table" id="students-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Excused</th>
					<th>Absent</th>
				</tr>
			</thead>
			<tbody>
			@foreach($students as $student)
				<tr class="all">
					<td data-studentid="{{ $student->id }}">{{ $student->last_name . ", " . $student->first_name . " " . $student->middle_initial }} </td>
					<td><button class="btn btn-success mark-student" data-class="success" data-type="excused">Excused</button></td>
					<td><button class="btn btn-warning mark-student" data-class="warning" data-type="absent">Absent</button></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

	<div class="col-md-4">

		<div class="panel panel-primary" id="filter-box">
		  <div class="panel-heading">
		    <h3 class="panel-title">Filter</h3>
		  </div>
		  <div class="panel-body">

			<div class="radio">
			  <label>
			    <input type="radio" name="filter" class="filter" data-class="all" value="all" checked>
			    Show All
			  </label>
			</div>

			<div class="radio">
			  <label>
			    <input type="radio" name="filter" class="filter" data-class="warning" value="absent">
			    Show Absent
			  </label>
			</div>

			<div class="radio">
			  <label>
			    <input type="radio" name="filter" class="filter" data-class="success" value="excused">
			    Show Excused
			  </label>
			</div>

		  </div>
		</div>

		<button id="update-attendance" data-classid="{{ $class['id'] }}" class="btn btn-primary btn-block">Update Attendance</button>
	</div>
</div>
@stop
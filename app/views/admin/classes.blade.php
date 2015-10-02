@section('content')
<div class="row">
	<div class="col-md-12">
		<h3>Classes</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Class Code</th>
					<th>Update</th>
					<th>Attendance</th>
					<th>To Drop</th>
					<th>Dropped</th>
				</tr>
			</thead>
			<tbody>
			@foreach($classes as $class)
				<tr>
					<td>{{ $class->name }}</td>
					<td>{{ $class->class_code }}</td>
					<td><a href="/class/{{ $class->id }}">update</a></td>
					<td><a href="/attendance/{{ $class->id }}">update</a></td>
					<td><a href="/to-drop/{{ $class->id }}">view</a></td>
					<td><a href="/dropped/{{ $class->id }}">view</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<h3>Classes</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Class Code</th>
					<th>Details</th>
					<th>Update</th>
				</tr>
			</thead>
			<tbody>
			@foreach($classes as $class)
				<tr>
					<td>{{ $class->name }}</td>
					<td>{{ $class->class_code }}</td>
					<td>{{ $class->details }}</td>
					<td><a href="/class/{{ $class->id }}">update</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
@section('content')
<div class="row">
		<div class="col-md-8">
			<h3>Class Cards to Drop in {{ $class }}</h3>
			@if($to_drop)
			<table class="table">
				<thead>
					<tr>
						<th>Student</th>
						<th>Drop Card</th>
					</tr>
				</thead>
				<tbody>
					@foreach($to_drop as $student)
					<tr>
						<td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }}</td>
						<td><button type="button" class="drop-card btn btn-warning" data-id="{{ $student->id }}">drop</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
</div>
@stop
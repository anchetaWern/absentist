@section('content')
<div class="row">
		<div class="col-md-8">
			<h3>Class Cards to Drop in {{ $class }}</h3>
			@if(count($to_drop) > 0)
			<table class="table">
				<thead>
					<tr>
						<th>Student</th>
						<th>Drop Card</th>
						<th>Absences</th>
					</tr>
				</thead>
				<tbody>
					@foreach($to_drop as $student)
					<tr>
						<td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }}</td>
						<td><button type="button" class="drop-card btn btn-warning" data-id="{{ $student->id }}">drop</button></td>
						<td><a href="/absences/{{ $student->id }}">view</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<div class="alert alert-info">
				No class cards are ready for dropping yet.
			</div>
			@endif
		</div>
</div>
@stop
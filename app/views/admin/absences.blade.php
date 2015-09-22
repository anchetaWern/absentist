@section('content')
<div class="row">
		<div class="col-md-8">
			<h3>Absences of {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }}</h3>
			@if($absences)
			<table class="table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					@foreach($absences as $row)
					<tr>
						<td>{{ Carbon::parse($row->date)->format('D, M d, Y') }}</td>
						<td>{{ $row->type }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
</div>
@stop
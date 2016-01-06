@section('content')
<div class="row">
		<div class="col-md-8">
			<h3>Absences of {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }} in {{ $class }}</h3>
			@if(count($absences) > 0)
			<table class="table">
				<thead>
					<tr>
						<th>Term</th>
						<th>Date</th>
						<th>Day</th>
						<th>Week</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					@foreach($absences as $row)
					<tr>
						<td>{{ DateTimeHelper::term($row->date) }}</td>
						<td>{{ Carbon::parse($row->date)->format('M d, Y') }}</td>
						<td>{{ Carbon::parse($row->date)->format('D') }}</td>
						<td>{{ DateTimeHelper::week($row->date) }}</td>
						<td>{{ $row->type }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<div class="alert alert-info">
				No absences yet.
			</div>
			@endif
		</div>
</div>
@stop
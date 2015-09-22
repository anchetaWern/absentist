@section('content')
<div class="row">
		<div class="col-md-8">
			<h3>Dropped Class Cards in {{ $class }}</h3>
			@if($dropped)
			<table class="table">
				<thead>
					<tr>
						<th>Student</th>
						<th>Claim Card</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dropped as $student)
					<tr>
						<td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_initial }}</td>
						<td><button type="button" class="claim-card btn btn-success" data-id="{{ $student->id }}" data-name="{{ $student->last_name }}, {{ $student->first_name }}">claim</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
</div>
@stop
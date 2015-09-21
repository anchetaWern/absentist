@section('content')
<div class="row">
	<form action="/holidays/create" method="POST">	
		<div class="col-md-4">
			<fieldset>
				<legend>Create New Holiday</legend>		
				@include('partials.alert')
				<div class="form-group">
				  <label class="control-label" for="name">Name</label>
				  <input class="form-control" id="name" name="name" type="text" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label" for="date">Date</label>
					<input class="form-control" id="date" name="date" type="text">
				</div>
				<div class="form-group">
					<button class="btn btn-block btn-primary">Save</button>
				</div>
			</fieldset>
		</div>

		<div class="col-md-8">
			<h4>Current Holidays</h4>
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Date</th>
						<th>Update</th>
					</tr>
				</thead>
				<tbody>
					@foreach($holidays as $holiday)
					<tr>
						<td>{{ $holiday->name }}</td>
						<td>{{ Carbon::parse($holiday->date)->format('M d, Y') }}</td>
						<td><a href="/holidays/{{ $holiday->id }}">update</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</form>
</div>
@stop
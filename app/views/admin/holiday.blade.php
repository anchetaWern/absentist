@section('content')
<div class="row">
	<form action="/holidays/{{ $holiday->id }}" method="POST">	
		<div class="col-md-4">
			<fieldset>
				<legend>Update Holiday</legend>		
				@include('partials.alert')
				<div class="form-group">
				  <label class="control-label" for="name">Name</label>
				  <input class="form-control" id="name" name="name" type="text" value="{{ $holiday->name }}" autofocus>
				</div>
				<div class="form-group">
					<label class="control-label" for="date">Date</label>
					<input class="form-control" id="date" name="date" type="text" value="{{ $holiday->date }}">
				</div>
				<div class="form-group">
					<button class="btn btn-block btn-primary">Update</button>
				</div>
			</fieldset>
		</div>
	</form>
</div>
@stop
@section('content')
<div class="row">
  <div class="col-lg-12">
		<h3>Hello {{ Auth::user()->username }}!</h3>

		<ul>
			<li>
				<a href="/holidays/new">Create Holidays</a>
			</li>
		</ul>
  </div>
</div>
@stop
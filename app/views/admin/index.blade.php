@section('content')
<div class="row">
  <div class="col-lg-12">
		<h3>Hello {{ Auth::user()->username }}!</h3>
		<div class="col-lg-4">
			@include('partials.alert')
		</div>
		<div class="col-lg-12">		
			<ul>
				<li>
					<a href="/holidays/new">Create Holidays</a>
				</li>
				<li>
					<a href="/semester">Semester Settings</a>
				</li>
				<li>
					<a href="/classes">List Classes</a>
				</li>
				<li>
					<a href="/classes/new">Create a Class</a>
				</li>
			</ul>
		</div>
  </div>
</div>
@stop
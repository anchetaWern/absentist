@if(Session::get('message'))
<?php
$message = Session::get('message');
$type = $message['type'];
$text = $message['text'];
?>
<div class="alert alert-{{ $type }}">
	{{ $text }}
</div>
@elseif(count($errors) > 0)
  <div class="alert alert-danger">
    @foreach($errors->all() as $message)
      <li>{{ $message }}</li>
    @endforeach
  </div>
@else
	<div id="alert-box">
		<span></span>
	</div>
@endif
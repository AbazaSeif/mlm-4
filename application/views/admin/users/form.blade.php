@layout('layout.admin')

@section('content')
@parent
<div class="content">
{{ Form::open("" , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}
		@if (isset($errors))
			@foreach ($errors->all('<p>:message</p>') as $error)
				{{ $error }}
			@endforeach
		@endif
<div class="control-group">
		{{ Form::label("username" ,"Username", array('class' => 'control-label')) }}
	<div class="controls">
		{{ Form::text("username", Input::old("username", $userdata->username), array('class' => 'input-large')) }}
	</div>
</div>
<div class="control-group">
		{{ Form::label("mc_username", "Minecraft Username", array('class' => 'control-label')) }}
	<div class="controls">
		{{ Form::text("mc_username",  Input::old("mc_username", $userdata->mc_username), array('class' => 'input-large')) }}
</div>
</div>
<div class="control-group">
      {{ Form::label("admin", "Admin", array('class' => 'control-label')) }}
	<div class="controls">
		{{ Form::checkbox("admin", 1, Input::old("admin", $userdata->admin), array('class' => 'checkbox')) }}
</div>
</div>
<div class="form-actions">
		{{ Form::submit("Save changes", array("class" => "btn btn-primary")) }}
    <div class="right">
		{{ Form::submit("Ban user", array("class" => "btn btn-warning")) }}
		{{ Form::submit("Delete user", array("class" => "btn btn-danger")) }}
		</div>
</div>
	</fieldset>
{{ Form::close() }}
</div>
@endsection
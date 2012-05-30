@layout('layout.admin')

@section('content')
@parent
<div class="content">
{{ Form::open(null , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "username", "Username", array(Input::old("username", $userdata->username), array('class' => 'input-large')), array('error' => $errors->first('username'))) }}
		{{ Form::field("text", "mc_username", "Minecraft Username", array(Input::old("mc_username", $userdata->mc_username), array('class' => 'input-large')), array("error" => $errors->first("mc_username"))) }}
		{{ Form::field("checkbox", "admin", "Admin", array(1, Input::old("admin", $userdata->admin), array('class' => 'checkbox'))) }}

		{{ Form::actions(array( Form::submit("Save changes", array("class" => "btn btn-primary")), "<div class=\"right\">", Form::submit("Ban user", array("class" => "btn btn-warning")), "</div>" )) }}
	</fieldset>
{{ Form::close() }}
</div>
@endsection
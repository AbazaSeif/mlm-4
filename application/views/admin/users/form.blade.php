@layout('layout.admin')
<?php $countries = require path("app")."countries.php" ?>

@section('content')
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing user <b>{{ Auth::user()->username }}</b></h2>
</div>
{{ Form::open(null , 'POST', array('class' => 'form-horizontal')) }} 
	<fieldset>
		{{ Form::token() }}

		{{ Form::field("text", "username", "MLM Username", array(Input::old("username", $userdata->username), array('class' => 'input-large')),array('help' => 'Be <b>really</b> carefull with this')) }}
		{{ Form::field("text", "mc_username", "Minecraft Username", array(Input::old("mc_username", $userdata->mc_username), array('class' => 'input-large')), array('help' => 'CaSe SeNsItIvE','error' => $errors->first('mc_username'))) }}
		<h3>Profile</h3>
		{{ Form::field("select", "country", "Country", array($countries, Input::old("country", $userdata->profile->country), array('class' => 'input')), array('error' => $errors->first('country'))) }}
		{{ Form::field("text", "reddit", "Reddit Username", array(Input::old("reddit", $userdata->profile->reddit), array('class' => 'input-large')), array('error' => $errors->first('reddit'))) }}
		{{ Form::field("text", "twitter", "Twitter Username", array(Input::old("twitter", $userdata->profile->twitter), array('class' => 'input-large')), array('error' => $errors->first('twitter'))) }}
		{{ Form::field("text", "youtube", "YouTube Username", array(Input::old("youtube", $userdata->profile->youtube), array('class' => 'input-large')), array('error' => $errors->first('youtube'))) }}
		{{ Form::field("text", "webzone", "Homepage", array(Input::old("webzone", $userdata->profile->webzone), array('class' => 'input-large')), array('error' => $errors->first('webzone'))) }}
		{{ Form::field("checkbox", "admin", "Admin", array(1, Input::old("admin", $userdata->admin), array('class' => 'checkbox'))) }}

		{{ Form::actions(array( Form::submit("Save changes", array("class" => "btn btn-primary")), "<div class=\"right\">", Form::submit("Ban user", array("class" => "btn btn-warning")), "</div>" )) }}
	</fieldset>
{{ Form::close() }}
</div>
@endsection
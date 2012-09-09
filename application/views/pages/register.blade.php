@layout('layout.main')
<?php $countries = require path("app")."countries.php" ?>

@section('content')
	<div id="content">
<div class="titlebar clearfix center">
	<h1>Welcome To Major League Minining!</h1>
	<h3>Please take a few seconds to setup your profile</h3>
</div>
		{{ Form::open("account/register", "POST", array('class' => 'form-horizontal ')) }}
		@if (isset($errors))
			@foreach ($errors->all('<p>:message</p>') as $error)
				{{ $error }}
			@endforeach
		@endif
<div class="titlebar clearfix">
	<h2>Usernames<small> (required)</small></h2>
</div>
		{{ Form::field("text", "username", "MLM Username", array(Input::old("username"), array('class' => 'input-large', 'autocomplete' => 'off')),array("help-inline" => 'You wont be able to change this later, choose wisely')) }}
		{{ Form::field("text", "mc_username", "Minecraft Username", array(Input::old("mc_username"), array('class' => 'input-large', 'autocomplete' => 'off')), array("help-inline" => 'CaSe SeNsItIvE','error' => $errors->first('mc_username'))) }}
<div class="titlebar clearfix">
	<h2>Profile <small>(All fields below are optional)</small></h2>
</div>
		{{ Form::field("select", "country", "Country", array($countries, Input::old("country"), array('class' => 'input')), array('error' => $errors->first('country'))) }}
		{{ Form::field("text", "reddit", "Reddit Username", array(Input::old("reddit"), array('class' => 'input-large')), array('error' => $errors->first('reddit'))) }}
		{{ Form::field("text", "twitter", "Twitter Username", array(Input::old("twitter"), array('class' => 'input-large')), array('error' => $errors->first('twitter'))) }}
		{{ Form::field("text", "youtube", "YouTube Username", array(Input::old("youtube"), array('class' => 'input-large')), array('error' => $errors->first('youtube'))) }}
		{{ Form::field("text", "webzone", "Homepage", array(Input::old("webzone"), array('class' => 'input-large')), array("help-inline" => 'Please include http://', 'error' => $errors->first('webzone'))) }}
		<div class="form-actions">
		<button class="btn btn-primary btn-large" type="submit">Create account!</button>
		<p class="disclaimer">By creating an account in Major League Mining, you agree to the <a href="/tos" target="_blank">Terms of Service</a></p>
		</div>
		{{ Form::close() }}
	</div>
@endsection
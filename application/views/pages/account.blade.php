@layout("layout.main")
<?php $countries = require path("app")."countries.php" ?>

@section('content')
@include("user.menu")
	<div id="content" class="account-settings">
	<div class="titlebar clearfix">
		<h2>Edit Account &amp; Profile</h2>
	</div>
	<div class="titlebar clearfix">
		<h3>Linked OpenID Accounts</h3>
	</div>
		<ul class="openids">
			@if(count($openids) > 1)
				@foreach($openids as $openid)
					<li>
						{{ Form::open("account/del_openid", "POST", array("class" => "form-inline")) }}
						{{ Form::token() }}
						{{ HTML::image($openid->favicon, "favicon") }} {{ e($openid->identity) }}
						<button class="btn btn-danger btn-mini right" action="submit"><i class="icon-white icon-remove"></i> Delete</button>
						{{ Form::hidden("oid", $openid->id) }}
						{{ Form::close() }}
					</li>
				@endforeach
			@else
				<form>{{HTML::image($openids[0]->favicon, "favicon")}} {{ $openids[0]->identity }}</form>
			@endif
		</ul>
		<div class="titlebar clearfix">
		<h4>Link another OpenID to your account</h4>
		</div>
			{{ Form::open("account/login" , 'POST', array('class' => 'xpadding')) }} 	
				<fieldset> 
					<div>{{ Form::text("openid_identifier") }} 
					{{ Form::submit("Add", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset>
			{{ Form::close() }}
		<div class="titlebar clearfix">
		<h3>Profile Information</h3>
	</div>
		{{ Form::open("account/profile", "POST", array('class' => 'form-horizontal')) }}
			{{ Form::token() }}
			{{ Form::field("text", "username", "MLM Username", array(Input::old("username", Auth::user()->username), array('class' => 'input-large uneditable-input', 'disabled' => 'disabled')),array('help' => 'You cannot change this')) }}
			{{ Form::field("text", "mc_username", "Minecraft Username", array(Input::old("mc_username", Auth::user()->mc_username), array('class' => 'input-large','autocomplete' => 'off')), array('help' => 'CaSe SeNsItIvE','error' => $errors->first('mc_username'))) }}
			{{ Form::field("select", "country", "Country", array($countries, Input::old("country", Auth::user()->profile->country), array('class' => 'input')), array('error' => $errors->first('country'))) }}
			{{ Form::field("text", "reddit", "Reddit Username", array(Input::old("reddit", Auth::user()->profile->reddit), array('class' => 'input-large','autocomplete' => 'off')), array('error' => $errors->first('reddit'))) }}
			{{ Form::field("text", "twitter", "Twitter Username", array(Input::old("twitter", Auth::user()->profile->twitter), array('class' => 'input-large','autocomplete' => 'off')), array('error' => $errors->first('twitter'))) }}
			{{ Form::field("text", "youtube", "YouTube Username", array(Input::old("youtube", Auth::user()->profile->youtube), array('class' => 'input-large','autocomplete' => 'off')), array('error' => $errors->first('youtube'))) }}
			{{ Form::field("text", "webzone", "Homepage", array(Input::old("webzone", Auth::user()->profile->webzone), array('class' => 'input-large','autocomplete' => 'off')), array('error' => $errors->first('webzone'))) }}
			{{ Form::actions(Form::submit("Update", array("class" => "btn-primary"))) }}
		{{ Form::close() }}
	</div>
@endsection
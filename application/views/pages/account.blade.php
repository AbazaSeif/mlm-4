@layout("layout.user")
<?php
$countries = require path("app")."countries.php";
?>

@section('content')
@parent
	<div id="content">
		<h2>OpenID login methods</h2>
		<h3>Current methods</h3>
		<ul>
			@if(count($openids) > 1)
				@foreach($openids as $openid)
					<li>
						{{ Form::open("account/del_openid", "POST", array("class" => "form-inline")) }}
						{{ Form::token() }}
						{{ HTML::image($openid->favicon, "favicon") }} {{ e($openid->identity) }}
						<button class="btn btn-danger btn-mini" action="submit"><i class="icon-white icon-remove"></i> Delete</button>
						{{ Form::hidden("oid", $openid->id) }}
						{{ Form::close() }}
					</li>
				@endforeach
			@else
				<li>{{HTML::image($openids[0]->favicon, "favicon")}} {{ $openids[0]->identity }}</li>
			@endif
		</ul>
		<h3>Add new method</h3>
	    <div id="login">
			{{ Form::open("account/login" , 'POST', array('class' => 'openid')) }} 	
				<fieldset>
					<label for="openid_identifier">Add a new <a class="openid_logo" href="http://openid.net">OpenID</a></label> 
					<div>{{ Form::text("openid_identifier") }} 
					{{ Form::submit("Add", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset>
			{{ Form::close() }}
		</div>
		<h2>Profile</h2>
		{{ Form::open("account/profile", "POST", array('class' => 'form-horizontal')) }}
			{{ Form::field("select", "country", "Country", array($countries, Input::old("country", Auth::user()->profile->country), array('class' => 'input-large')), array('error' => $errors->first('country'))) }}
			{{ Form::field("text", "reddit", "Reddit", array(Input::old("reddit", Auth::user()->profile->reddit), array('class' => 'input-large')), array('error' => $errors->first('reddit'))) }}
			{{ Form::field("text", "twitter", "Twitter", array(Input::old("twitter", Auth::user()->profile->twitter), array('class' => 'input-large')), array('error' => $errors->first('twitter'))) }}
			{{ Form::field("text", "youtube", "YouTube", array(Input::old("youtube", Auth::user()->profile->youtube), array('class' => 'input-large')), array('error' => $errors->first('youtube'))) }}
			{{ Form::field("text", "webzone", "Homepage", array(Input::old("webzone", Auth::user()->profile->webzone), array('class' => 'input-large')), array('error' => $errors->first('webzone'))) }}
			{{ Form::actions(Form::submit("Update", array("class" => "btn-primary"))) }}
		{{ Form::close() }}
	</div>
@endsection
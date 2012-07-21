@layout('layout.main')

@section('content')
	<style>body{background-attachment:scroll;}header,footer{display:none}#content{background:none;box-shadow:none;}</style>
	<div id="content" class="center">
	<a href="/"><img src="{{ URL::to_asset("images/static/logo.png") }}" /></a>
		<div id="login">
			{{ Form::open("account/login" , 'POST', array('class' => 'openid-form')) }} 
				<div class="prov">
					<ul class="providers"> 
						<li class="openid" title="OpenID"><img src="{{ URL::to_asset("images/login/openid.png") }}" alt="icon" /> 
							<span><strong>http://{your-openid-url}</strong></span></li> 
						<li class="direct" title="Google"><img src="{{ URL::to_asset("images/login/google.png") }}" alt="icon" />
							<span>https://www.google.com/accounts/o8/id</span></li>
						<li class="direct" title="Yahoo"><img src="{{ URL::to_asset("images/login/yahoo.png") }}" alt="icon" />
							<span>http://yahoo.com/</span></li>
						<li class="direct" title="AOL screen name"><img src="{{ URL::to_asset("images/login/aol.png") }}" alt="icon" />
							<span>http://openid.aol.com/</span></li> 
						<li class="direct" title="STEAM ID"><img src="{{ URL::to_asset("images/login/steam.png") }}" alt="icon" />
							<span>http://steamcommunity.com/openid</span></li> 	
					</ul>
				</div>
				<fieldset> 
					<label for="openid_username">Enter your <span>Provider user name</span></label> 
					<div><span></span>{{ Form::text("openid_username") }}<span></span> 
						{{ Form::submit("Submit", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset> 
				<fieldset>
					<label for="openid_identifier">Enter your <a class="openid_logo" href="http://openid.net" rel="nofollow">OpenID</a></label> 
					<div>{{ Form::text("openid_identifier") }} 
						{{ Form::submit("Login", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset>
				{{ Form::checkbox("remember", true, false, array("id" => "remember")) }} {{ Form::label("remember", "Remember me forever (which is a long time)") }}
			{{ Form::close() }}
			<p>We use openID for a safe, faster, and easier way to log into our website.<br>
			If you would like to create an OpenID account, please click <a href="http://openid.net/get-an-openid/" title="Will open in new tab" target="_blank" rel="nofollow">this link</a>.
			</p>
		</div>
	</div>
@endsection
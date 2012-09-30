@layout('layout.main')

@section('content')
	<style>header,footer{display:none}</style>
		<div id="actionbox" class="login">
			<a href="/"><img src="{{ URL::to_asset("images/static/logo.png") }}" /></a>
			<hr>
			{{ Form::open("account/login" , 'POST', array('class' => 'openid-form')) }} 
				<ul class="providers">
					<li class="openid" style="margin:-2px;"></li>
					<li class="direct" title="Login with Google Account"><img src="{{ URL::to_asset("images/login/google.png") }}" alt="icon" />
						<span>https://www.google.com/accounts/o8/id</span>
					</li>
					<li class="direct" title="Login with Steam ID"><img src="{{ URL::to_asset("images/login/steam.png") }}" alt="icon" />
						<span>http://steamcommunity.com/openid</span>
					</li>
					<li class="direct" title="Login with Wordpress.com&#13;Note: You must be logged in to Wordpress.com in order to use this method"><img src="{{ URL::to_asset("images/login/wordpress.png") }}" alt="icon" />
						<span><strong>http://wordpress.com</strong></span>
					</li> 
					<li class="direct" title="Login with Yahoo"><img src="{{ URL::to_asset("images/login/yahoo.png") }}" alt="icon" />
							<span>http://yahoo.com/</span>
					</li>
					<li class="direct" title="Login with AOL"><img src="{{ URL::to_asset("images/login/aol.png") }}" alt="icon" />
						<span>http://openid.aol.com/</span>
					</li>
				</ul>
			<hr>
			<fieldset class="info input-append">
				<label for="openid_identifier" class="openid">Enter your <a class="openid-logo" href="http://openid.net" rel="nofollow">OpenID</a></label> 
					<input type="text" name="openid_identifier" class="id">
					{{ Form::submit("Login", array("class" => "btn btn-primary")) }}
			</fieldset>
			<div class="rememberme">
					{{ Form::checkbox("remember", true, false, array("id" => "remember")) }} 
					{{ Form::label("remember", "Keep me logged in", array("class" => "forget")) }}
			</div>
			{{ Form::close() }}
			<p class="WhyOpenID">
			Enter your OpenID to login or use one of the 1 click login options (also OpenID)<br>
			We use openID for a safe, faster, and easier way to login/register.<br>
			If you would like to create an OpenID account, please click <a href="http://openid.net/get-an-openid/" title="Will open in new tab" target="_blank" rel="nofollow">this link</a>.
			</p>
		</div>
@endsection
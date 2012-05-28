@layout('layout.main')

@section('content')
	<div id="content">
	    <div id="login">
		{{ Form::open("account/login" , 'POST', array('class' => 'openid')) }} 
  <div><ul class="providers"> 
  <li class="openid" title="OpenID"><img src="{{ URL::to_asset("images/login/openidW.png") }}" alt="icon" /> 
  <span><strong>http://{your-openid-url}</strong></span></li> 
  <li class="direct" title="Google"> 
		<img src="{{ URL::to_asset("images/login/googleW.png") }}" alt="icon" /><span>https://www.google.com/accounts/o8/id</span></li> 
  <li class="direct" title="Yahoo"> 
		<img src="{{ URL::to_asset("images/login/yahooW.png") }}" alt="icon" /><span>http://yahoo.com/</span></li> 
  <li class="username" title="MyOpenID user name"> 
		<img src="{{ URL::to_asset("images/login/myopenid.png") }}" alt="icon" /><span>http://<strong>username</strong>.myopenid.com/</span></li> 
  <li class="username" title="Wordpress blog name"> 
		<img src="{{ URL::to_asset("images/login/wordpress.png") }}" alt="icon" /><span>http://<strong>username</strong>.wordpress.com</span></li> 
  <li class="username" title="ClaimID user name"> 
		<img src="{{ URL::to_asset("images/login/claimid.png") }}" alt="icon" /><span>http://claimid.com/<strong>username</strong></span></li>  
  <li class="username" title="Verisign user name"> 
		<img src="{{ URL::to_asset("images/login/verisign.png") }}" alt="icon" /><span>http://<strong>username</strong>.pip.verisignlabs.com/</span></li> 
  </ul></div> 
  <fieldset> 
  <label for="openid_username">Enter your <span>Provider user name</span></label> 
  <div><span></span>{{ Form::text("openid_username") }}<span></span> 
  {{ Form::submit("Submit", array("class" => "btn-primary")) }}
  </div>
  </fieldset> 
  <fieldset>
  <label for="openid_identifier">Enter your <a class="openid_logo" href="http://openid.net">OpenID</a></label> 
  <div>{{ Form::text("openid_identifier") }} 
  {{ Form::submit("Login", array("class" => "btn-primary")) }}
  </div>
  </fieldset> 
{{ Form::close() }}
<p>We use openID for a safe, faster, and easier way to log into our website.
		If you don't have an openID with any of the provided services, you can create may with any provider <a href="http://openid.net/get-an-openid/" title="Will open in new tab" target="_blank">on this list.</a>
</p>
		</div>
	</div>
@endsection


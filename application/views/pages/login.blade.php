@layout('layout.main')

@section('content')
	<div class="content">
	    <div class="login">
		<form class="openid" method="post" action="/Login.xhtml?ReturnUrl="> 
  <div><ul class="providers"> 
  <li class="openid" title="OpenID"><img src="http://mlm.dev/public/images/login/openidW.png" alt="icon" /> 
  <span><strong>http://{your-openid-url}</strong></span></li> 
  <li class="direct" title="Google"> 
		<img src="http://mlm.dev/public/images/login/googleW.png" alt="icon" /><span>https://www.google.com/accounts/o8/id</span></li> 
  <li class="direct" title="Yahoo"> 
		<img src="http://mlm.dev/public/images/login/yahooW.png" alt="icon" /><span>http://yahoo.com/</span></li> 
  <li class="username" title="MyOpenID user name"> 
		<img src="http://mlm.dev/public/images/login/myopenid.png" alt="icon" /><span>http://<strong>username</strong>.myopenid.com/</span></li> 
  <li class="username" title="Wordpress blog name"> 
		<img src="http://mlm.dev/public/images/login/wordpress.png" alt="icon" /><span>http://<strong>username</strong>.wordpress.com</span></li> 
  <li class="username" title="ClaimID user name"> 
		<img src="http://mlm.dev/public/images/login/claimid.png" alt="icon" /><span>http://claimid.com/<strong>username</strong></span></li>  
  <li class="username" title="Verisign user name"> 
		<img src="http://mlm.dev/public/images/login/verisign.png" alt="icon" /><span>http://<strong>username</strong>.pip.verisignlabs.com/</span></li> 
  </ul></div> 
  <fieldset> 
  <label for="openid_username">Enter your <span>Provider user name</span></label> 
  <div><span></span><input type="text" name="openid_username" /><span></span> 
  <input type="submit" value="Login" /></div> 
  </fieldset> 
  <fieldset> 
  <label for="openid_identifier">Enter your <a class="openid_logo" href="http://openid.net">OpenID</a></label> 
  <div><input type="text" name="openid_identifier" /> 
  <input type="submit" value="Login" class="btn-primary"/></div> 
  </fieldset> 
</form>
		</div>
	</div>
@endsection


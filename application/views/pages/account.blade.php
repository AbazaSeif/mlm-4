@layout("layout.main")

@section('content')
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
				<div class="prov">
					<ul class="providers"> 
						<li class="openid" title="OpenID"><img src="{{ URL::to_asset("images/login/openid.png") }}" alt="icon" /> 
							<span><strong>http://{your-openid-url}</strong></span></li> 
						<li class="direct" title="Google"> 
							<img src="{{ URL::to_asset("images/login/google.png") }}" alt="icon" /><span>https://www.google.com/accounts/o8/id</span></li>
						<li class="direct" title="Yahoo"> 
							<img src="{{ URL::to_asset("images/login/yahoo.png") }}" alt="icon" /><span>http://yahoo.com/</span></li>   
						<li class="direct" title="STEAM ID"> 
							<img src="{{ URL::to_asset("images/login/steam.png") }}" alt="icon" /><span>http://steamcommunity.com/openid</span></li>
					</ul>
				</div>	
				<fieldset> 
					<label for="openid_username">Enter your <span>Provider user name</span></label> 
					<div><span></span>{{ Form::text("openid_username") }}<span></span> 
					{{ Form::submit("Submit", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset> 
				<fieldset>
					<label for="openid_identifier">Enter your <a class="openid_logo" href="http://openid.net">OpenID</a></label> 
					<div>{{ Form::text("openid_identifier") }} 
					{{ Form::submit("Login", array("class" => "btn btn-primary")) }}
					</div>
				</fieldset> 
			{{ Form::close() }}
		</div>
	</div>
@endsection
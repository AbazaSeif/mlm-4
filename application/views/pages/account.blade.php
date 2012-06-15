@layout("layout.user")

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
	</div>
@endsection
@layout('layout.main')


@section('content')
	<div class="content">
	    <div class="login">
		{{ Form::open("account/login") }}
		{{ Form::label("openid_identifier", "OpenID login") }}
		{{ Form::text("openid_identifier", "https://www.google.com/accounts/o8/id") }}
		<br>
		{{ Form::submit("Login", array('class' => 'btn-primary')) }}
		{{ Form::close() }}
		</div>
	</div>
@endsection
@layout('layout.main')


@section('content')
	<div class="content">
	    <div class="center">
		{{ Form::open("account/login") }}
		{{ Form::label("openid_identifier", "OpenID login") }}
		{{ Form::text("openid_identifier", "https://www.google.com/accounts/o8/id") }}
		{{ Form::submit("Login", array('class' => 'btn-primary')) }}
		{{ Form::close() }}
		</div>
	</div>
@endsection
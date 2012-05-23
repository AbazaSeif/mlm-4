@layout('layout.main')


@section('content')
	<div>
		{{ Form::open("account/register") }}
		{{ Form::label("username", "Username") }}
		{{ Form::text("username", Input::old('username')) }}
		{{ Form::label("mc_username", "Minecraft Username") }}
		{{ Form::text("mc_username", Input::old('mc_username')) }}
		{{ Form::submit("Register!") }}
		{{ Form::close() }}
	</div>
@endsection
@layout('layout.main')


@section('content')
	<div>
		{{ Form::open("account/register") }}
		@if (isset($errors))
		@foreach ($errors->all('<p>:message</p>') as $error)
			{{ $error }}
		@endforeach
		@endif
		{{ Form::label("username", "Username") }}
		{{ Form::text("username", Input::old('username')) }}
		{{ Form::label("mc_username", "Minecraft Username") }}
		{{ Form::text("mc_username", Input::old('mc_username')) }}
		{{ Form::submit("Register!", array('class' => 'btn-primary')) }}
		{{ Form::close() }}
	</div>
@endsection
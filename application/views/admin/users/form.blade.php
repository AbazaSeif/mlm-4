@layout('layout.admin')

@section('content')
<div class="content">
	{{ Form::open("" , 'POST', array('class' => 'form-horizontal')) }} 
		{{ Form::token() }}
		@if (isset($errors))
			@foreach ($errors->all('<p>:message</p>') as $error)
				{{ $error }}
			@endforeach
		@endif
		ID: {{ $userdata->id }}<br />
		{{ Form::label("username", "Username") }}
		{{ Form::text("username", Input::old("username", $userdata->username)) }}<br />
		{{ Form::label("mc_username", "Minecraft Username") }}
		{{ Form::text("mc_username", Input::old("mc_username", $userdata->mc_username)) }}<br />
		{{ Form::label("admin", "Admin") }}
		{{ Form::checkbox("admin", 1, Input::old("admin", $userdata->admin)) }}<br />
		{{ Form::submit("Submit", array("class" => "btn-primary")) }}
	{{ Form::close() }}
</div>
@endsection
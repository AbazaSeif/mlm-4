@layout('layout.main')

@section('content')
<div class="content">
	{{ Form::open() }}
		ID: {{ $userdata->id }}<br />
		{{ Form::label("username", "Username") }}
		{{ Form::text("username", $userdata->username) }}<br />
		{{ Form::label("mc_username", "Minecraft Username") }}
		{{ Form::text("mc_username", $userdata->mc_username) }}<br />
		{{ Form::label("admin", "Admin") }}
		{{ Form::checkbox("admin", 1, $userdata->admin )}}<br />
		{{ Form::submit("Submit", array("class" => "btn-primary")) }}
	{{ Form::close() }}
</div>
@endsection
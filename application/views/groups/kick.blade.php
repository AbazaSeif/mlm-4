@layout("layout.main")

@section("content")
<div id="content">
<div class="titlebar">
	<h2>Kicking <strong>{{ e($user->username) }}</strong> from group <strong>{{ e($group->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you would like to kick <i>{{ $user->username }}</i> from the group <i>{{ $group->name }}</i>?</p>
	{{ Form::submit("Kick from Group", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("groups.edit", "Back", array("id" => $group->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Revoking admin provileges for: <strong>{{ e($user->username) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you want to revoke admin privileges to <strong>{{ e($user->username) }}</strong>?</p>
	{{ Form::submit("UnAdmin", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.user", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
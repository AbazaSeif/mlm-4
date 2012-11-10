@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Deleting group: <strong>{{ e($group->name) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you want to delete group <strong>{{ e($group->name) }}</strong>? (Cannot be undone!)</p>
	{{ Form::submit("Delete", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.groups", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
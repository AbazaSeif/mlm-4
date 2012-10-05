@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Deleting match: <strong>{{ e($match->id) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you want to delete match <strong>{{ e($match->id) }}</strong>? (Cannot be undone!)</p>
	{{ Form::submit("Delete", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.matches", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Deleting Modqueue item: <strong>{{ e($item->id) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you want to delete <strong>{{ e($item->id) }}</strong>? (Cannot be undone!)</p>
	{{ Form::submit("Delete", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.modqueue@view", "Back", array("id" => $item->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
<div class="titlebar">
	<h3>Delete version</h3>
</div>
	{{ Form::open("maps/delete_version/".$map->id."/".$version->id, "POST", array('class' => 'xpadding')) }}
		{{ Form::token() }}
		Are you sure you want to remove version <strong>{{ e($version->version) }}</strong> from the map <strong>{{ e($map->title) }}</strong>?
		{{ Form::actions(array(Form::submit("Delete", array("class" => "btn-danger")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
@endsection
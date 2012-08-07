@layout("layout.main")

@section("content")
@include("maps.menu")
{{ HTML::link_to_action("maps@view", "View", array($map->id, $map->slug)) }} 
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
<div id="content">
<div class="titlebar clearfix">
	<h3>Delete image</h3>
</div>
	{{ Form::open("maps/delete_image/".$map->id."/".$image->id, array('class' => 'xpadding')) }}
		{{ Form::token() }}
		Are you sure you want to remove the image from the map <strong>{{ e($map->title) }}</strong>?
		{{ HTML::image($image->file_large, "image") }}

		{{ Form::actions(array(Form::submit("Delete", array("class" => "btn-danger")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
@endsection
@layout("layout.main")

@section("content")

{{ HTML::link_to_action("maps@view", "View", array($map->id, $map->slug)) }} 
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
<div id="content">
	<h2>Delete image</h3>
	{{ Form::open("maps/delete_image/".$map->id."/".$image->id) }}
		{{ Form::token() }}
		Are you sure you want to remove the image from the map <strong>{{ e($map->title) }}</strong>?
		{{ HTML::image($image->file_large, "image") }}

		{{ Form::actions(array(Form::submit("Delete", array("class" => "btn-danger")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
@endsection
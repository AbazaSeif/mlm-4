@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
<div class="titlebar clearfix">
	<h3>Delete image</h3>
</div>
	{{ Form::open("maps/delete_image/".$map->id."/".$image->id, "POST", array('class' => 'xpadding')) }}
		{{ Form::token() }}
		Are you sure you want to remove the image from the map <strong>{{ e($map->title) }}</strong>?
		{{ HTML::image($image->file_large, "image", array("class" => "imgfix")) }}

		{{ Form::actions(array(Form::submit("Delete", array("class" => "btn-danger")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
@endsection
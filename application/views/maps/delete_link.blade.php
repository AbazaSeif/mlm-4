@layout("layout.main")

@section("content")

{{ HTML::link_to_action("maps@view", "View", array($map->id, $map->slug)) }} 
{{ HTML::link_to_action("maps@edit", "Edit", array($map->id)) }}
<div id="content">
	<h2>Delete link</h3>
	{{ Form::open("maps/delete_link/".$map->id."/".$link->id) }}
		{{ Form::token() }}
		Are you sure you want to remove link {{ HTML::image($link->favicon, "favicon")." ".HTML::link($link->url, $link->url) }} from the map <strong>{{ e($map->title) }}</strong>?
		{{ Form::actions(array(Form::submit("Delete", array("class" => "btn-danger")), " ", HTML::link_to_action("maps@edit", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
</div>
@endsection
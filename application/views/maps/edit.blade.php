@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing map <b>{{ e($map->title) }}</b></h2>
</div>
<div class="titlebar clearfix">
	<h3>Map meta</h3>
</div>
	{{ Form::open("maps/edit_meta/".$map->id, "POST", array("class" => "form-horizontal ")) }}
		{{ Form::token() }}
		{{ Form::field("text", "title", "Title", array(Input::old("title", $map->title), array('class' => 'input-large')), array('error' => $errors->first('title'))) }}
		{{ Form::field("textarea", "summary", "Summary", array(Input::old("summary", $map->summary), array("rows" => "15", 'class' => 'xlarge')), array("help-inline" => "Short description about your map. (255 characters max)", 'error' => $errors->first('summary'))) }}
		{{ Form::field("wysiwyg", "description", "Long Description", array(Input::old("description", $map->description), array("rows" => "15", 'id' => 'wysiwyg')), array('error' => $errors->first('description'))) }}
		{{ Form::field("select", "maptype", "Type", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("maptype", $map->maptype), array('class' => 'input')), array('error' => $errors->first('maptype'))) }}
		{{ Form::field("text", "version", "Version", array(Input::old("version", $map->version)), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamcount", "Team count", array(Input::old("teamcount", $map->teamcount)), array("error" => $errors->first("error"))) }}
		{{ Form::field("text", "teamsize", "Recomended team size", array(Input::old("teamsize", $map->teamsize)), array("error" => $errors->first("teamsize"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("maps@view", "Back", array($map->id), array("class" => "btn")))) }}
	{{ Form::close() }}
	<div class="titlebar clearfix">
		<h3>Authors</h3>
	</div>
	<ul>
	@foreach($authors as $user)
		<li>
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/18.png" alt="avatar" /> {{$user->username}}
			@if(!$user->pivot->confirmed)
				Hasn't yet accepted the invite
			@endif
			@if($user->id == Auth::user()->id)
				<small>You cannot remove yourself</small>
			@else
			@endif
		</li>
	@endforeach
	</ul>
	Invite additional authors:
	{{ Form::open("maps/add_author/".$map->id) }}
		{{ Form::token() }}
		{{ Form::field("text", "username", "Username", array(Input::old("username")), array("help-inline" => "MLM username", "error" => $errors->first("username"))) }}
		{{ Form::actions(array(Form::submit("Invite", array("class" => "btn-primary"))))}}
	{{ Form::close() }}
<div class="titlebar clearfix">
	<h3>Download Links</h3>
</div>
	<table class="table">
		<thead>
			<tr>
				<th>URL</th>
				<th>Direct?</th>
				<th>Actions</th>
				<th>{{ HTML::link_to_action("maps@edit_link", "+ Add", array($map->id)) }}</th>
			</tr>
		</thead>
		<tbody>
			@forelse($map->links as $link)
				<tr>
					<td>{{ HTML::image($link->favicon, "favicon")." ".HTML::link($link->url, $link->url) }} <small>{{$link->type}}</small></td>
					<td>{{ $link->direct ? "&#10004;" : "" }}</td>
					<td>{{ HTML::link_to_action("maps@edit_link", "Edit", array($map->id, $link->id)) }}</td>
					<td>{{ HTML::link_to_action("maps@delete_link", "Delete", array($map->id, $link->id)) }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">No links found!</td>
				</tr>
			@endforelse
		</tbody>
	</table>
<div class="titlebar clearfix">
	<h3>Images</h3>
</div>
	<ul class="thumbnails">
		@forelse($map->images as $image)
			<li class="span2">
				<a href="{{ e($image->file_original) }}" class="thumbnail">{{ HTML::image($image->file_small) }}</a>
				{{ HTML::link_to_action("maps@delete_image", "Delete", array($map->id, $image->id)) }}
				@if($map->image_id != $image->id)
				{{ Form::open("maps/default_image/{$map->id}/{$image->id}") }}
					{{ Form::token() }}
					{{ Form::submit("Set Default", array("class" => "btn-success btn-mini")) }}
				{{ Form::close() }}
				@else
				<span class="btn btn-success btn-mini disabled">Default image</span>
				@endif
			</li>
		@empty
			<li>
				No images found!
			</li>
		@endforelse
	</ul>
<div class="titlebar clearfix">
	<h4>Upload new image</h4>
</div>
	{{ Form::open_for_files("maps/upload_image/".$map->id) }}
		{{ Form::token() }}
		{{ Form::field("file", "uploaded", "Image", array(array('class' => 'input-large')), array('error' => $errors->first('uploaded'))) }}
		{{ Form::field("text", "name", "Name", array(Input::old("name"), array('class' => 'input-large')), array('error' => $errors->first('name'))) }}
		{{ Form::submit("Upload", array("class" => "btn-primary")) }}
	{{ Form::close() }}
</div>
@endsection
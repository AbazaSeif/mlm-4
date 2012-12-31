@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Moderating: <strong>{{ HTML::link_to_action("maps.view", $map->title, array($map->id, $map->slug)) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	@if ($map->published == false)
	{{ Form::submit("Approve Map", array("class" => "btn btn-success", "name" => "action", "value" => "publish")) }}
	@elseif ($map->published == true)
	{{ Form::submit("Unapprove Map", array("class" => "btn btn-success", "name" => "action", "value" => "unpublish")) }}
	@endif
	{{ HTML::link_to_action("admin.maps.delete", "Delete Map", array($map->id), array("class" => "btn btn-danger")) }}
	@if ($map->official == false)
	{{ Form::submit("Make Official", array("class" => "btn btn-gold", "name" => "action", "value" => "official")) }}
	@elseif ($map->official == true)
	{{ Form::submit("Make Unofficial", array("class" => "btn btn-gold", "name" => "action", "value" => "unofficial")) }}
	@endif
	@if ($map->featured == false)
	{{ Form::submit("Feature Map", array("class" => "btn btn-info", "name" => "action", "value" => "feature")) }}
	@elseif ($map->featured == true)
	{{ Form::submit("Unfeature Map", array("class" => "btn btn-info", "name" => "action", "value" => "unfeature")) }}
	@endif
	{{ HTML::link_to_action("maps.edit", "Edit Map", array($map->id), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps.edit", "Edit Map (Old interface)", array($map->id), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
	@if($modqueue == true)
	<div class="titlebar">
	<h2>Modqueue Item <strong>{{ e($modqueue->id) }}</strong></h2>
	</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	{{ Form::field("hidden", "modqueueid", "", array($modqueue->id)) }}
	<p>Modqueue item found for: <strong>{{ e($map->title) }}</strong></p>
	<p>ID: {{ $modqueue->id }}</p>
	<p>Type: {{ $modqueue->type }}</p>
	<p>ItemID: {{ $modqueue->itemid }}</p>
	<p>ItemType: {{ $modqueue->itemtype }}</p>
	<p>User: {{ $modqueue->user->username }}</p>
	<p>Date Created: {{ date("F j, Y g:ia", strtotime($modqueue->created_at)) }}</p>
	<p>Additional Data: {{ $modqueue->data }}</p>
	<div class="titlebar"><h4>Admin Notes <small>(Notes about this item such as why not published (No image, incorrect grammer etc.))</small></h4></div>
	{{ Form::field("textarea", "admin_notes", "", array(Input::old("admin_notes", $modqueue->admin_notes), array("rows" => "5", 'class' => 'admin_notes')), array('error' => $errors->first('admin_notes'))) }}
	{{ Form::submit("Delete from Modqueue", array("class" => "btn btn-danger", "name" => "action", "value" => "deletemodqueue")) }}
	{{ Form::submit("Save Admin Notes", array("class" => "btn btn-warning", "name" => "action", "value" => "savemodqueuenotes")) }}
	{{ Form::close() }}
	@endif
</div>
@endsection
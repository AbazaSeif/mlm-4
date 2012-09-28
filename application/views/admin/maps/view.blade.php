@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Moderating: <strong>{{ e($map->title) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>You are now moderating: <strong>{{ e($map->title) }}</strong></p>
	{{ HTML::link_to_action("admin.maps.delete", "Delete Map", array($map->id), array("class" => "btn btn-danger")) }}
	@if ($map->official == false)
	{{ Form::submit("Make Official", array("class" => "btn", "name" => "action", "value" => "official")) }}
	@elseif ($map->official == true)
	{{ Form::submit("Make UnOfficial", array("class" => "btn", "name" => "action", "value" => "unofficial")) }}
	@endif
	@if ($map->featured == false)
	{{ Form::submit("Feature Map", array("class" => "btn", "name" => "action", "value" => "feature")) }}
	@elseif ($map->featured == true)
	{{ Form::submit("UnFeature Map", array("class" => "btn", "name" => "action", "value" => "unfeature")) }}
	@endif
	@if ($map->published == false)
	{{ Form::submit("Publish Map", array("class" => "btn", "name" => "action", "value" => "publish")) }}
	@elseif ($map->published == true)
	{{ Form::submit("UnPublish Map", array("class" => "btn", "name" => "action", "value" => "unpublish")) }}
	@endif
	{{ HTML::link_to_action("admin.maps.edit", "Edit Map", array($map->id), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
	@if($modqueue == true)
	<div class="titlebar">
	<h2>Modqueue Item <strong>{{ e($modqueue->id) }}</strong></h2>
	</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Modqueue item found for: <strong>{{ e($map->title) }}</strong></p>
	<p>ID: {{ $modqueue->id }}</p>
	<p>Type: {{ $modqueue->type }}</p>
	<p>ItemID: {{ $modqueue->itemid }}</p>
	<p>ItemType: {{ $modqueue->itemtype }}</p>
	<p>User: {{ $modqueue->user->username }}</p>
	<p>Date Created: {{ date("F j, Y g:ia", strtotime($modqueue->created_at)) }}</p>
	<p>Additional Data: {{ $modqueue->data }}</p>
	{{ Form::submit("Delete from Modqueue", array("class" => "btn btn-danger", "name" => "action", "value" => "deletemodqueue")) }}
	{{ Form::close() }}
	@endif
</div>
@endsection
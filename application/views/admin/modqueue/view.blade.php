@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Editing ModQueue Item <b>{{$item->id}}</b></h2>
</div>
	<p>ID: {{ $item->id }}</p>
	<p>Type: {{ $item->type }}</p>
	<p>ItemID: {{ $item->itemid }}</p>
	<p>ItemType: {{ $item->itemtype }}</p>
	<p>User: {{ $item->user->username }}</p>
	<p>Date Created: {{ date("F j, Y g:ia", strtotime($item->created_at)) }}</p>
	<p>Additional Data: {{ $item->data }}</p>
	<div class="titlebar"><h4>Admin Notes <small>(Notes about this item such as why not published (No image, incorrect grammer etc.))</small></h4></div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	{{ Form::field("textarea", "admin_notes", "", array(Input::old("admin_notes", $item->admin_notes), array("rows" => "5")), array('error' => $errors->first('admin_notes'))) }}
	{{ HTML::link_to_action("admin.modqueue.delete", "Remove Modqueue item", array($item->id), array("class" => "btn btn-danger")) }}
	@if ($item->itemtype == "map" && $item->mapexists($item->itemid))
	{{ HTML::link_to_action("admin.maps.view", "Moderate Map", array($item->itemid), array("class" => "btn")) }}
	@elseif ($item->itemtype == "comment")
	@endif
	{{ Form::submit("Save Admin Notes", array("class" => "btn btn-warning", "name" => "action", "value" => "savemodqueuenotes")) }}
	{{ HTML::link_to_action("admin", "Cancel", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
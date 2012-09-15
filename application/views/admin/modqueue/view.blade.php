@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Editing ModQueue Item <b>{{$item->id}}</b></h2>
</div>
	<p>ID: {{ $item->id }}</p>
	<p>Type: {{ $item->type }}</p>
	<p>ItemID: {{ $item->itemid }}</p>
	<p>ItemType: {{ $item->itemtype }}</p>
	<p>User: {{ $item->user->username }}</p>
	<p>Date Created: {{ date("F j, Y g:ia", strtotime($item->created_at)) }}</p>
	<p>Additional Data: {{ $item->data }}</p>
	{{ HTML::link_to_action("admin.modqueue.delete", "Remove Modqueue item", array($item->id), array("class" => "btn btn-danger")) }}
	@if ($item->itemtype == "map")
	{{ HTML::link_to_action("admin.maps.edit", "Edit Map", array($item->itemid), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps.unpublish", "Unpublish Map", array($item->itemid), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps.publish", "Publish Map", array($item->itemid), array("class" => "btn")) }}
	{{ HTML::link_to_action("admin.maps.delete", "Delete Map", array($item->itemid), array("class" => "btn")) }}
	{{ HTML::link_to_action("maps.view", "View Map", array($item->itemid), array("class" => "btn")) }}
	@elseif ($item->itemtype == "comment")
	@endif
	{{ HTML::link_to_action("admin", "Cancel", array(), array("class" => "btn")) }}
</div>
@endsection
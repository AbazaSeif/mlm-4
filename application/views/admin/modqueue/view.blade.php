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
	{{ HTML::link_to_action("admin.modqueue.delete", "Remove Modqueue item", array($item->id), array("class" => "btn btn-danger")) }}
	@if ($item->itemtype == "map")
	{{ HTML::link_to_action("admin.maps.view", "Moderate Map", array($item->itemid), array("class" => "btn")) }}
	@elseif ($item->itemtype == "comment")
	@endif
	{{ HTML::link_to_action("admin", "Cancel", array(), array("class" => "btn")) }}
</div>
@endsection
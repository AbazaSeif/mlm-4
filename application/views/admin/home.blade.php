@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="admin clearfix">
	<div id="page" class="bigger">
		<div class="titlebar">
			<h2>Moderation queue</h2>
		</div>
		<div class="fixedheight">
		<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Type of moderation</th>
				<th>Item type</th>
				<th>Item creator</id>
				<th>Date created</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($modqueue->results as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ $item->type }}</td>
				<td>{{ $item->itemtype }}</td>
				<td>{{ $item->user->username }}</td>
				<td>{{ date("F j, Y g:ia", strtotime($item->created_at)) }}</td>
				<td>
					@if ($item->itemtype == "map" && Map::find($item->itemid) != null)
						{{ HTML::link_to_action("admin.maps.view", "View", array($item->itemid)) }}
					@elseif ($item->itemtype == "comment" && Comment::find($item->itemid) != null)
						{{ HTML::link_to_action("admin.comments.edit", "View", array($item->itemid)) }}
					@else
						{{ HTML::link_to_action("admin.modqueue@view", "View", array($item->id)) }}
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	</div>
	<div id="sidebar" class="smaller">
		<div class="titlebar">
			<h2>Admin log</h2>
		</div>
		<div class="fixedheight">
		<ol id="adminlog">
			@foreach($log->results as $logitem)
				<li class="logitem">
					{{$logitem->user->username}} {{$logitem->action}} {{$logitem->module}} item ID#{{$logitem->target}}
					@if($logitem->text)
					<br />{{$logitem->text}}
					@endif
					<date class="muted">{{ date("F j, Y g:ia", strtotime($logitem->created_at)) }}</date>
				</li>
			@endforeach
		</ol>
		{{ $log->links() }}
		</div>
	</div>
</div>
@endsection
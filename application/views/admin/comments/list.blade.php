@layout("layout.admin")

@section("content")
@parent
<div id="content">
	<div class="titlebar clearfix">
		<h2>Moderating Comments</h2>
	</div>
		<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>User</th>
				<th>Parent Item</th>
				<th>Comment</th>
				<th>Date created</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($comments as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("user", $item->user->username, array($item->user->username)) }}</A></td>
				@if($item->news_id != null)
				<td>{{ HTML::link_to_action("news.view", "News - ".$item->news_id, array($item->news_id)) }}</td>
				@elseif($item->map_id != null)
				<td>{{ HTML::link_to_action("maps.view", "Maps - ".$item->map_id, array($item->map_id)) }}</td>
				@else
				<td><b>ERROR</b></td>
				@endif
				<td>{{ $item->html }}
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.comments@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.comments@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			@endforeach
			</tr>
		</tbody>
	</table>
</div>
@endsection
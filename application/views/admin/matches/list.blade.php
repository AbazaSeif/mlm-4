@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Matches</h2>
	</div>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Map Name</th>
				<th>Game Type</th>
				<th>Number of Players</th>
				<th>Team Count</th>
				<th>Match Status</th>
				<th>Date created</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($matches as $item)
			<tr>
				<td>{{ $item->id }}</td>
				@if($item->map_id != null)
				<td><a href="{{ URL::to_action("maps@view", array($item->map_id)) }}">{{ $item->mapname }}</a></td>
				@else
				<td>{{ $item->mapname }}</td>
				@endif
				<td>{{ array_get(Config::get("maps.types"), $item->gametype) }}</td>
				<td>{{ $item->users()->count() }}</td>
				<td>{{ $item->team_count }}</td>
				<td>{{ array_get(Config::get("matches.status"), $item->status) }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.matches@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.matches@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			@endforeach
			</tr>
		</tbody>
	</table>
</div>
@endsection
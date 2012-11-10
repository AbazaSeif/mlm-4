@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Groups</h2>
	</div>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Group Name</th>
				<th>Number of Members</th>
				<th>Open</th>
				<th>Description</th>
				<th>Date created</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($groups as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ $item->name }}</td>
				<td>{{ $item->users()->where_invited(1)->count() }}</td>
				<td>
					@if($item->open)
						<i class="icon-eye-open" title="Open"></i>
					@else
						<i class="icon-eye-close" title="Closed"></i>
					@endif
				</td>
				<td>{{ $item->description }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.groups@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.groups@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			@endforeach
			</tr>
		</tbody>
	</table>
</div>
@endsection
@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Teams</h2>
	</div>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Team Name</th>
				<th>Number of Members</th>
				<th>Public</th>
				<th>Applications Open</th>
				<th>Date created</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($teams as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td><a href="{{ URL::to_action("teams@view", array($item->id)) }}">{{ $item->name }}</a></td>
				<td>{{ $item->users()->where_invited(1)->count() }}</td>
				<td>
					@if($item->public)
						<i class="icon-eye-open" title="Public"></i>
					@else
						<i class="icon-eye-close" title="Private"></i>
					@endif
				</td>
				<td>
					@if($item->applications_open)
						<i class="icon-ok-sign" title="Applications open"></i>
					@else
						<i class="icon-remove-sign" title="Applications closed"></i>
					@endif
				</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.teams@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.teams@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			@endforeach
			</tr>
		</tbody>
	</table>
</div>
@endsection
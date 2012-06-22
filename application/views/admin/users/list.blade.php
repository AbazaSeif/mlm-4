@layout('layout.admin')

@section('content')
@parent
<div id="content">
	<div class="titlebar clearfix">
		<h2>Users List</h2>
	</div>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Minecraft username</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->mc_username }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary" href="#" data-toggle="dropdown"><i class="icon-user icon-white"></i> Actions</a>
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.user@edit/".$user->id) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.user@ban/".$user->id) }}"><i class="icon-exclamation-sign"></i> Ban</a></li>
					</ul>
				</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
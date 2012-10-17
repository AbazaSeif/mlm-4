@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Users List</h2>
	</div>
	<table id="sortable" class="table table-bordered  table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Minecraft username</th>
				<th>Member since</th>
				<th>Rank</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ HTML::link("user/{$user->username}", $user->username, array("title" => "{$user->username}'s profile", "target" => "_blank")) }}</td>
				<td>{{ $user->mc_username }}</td>
				<td>{{ date("F j, Y g:ia", strtotime($user->created_at)) }}</td>
				<td>
					@if ($user->rank == 4)
					Admin
					@elseif ($user->rank == 3)
					Dev
					@elseif ($user->rank == 2)
					Editor
					@elseif ($user->rank == 1)
					Mod
					@else
					User
					@endif
				</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown">Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.user@edit/".$user->id) }}"><i class="icon-pencil"></i> Edit</a></li>
						@if($user->admin)
						<li><a href="{{ URL::to_action("admin.user@admin/".$user->id) }}"><i class="icon-user"></i> Admin</a></li>
						@else
						<li><a href="{{ URL::to_action("admin.user@unadmin/".$user->id) }}"><i class="icon-remove"></i> UnAdmin</a></li>
						@endif
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
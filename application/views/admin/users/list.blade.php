@layout('admin.home')

@section('content')
@parent
<div class="content">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Minecraft username</th>
				<th>Actions</th>
			</tr>
		</thead>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->mc_username }}</td>
				<td>{{ HTML::link_to_action('admin.user@edit', "Edit", array($user->id)) }}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection
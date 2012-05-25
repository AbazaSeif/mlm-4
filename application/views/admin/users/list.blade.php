@layout('layout.main')

@section('content')
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
		</tr>
	@endforeach
</table>
@endsection
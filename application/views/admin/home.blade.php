@layout('layout.main')

@section('content')
<div class="content">
	{{ HTML::link("admin", "Admin") }}
	<ul>
		<li>{{ HTML::link("admin/user", "Admin - User") }}</li>
	</ul>
</div>
@endsection
@layout('layout.main')

@section('content')
{{ HTML::link("admin", "Admin") }}
<ul>
	<li>{{ HTML::link("admin/user", "Admin - User") }}</li>
</ul>
@endsection
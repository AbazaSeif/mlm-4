@layout('layout.main')

@section('content')
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('user', 'Your Profile'); }}</li>
			<li>{{ HTML::link("account", "Edit Profile") }}</li> 
			<li>{{ HTML::link("user/avatar", "Change your avatar") }}</li>
		</ul>
	</nav>
@endsection
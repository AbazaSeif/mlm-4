@layout('layout.main')

@section('content')
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('Profile', 'Your Profile'); }}</li>
			<li>{{ HTML::link("user/edit", "Edit Profile") }}</li> 
			<li>{{ HTML::link("user/avatar", "Change your avatar") }}</li>
		</ul>
	</nav>
@endsection
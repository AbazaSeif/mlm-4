@layout('layout.main')

@section('content')
@if (Auth::check())
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('user', 'Your Profile'); }}</li>
			<li>{{ HTML::link("account", "Edit Profile") }}</li> 
		</ul>
	</nav>
@endif
@endsection
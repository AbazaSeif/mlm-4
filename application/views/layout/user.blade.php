@layout('layout.main')

@section('content')
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('user', 'Your Profile'); }}</li>
			<li>{{ HTML::link("account", "Edit Account") }}</li> 
		</ul>
	</nav>
@endsection
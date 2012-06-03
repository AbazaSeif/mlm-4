@layout('layout.main')

@section('content')
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('admin', 'Admin Home'); }}</li>
			<li>{{ HTML::link("admin/user", "Users") }}</li> 
			<li>{{ HTML::link("admin/pages", "Pages") }}</li>
			<li>{{ HTML::link("admin/news", "News") }}</li>
			<li><a onClick="MLM.images.open(); return false;" href="#" >Images</a></li>
		</ul>
	</nav>
@endsection

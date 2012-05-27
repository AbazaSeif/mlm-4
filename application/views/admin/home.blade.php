@layout('layout.main')

@section('content')
<nav id="adminmenu">
			<ul>
			    <li>{{ HTML::link('admin', 'Admin Home'); }}</li>
				<li>{{ HTML::link("admin/user", "Users") }}</li> 
				<li>{{ HTML::link("admin/pages", "Pages") }}</li>
			</ul>
</nav>
@endsection

@section('adminhome')
<div class="content">
<h1>THIS IS A TEST</h1>
</div>
@endsection
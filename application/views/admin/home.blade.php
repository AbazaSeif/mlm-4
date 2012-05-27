@layout('layout.main')

@section('content')
<nav id="adminmenu">
			<ul>
			    <li>{{ HTML::link('admin', 'Admin Home'); }}</li>
				<li>{{ HTML::link("admin/user", "Users") }}</li> 
				<li>{{ HTML::link("admin/pages", "Pages") }}</li>
				<li>{{ HTML::link('tournaments', 'Tournaments'); }}</li>
				<li>{{ HTML::link('maps', 'Maps'); }}</li>
				<li>{{ HTML::link('teams', 'Teams'); }}</li> 
				<li>{{ HTML::link('rankings', 'Rankings'); }}</li> 
				<li>{{ HTML::link('faq', 'FAQ'); }}</li> 
			</ul>
</nav>

<div class="content">
<h1>THIS IS WHERE OTHER PAGES ARE SUPPOSED TO LOAD</h1>
</div>
@endsection
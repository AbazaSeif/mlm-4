<ul class="nav nav-list">
	<li>{{ HTML::link("imgmgr/list/maps", "Maps") }}</li>
	@if(Auth::user()->admin)
	<li>{{ HTML::link("imgmgr/list/uploads", "Uploads") }}</li>
	@endif
</ul>
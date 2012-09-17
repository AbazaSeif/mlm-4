@layout("layout.main")

@section("content")
@include("maps.menu")
<ul id="multiview-controler" class="nav nav-pills">
	<li class="disabled"><a href="#">Views:</a></li>
	<li data-multiview="grid"><a href="#">Grid</a></li>
	<li data-multiview="list"><a href="#">List</a></li>
	<li data-multiview="big"><a href="#">Big</a></li>
</ul>
<div id="content" class="maps clearfix">
<div id="page" class="bigger">
<div id="multiview">
<ul class="{{ Cookie::get('multiview', 'grid') }}">
@foreach ($maps->results as $map)
	<li>
		<div class="mv-image">
			<img src="http://placekitten.com/704/480" alt="map image"/>
		</div>
		<div class="mv-details">
			<h4>{{ HTML::link_to_action("maps@view", $map->title, array($map->id, $map->slug)) }}</h4>
			<p>{{ $map->summary }}</p>
		</div>
		<div class="mv-meta">
				<span>By <a href="#">User #1</a></span>
				<span>Posted on <b>12/21/12</b></span>
				<span>Downloads: <b>9000</b></span>
		</div>
	</li>
@endforeach
</ul>
</div>
</div>

<div id="sidebar" class="smaller">
<div class="widget">
	<header><h1>Sidebar Header</h1></header>
	<div class="content">
	<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
	</div>
</div>
<div class="widget">
	<header><h1>Sidebar Header</h1></header>
	<div class="content">
	<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
	</div>
</div>

</div>
</div>
@endsection
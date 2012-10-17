@layout("layout.main")

@section("content")
@include("maps.menu")
<div id="content" class="maps clearfix">
<div id="page" class="maxwidth">
<div id="multiview">
<ul class="{{ Cookie::get('multiview', 'grid') }}">
@foreach ($maps->results as $map)
	<li>
		<a href="{{ URL::to_action("maps@view", array($map->id, $map->slug)) }}" title="">
		<div class="mv-image">
		@if($map->image)
		{{ HTML::image($map->image->file_medium) }}
		@else
		<img src="{{ URL::to_asset("images/static/noimage.jpg") }}" alt="No Images found" />
		@endif
		</div>
		<div class="mv-details">
		<div class="mv-title"><h1>{{ e($map->title) }}</h1></div>
		<div class="mv-summary"><p>{{ $map->summary }}</p></div>
		<div class="mv-meta">
			<span>By <b>The Author</b></span>
			<span>Version <b>1.0</b></span>
			<span>Downloads <b>9000</b></span>
		</div>
		</div>
		</a>
	</li>
@endforeach
</ul>
</div>
<div id="loadmore"><a href="#">LOAD MORE</a></div>
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
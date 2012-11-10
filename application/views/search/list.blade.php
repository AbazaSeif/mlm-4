@layout("layout.main")

@section('content')
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Search:</a></li>
	<li><a href="/search?type=search&query={{ $query }}" title="Search All">All</a></li>
	<li><a href="/search?type=news&query={{ $query }}" title="Search News">News</a></li>
	<li><a href="/search?type=maps&query={{ $query }}" title="Search Maps">Maps</a></li>
	<li><a href="/search?type=comments&query={{ $query }}" title="Search Comments">Comments</a></li>
	<li><a href="/search?type=users&query={{ $query }}" title="Search Users">Users</a></li>
	<li><a href="/search?type=teams&query={{ $query }}" title="Search Teams">Teams</a></li>
	<li><a href="/search?type=groups&query={{ $query }}" title="Search Groups">Groups</a></li>
</ul>
<div id="content">
<div class="titlebar">
	<h2>Search Results</h2></br>
	<h4>Searched for: &nbsp<b>{{ $query }}</b>
	<div class="right"><b>{{ count($results->results) }}</b> Results</div><br/>
	@if($type != null)
	Searched only for: &nbsp<b>{{ $type }}</b>
	@endif
	</h4>
</div>
<div id="multiview">
<ul class ="list">
@foreach($results->results as $item)
	@if(get_class($item) == "User")
		@include("search.views.users")
	@elseif(get_class($item) == "Map")
		@include("search.views.maps")
	@elseif(get_class($item) == "News")
		@include("search.views.news")
	@elseif(get_class($item) == "Match")
		@include("search.views.matches")
	@elseif(get_class($item) == "Comment")
		@include("search.views.comments")
	@elseif(get_class($item) == "Team")
		@include("search.views.teams")
	@elseif(get_class($item) == "Group")
		@include("search.views.groups")
	@else
		<li>
			<div class="mv-details">
			<div class="mv-title"><h1>ID: {{ $item->id }}</h1></div>
			<div class="mv-summary"><p></p></div>
			<div class="mv-meta">
				<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
				<span>Item Type: <b>{{ Str::singular(get_class($item)) }}</b></span>
			</div>
			</div>
		</li>
	@endif
@endforeach
</ul>
</div>
</div>
@endsection
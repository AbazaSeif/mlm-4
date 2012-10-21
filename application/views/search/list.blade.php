@layout("layout.main")

@section('content')
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
	@if($item->searchresulttype == "users")
		@include("search.views.users")
	@elseif($item->searchresulttype == "maps")
		@include("search.views.maps")
	@elseif($item->searchresulttype == "news")
		@include("search.views.news")
	@elseif($item->searchresulttype == "matches")
		@include("search.views.matches")
	@elseif($item->searchresulttype == "comments")
		@include("search.views.comments")
	@else
		<li>
			<div class="mv-details">
			<div class="mv-title"><h1>ID: {{ $item->id }}</h1></div>
			<div class="mv-summary"><p></p></div>
			<div class="mv-meta">
				<span>Search Hits: <b>{{ $item->searchhitcount }}</b></span>
				<span>Item Type: <b>{{ Str::singular($item->searchresulttype) }}</b></span>
			</div>
			</div>
		</li>
	@endif
@endforeach
</ul>
</div>
</div>
@endsection
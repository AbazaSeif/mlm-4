{{ Messages::get_html() }}
<div class="row-fluid">
	<div class="span2">
		@include("images.menu")
	</div>
	<div class="span10">
		<ul>
		@forelse($results->results as $result)
			<li>{{ HTML::link("imgmgr/list/".$type."/".$result->{$resultid}, $result->{$resulttext}) }}</li>
		@empty
			<li>No results found</li>
		@endforelse
		</ul>
	</div>
</div>
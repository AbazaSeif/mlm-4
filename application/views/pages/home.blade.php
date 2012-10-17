@layout('layout.main')
@section('content')

<div id="home" class="clearfix">
<div class="slider-wrapper theme-default">
	<div id="slider" class="nivoSlider">
	<a href="#" title="some title">
		<img src="{{ URL::to_asset("images/slides/1.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/1.jpg") }}" alt="" />
	</a>
	<a href="#" title="some title">
		<img src="{{ URL::to_asset("images/slides/2.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/2.jpg") }}" alt="" />
	</a>
	<a href="#" title="some title">
		<img src="{{ URL::to_asset("images/slides/3.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/3.jpg") }}" alt=""/>
	</a>
	<a href="#" title="some title">
		<img src="{{ URL::to_asset("images/slides/4.jpg") }}" data-thumb="{{ URL::to_asset("images/slides/4.jpg") }}" alt="" />
	</a>
	</div>

</div>

<div id="content" class="homecontent clearfix">
	<div id="page" class="bigger">
		<div id="feed-item">
			<div class="item-image"></div>
			<div class="item-content"></div>
		</div>
	</div>
	<div id="sidebar" class="smaller"></div>
</div>

</div>
@endsection
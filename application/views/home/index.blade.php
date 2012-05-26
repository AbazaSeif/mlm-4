@layout('layout.main')

@section('content')
<div id="home">

<div id="slider">
		<a href="#"><img src="{{ URL::to_asset("images/slides/1.jpg") }}" data-caption="#caption1" /></a>
		<a href="#"><img src="{{ URL::to_asset("images/slides/2.jpg") }}" data-caption="#caption2" /></a>
		<a href="#"><img src="{{ URL::to_asset("images/slides/3.jpg") }}" data-caption="#caption3" /></a>
		<a href="#"><img src="{{ URL::to_asset("images/slides/4.jpg") }}" data-caption="#caption4" /></a>
		<a href="#"><img src="{{ URL::to_asset("images/slides/5.jpg") }}" data-caption="#caption5" /></a>
		<a href="#"><img src="{{ URL::to_asset("images/slides/6.jpg") }}" data-caption="#caption6"  /></a>
		</div>
		<!-- Captions  -->
		<span class="orbit-caption" id="caption1">Caption 1</span>
		<span class="orbit-caption" id="caption2">Caption 2</span>
		<span class="orbit-caption" id="caption3">Caption 3</span>
		<span class="orbit-caption" id="caption4">Caption 4</span>
		<span class="orbit-caption" id="caption5">Caption 5</span>
		<span class="orbit-caption" id="caption6">Caption 6</span>	
		

<div class="featured">
	<br style="clear:both" />
</div>

<div class="ticker">
	<br style="clear:both" />
</div>

</div>
@endsection
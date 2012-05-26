@layout('layout.main')

@section('content')
<div id="home">

<div id="slider">
		<a href="#" data-caption="#caption1" ><img src="{{ URL::to_asset("images/slides/1.jpg") }}" /></a>
		<a href="#" data-caption="#caption2" ><img src="{{ URL::to_asset("images/slides/2.jpg") }}" /></a>
		<a href="#" data-caption="#caption3" ><img src="{{ URL::to_asset("images/slides/3.jpg") }}" /></a>
		<a href="#" data-caption="#caption4" ><img src="{{ URL::to_asset("images/slides/4.jpg") }}" /></a>
		<a href="#" data-caption="#caption5" ><img src="{{ URL::to_asset("images/slides/5.jpg") }}" /></a>
		<a href="#" data-caption="#caption6" ><img src="{{ URL::to_asset("images/slides/6.jpg") }}"  /></a>
		</div>
		
		<!-- Captions  -->
		<span class="orbit-caption" id="caption1">Caption 1</span>
		<span class="orbit-caption" id="caption2">Caption 2</span>
		<span class="orbit-caption" id="caption3">Caption 3</span>
		<span class="orbit-caption" id="caption4">Caption 4</span>
		<span class="orbit-caption" id="caption5">Caption 5</span>
		<span class="orbit-caption" id="caption6">Caption 6</span>	

<div class="featured">
	<br class="clear" />
</div>

<div id="ticker"> <!--
		<p>And that is to have sharks with frickin' laser beams attached to their heads! </p>
		<p>Now evidently, my cycloptic colleague informs me that that can't be done. </p>
		<p>Can you remind me what I pay you people for? </p>
		<p>Honestly, throw me a bone here. What do we have? </p>
	<p>You know, I have one simple request.</p> -->
</div>

</div>
@endsection
@layout('layout.main')

@section('content')
<div id="home" class="clearfix">
<div id="slider">
		<a href="#" data-caption="#caption1" ><img src="{{ URL::to_asset("images/slides/1.jpg") }}"></a>
		<a href="#" data-caption="#caption2" ><img src="{{ URL::to_asset("images/slides/2.jpg") }}"></a>
		<a href="#" data-caption="#caption3" ><img src="{{ URL::to_asset("images/slides/3.jpg") }}"></a>
		<a href="#" data-caption="#caption4" ><img src="{{ URL::to_asset("images/slides/4.jpg") }}"></a>
		<a href="#" data-caption="#caption5" ><img src="{{ URL::to_asset("images/slides/5.jpg") }}"></a>
		<a href="#" data-caption="#caption6" ><img src="{{ URL::to_asset("images/slides/6.jpg") }}" ></a>
		</div>
		
		<!-- Captions  -->
		<span class="orbit-caption" id="caption1">Caption 1</span>
		<span class="orbit-caption" id="caption2">Caption 2</span>
		<span class="orbit-caption" id="caption3">Caption 3</span>
		<span class="orbit-caption" id="caption4">Caption 4</span>
		<span class="orbit-caption" id="caption5">Caption 5</span>
		<span class="orbit-caption" id="caption6">Caption 6</span>	

<div class="featured"></div>

<?php /*
<div id="ticker">
	<div class="clear shadow"></div>
		<span><a target="_blank" href="http://www.kotaku.com/kanye-zone">...a perversely addictive thing. <i>&#151; Kotaku.com</i></a></span>
		<span><a target="_blank" href="http://www.metro.us/newyork/entertainment/article/1122080--welcome-to-kanye-zone-the-dumbest-game-you-will-spend-20-minutes-playingheboombox.com/2012/03/12/kanye-west-game-kanye-zone/">Playing incessently all the while is the excerpt of... "Paris" <i>&#151; Metro</i></a></span>
		<span><a target="_blank" href="http://www.2dopeboyz.com/2012/03/10/play-the-kanye-blame-game-kanye-zone">As if you needed yet another reason to spend countless hours on the internet. A simple, silly, yet dizzingly captivating game in which your goal is to prevent 'Ye from getting into his zone. <i>&#151; 2dopeboyz.com</i></a></span>
		<span><a target="_blank" href="http://thestreetstalk.com/archives/12866">It's most fun when you're stoned. <i>&#151; TheStreetTalk</i></a></span>
</div>
*/ ?>

<div id="content" class="homecontent clearfix">
	<section>
	<h3>News</h3>
	trololol
	</section>
	<section>
	<h3>Maps</h3>
	trololol
	</section>
	<section>
	<h3>Tournaments</h3>
	trololol
	</section>
</div>

</div>
@endsection
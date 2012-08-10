@layout('layout.main')

@section('content')
<div id="home" class="clearfix">

<div id="iview">
			<div data-iview:image="{{ URL::to_asset("images/slides/1.jpg") }}" data-iview:transition="slice-top-fade,slice-right-fade">
				<div class="iview-caption caption1" data-x="80" data-y="200">iView<sup>&trade;</sup></div>
				<div class="iview-caption" data-x="60" data-y="255" data-transition="wipeRight">The world's most awesome jQuery Image & Content Slider</div>
				<div class="iview-caption" data-x="234" data-y="300" data-transition="wipeLeft"><i>Presented by <b>Hemn Chawroka</b></i></div>
			</div>

			<div data-iview:image="{{ URL::to_asset("images/slides/2.jpg") }}" data-iview:transition="zigzag-drop-top,zigzag-drop-bottom" data-iview:pausetime="3000">
				<div class="iview-caption caption5" data-x="40" data-y="260" data-transition="wipeDown">Captions can be positioned and resized freely</div>
				<div class="iview-caption caption6" data-x="280" data-y="330" data-transition="wipeUp"><a href="#">Example URL-link</a></div>
			</div>

			<div data-iview:image="{{ URL::to_asset("images/slides/3.jpg") }}" data-iview:transition="zigzag-drop-top,zigzag-drop-bottom" data-iview:pausetime="3000">
				<div class="iview-caption caption5" data-x="40" data-y="260" data-transition="wipeDown">Captions can be positioned and resized freely</div>
				<div class="iview-caption caption6" data-x="280" data-y="330" data-transition="wipeUp"><a href="#">Example URL-link</a></div>
			</div>

			<div data-iview:image="{{ URL::to_asset("images/slides/4.jpg") }}">
				<div class="iview-caption caption4" data-x="50" data-y="80" data-width="312" data-transition="fade">Some of iView's Options:</div>
				<div class="iview-caption blackcaption" data-x="50" data-y="135" data-transition="wipeLeft" data-easing="easeInOutElastic">Touch swipe for iOS and Android devices</div>
				<div class="iview-caption blackcaption" data-x="50" data-y="172" data-transition="wipeLeft" data-easing="easeInOutElastic">Image And Thumbs Fully Resizable</div>
				<div class="iview-caption blackcaption" data-x="50" data-y="209" data-transition="wipeLeft" data-easing="easeInOutElastic">Customizable Transition Effect</div>
				<div class="iview-caption blackcaption" data-x="50" data-y="246" data-transition="wipeLeft" data-easing="easeInOutElastic">Freely Positionable and Stylable Captions</div>
				<div class="iview-caption blackcaption" data-x="50" data-y="283" data-transition="wipeLeft" data-easing="easeInOutElastic">Cross Browser Compatibility!</div>
			</div>

			<div data-iview:image="{{ URL::to_asset("images/slides/5.jpg") }}">
				<div class="iview-caption caption7" data-x="0" data-y="0" data-width="160" data-height="460" data-transition="wipeRight"><h3>The Responsive Caption</h3>This is the product that you <b><i>all have been waiting for</b></i>!<br><br>Customize this slider with just a little HTML and CSS to your very needs. Give each slider some captions to transport your message.<br><br>All in all it works on every browser (including IE6 / 7 / 8) and on iOS and Android devices!</div>
			</div>

			<div data-iview:image="{{ URL::to_asset("images/slides/6.jpg") }}">
				<div class="iview-caption caption5" data-x="40" data-y="130" data-transition="wipeLeft">What are you waiting for?</div>
				<div class="iview-caption caption6" data-x="140" data-y="210" data-transition="wipeRight">Get it Now!</div>
			</div>
		</div>

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
<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li>{{ HTML::link("account", "Newest") }}</li>
		<li>{{ HTML::link('user', 'Featured'); }}</li>
		<li>{{ HTML::link("account", "Highest ranked") }}</li>
		<li>{{ HTML::link("account", "Official Maps") }}</li>
		<li class="dropdown">
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories
        	<b class="caret"></b>
      		</a>
    		<ul class="dropdown-menu">
    		<li>{{ HTML::link("maps/?rtw", "Race For Wool") }}</li>
      		<li>{{ HTML::link("maps/?ctq", "Capture the Wool") }}</li>
      		<li>{{ HTML::link("maps/?dtc", "Destroy the Core") }}</li>
      		<li>{{ HTML::link("maps/?att", "Attack/Defence") }}</li>
      		<li>{{ HTML::link("maps/?bed", "Bed Wars") }}</li>
      		<li>{{ HTML::link("maps/?oth", "Other") }}</li>
    		</ul>
  		</li>
		@if (Auth::check())
		<li {{ URI::is('maps/new') ? 'class="rside active"' : 'class="rside"' }}>{{ HTML::link("maps/new", "New Map") }}</li>
		<li {{ URI::is('user/maps') ? 'class="rside active"' : 'class="rside"' }}><a href="{{ URL::to("user/".Auth::user()->username) }}">Your Maps</a></li>
		@endif
	</ul>
</nav>
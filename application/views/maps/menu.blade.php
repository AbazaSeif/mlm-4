<nav id="pagemenu" class="clearfix">
	<ul class="nav nav-tabs">
		<li {{ (Input::get('order') == 'newest') ? 'class="active"' : ''}}>{{HTML::link("maps/filter?order=newest", "Newest") }}</li>
		<li {{ (Input::get('featured') == 'true') ? 'class="active"' : ''}}>{{ HTML::link('maps/filter?featured=true', 'Featured'); }}</li>
		<li {{ (Input::get('order') == 'best') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter?order=best", "Highest ranked") }}</li>
		<li {{ (Input::get('official') == 'true') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter?official=true", "Official Maps") }}</li>
		<li class="dropdown">
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories
        	<b class="caret"></b>
      		</a>
    		<ul class="dropdown-menu">
    		<li {{ (Input::get('type') == 'rtw') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=rtw", "Race For Wool") }} </li>
      		<li {{ (Input::get('type') == 'ctq') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=ctq", "Capture the Wool") }}</li>
      		<li {{ (Input::get('type') == 'dtc') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=dtc", "Destroy the Core") }}</li>
      		<li {{ (Input::get('type') == 'att') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=att", "Attack/Defence") }}</li>
      		<li {{ (Input::get('type') == 'bed') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=bed", "Bed Wars") }}</li>
      		<li {{ (Input::get('type') == 'oth') ? 'class="active"' : ''}}>{{ HTML::link("maps/filter/?type=oth", "Other") }}</li>
    		</ul>
  		</li>
		@if (Auth::check())
		<li {{ URI::is('maps/new') ? 'class="rside active"' : 'class="rside"' }}>{{ HTML::link("maps/new", "New Map") }}</li>
		<li {{ URI::is('user/maps') ? 'class="rside active"' : 'class="rside"' }}><a href="{{ URL::to("user/".Auth::user()->username) }}">Your Maps</a></li>
		@endif
	</ul>
</nav>
<nav id="pagemenu">
	<ul class="nav nav-tabs">
		<li {{ URI::is('user*') ? 'class="active"' : '' }}>{{ HTML::link(("user/".Auth::user()->username), "Profile"); }}</li>
		<li {{ URI::is('messages*') ? 'class="dropdown active"' : 'dropdown' }}>
    		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span title="{{ e(Auth::user()->unread_messages) }} new messages">[{{ e(Auth::user()->unread_messages) }}]</span> Messages
        	<b class="caret"></b>
      		</a>
    		<ul class="dropdown-menu">
      		<li>{{ HTML::link("messages", "Inbox") }}</li>
      		<li>{{ HTML::link("messages/new", "New") }}</li>
    		</ul>
  			</li>
		<li {{ URI::is('account') ? 'class="rside active"' : 'class="rside"' }}>{{ HTML::link("account", "Edit Account") }}</li> 
	</ul>
</nav>
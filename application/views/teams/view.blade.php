@layout("layout.main")

@section('content')
@include("teams.menu")
@if($is_owner)
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Actions:</a></li>
	<li>{{ HTML::link_to_action("teams@edit", "Edit Team", array($team->id)) }}</li>
	<li>{{ HTML::link_to_action("teams@applications", "Team Applications", array($team->id)) }}</li>
</ul>
@endif
<div id="content" class="profile team clearfix">
	@if($is_owner === 0)
	<div class="alert alert-info alert-block alertfix clearfix">
		<p>You have been invited to become an owner of this team.</p>
		{{ Form::open("teams/owner_invite/".$team->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("teams/owner_invite/".$team->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif
	@if($is_invited === 0)
	<div class="alert alert-info alert-block alertfix clearfix">
		<p>You have been invited to join this team.</p>
		{{ Form::open("teams/invite/".$team->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("teams/invite/".$team->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif

{{-----------------------------------}}

<header id="vcard" class="clearfix">
	<div class="avatar">
		<a href="#" style="cursor:default"><img src="http://placekitten.com/80/80" alt="avatar" /></a>
	</div>
	<div class="name">
		<h1>{{ $team->name }}</h1>
		<h2>{{ $team->tagline }}</h2>
		<h3>Created/Added: {{ date("F j, Y", strtotime($team->created_at)) }}</h3>
	</div>
	<div class="stats">
		<ul>
			<li><a href="#team-wins" data-toggle="tab"><span>888</span>Wins</a></li>
			<li><a href="#team-loses" data-toggle="tab"><span>000</span>Loses</a></li>
			<li><a href="#team-members" data-toggle="tab"><span>{{ count($team->users) }}</span>Members</a></li>
		</ul>
	</div>
	<div class="abotalit"><ul><li></li></ul></div>
</header>
<div id="page" class="right">
	<div id="TeamTabs" class="tab-content">
		<div class="tab-pane active fade in" id="team-wins">
			<div class="titlebar center"><h2>Trophy Case</h2></div>
			<div class="case">
				<ul>
					<li><a href="#"><i class="icon-trophy gold"></i></a></li>
					<li><a href="#"><i class="icon-trophy silver"></i></a></li>
					<li><a href="#"><i class="icon-trophy bronze"></i></a></li>
					<li><a href="#"><i class="icon-trophy"></i></a></li>
					<li><a href="#"><i class="icon-trophy"></i></a></li>
					<li><a href="#"><i class="icon-trophy"></i></a></li>					
				</ul>
			</div>
			<div class="titlebar center"><h3>Matches won</h3></div>
			<ul class="thumbnails">
				@foreach($team->users as $user)
					<li class="tile" title="{{ $user->username }}"><a href="{{ URL::to("user/".$user->username)}}" class="thumbnail"><img src="{{$user->avatar_url}}" alt=""></a></li>
				@endforeach
			</ul>
		</div>
		<div class="tab-pane fade in" id="team-loses">
			<div class="titlebar center"><h2>Loses</h2></div>
			<ul class="thumbnails">
				@foreach($team->users as $user)
					<li class="tile" title="{{ $user->username }}"><a href="{{ URL::to("user/".$user->username)}}" class="thumbnail"><img src="{{$user->avatar_url}}" alt=""></a></li>
				@endforeach
			</ul>
		</div>
		<div class="tab-pane fade in" id="team-members">
			<div class="titlebar center"><h2>Members</h2></div>
			<ul class="thumbnails">
				@foreach($team->users as $user)
					<li class="tile" title="{{ $user->username }}"><a href="{{ URL::to("user/".$user->username)}}" class="thumbnail"><img src="{{$user->avatar_url}}" alt=""></a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
<div id="sidebar" class="left">
	<div class="block maxwidth">
		<div class="titlebar"><h2>Team Bio</h2></div>
	{{ $team->description }}
	</div>
</div>
<?php /*
	<h4>Details</h4>
	<hr>
		<p>Name: {{ $team->name }}</p>
		<p>Tagline: {{ $team->tagline }}</p>
		<p>Description: {{ $team->description }}</p>
	<br/>
	<h4>Players in Team</h4>
	<hr>
	@foreach($team->users as $user)
	<p>
		@if ($team->is_owner($user) === 1)
		<b>{{ $user->username }}</b>
		@elseif ($team->is_invited($user) === 1)
		{{ $user->username }}
		@endif
	</p>
	@endforeach
	@if (Auth::check() && Auth::user()->in_team($team->id) && $is_invited === 1)
	<a href="{{ URL::to_action("teams@leave", array($team->id)) }}" class="btn btn-danger" style="margin-bottom:15px"><i class="icon-minus"></i> Leave Team</a>
	@endif
	@if (Auth::check() && $has_applied == false && $is_invited === false)
	<a href="{{ URL::to_action("teams@apply", array($team->id)) }}" class="btn btn-success" style="margin-bottom:15px"><i class="icon-minus"></i> Apply to join Team</a>
	@endif
</div>
*/ ?>
@endsection
@layout("layout.main")

@section('content')
@include("matches.menu")
@if($is_owner || $is_invited)
<ul class="submenu nav nav-pills">
		<li class="disabled"><a href="#">Actions:</a></li>
	@if($is_owner)
		<li>{{ HTML::link_to_action("matches@edit", "Edit Match", array($match->id)) }}</li>
	@endif
	@if($is_invited)
		<li>{{ HTML::link_to_action("matches@teamchange", "Change Teams", array($match->id)) }}</li>
	@endif
</ul>
@endif

<div id="content">
	@if($is_owner === 0)
	<div class="alert alert-info alert-block alertfix clearfix">
		<p>You have been invited to be an owner of this match.</p>
		{{ Form::open("matches/owner_invite/".$match->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("matches/owner_invite/".$match->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif
	@if($is_invited === 0)
	<div class="alert alert-info alert-block alertfix clearfix">
		<p>You have been invited to join this match.</p>
		{{ Form::open("matches/invite/".$match->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "accept") }}
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Accept</button>
		{{ Form::close() }}
		{{ Form::open("matches/invite/".$match->id) }}
			{{ Form::token() }}
			{{ Form::hidden("action", "deny") }}
			<button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i> Deny</button>
		{{ Form::close() }}
	</div>
	@endif
	<h4>Details</h4>
	<hr>
	@if($map)
		<p>Map: <a href="{{ URL::to_action("maps@view", array($map->id)) }}">{{ $map->title }}</a></p>
	@else
		<p>Map: {{ $match->mapname }}</p>
	@endif
	<p>Game Type: {{ array_get(Config::get("maps.types"), $match->gametype) }}</p>
	<p>Teams: {{ $match->team_count }}</p>
	<p>Match Status: {{ array_get(Config::get("matches.status"), $match->status) }}</p>
	<h4>Match Info</h4>
	<hr>
	<p>{{ $match->info }}</p>
	<h4>Players</h4>
	<hr>
	@foreach($match->users as $user)
		@if ($user->pivot->invited === 1)
			@if ($user->pivot->teamnumber == 0)
				<li>{{ $user->username }} - Spectator</li>
			@else
				<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
			@endif
		@endif
	@endforeach
	@if(Auth::user() != null)
		@if($match->winningteam == null && !Auth::user()->in_match($match->id) && $match->invite_only == false)
			{{ Form::open("matches/join/".$match->id) }}
				{{ Form::token() }}
				{{ Form::hidden("action", "deny") }}
				<button type="submit" class="btn"><i class="icon-plus"></i> Join Match</button>
			{{ Form::close() }}
		@elseif($match->winningteam == null && Auth::user()->in_match($match->id) && $is_invited)
			<a href="{{ URL::to_action("matches@leave", array($match->id)) }}" class="btn btn-danger" style="margin-bottom:15px"><i class="icon-minus"></i> Leave Match</a>
		@elseif($match->winningteam != null)
			Winners:
			@foreach($match->users as $user)
				@if($user->pivot->teamnumber == $match->winningteam)
					<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
				@endif
			@endforeach
		@endif
	@endif
</div>
@endsection
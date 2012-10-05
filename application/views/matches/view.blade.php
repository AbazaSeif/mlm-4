@layout("layout.main")

@section('content')
@include("matches.menu")
@if($is_owner)
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Actions:</a></li>
	<li>{{ HTML::link_to_action("matches@edit", "Edit Match", array($match->id)) }}</li>
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
	<h4>Details</h4>
	<hr>
	@if($map)
		<p>Map: <a href="{{ URL::to_action("maps@view", array($map->id)) }}">{{ $map->title }}</a></p>
	@else
		<p>Map: {{ $match->mapname }}</p>
	@endif
	<p>Game Type: {{ array_get(Config::get("maps.types"), $match->gametype) }}</p>
	<p>Teams: {{ $match->team_count }}</p>
	<br/>
	<h4>Players</h4>
	<hr>
	@foreach($match->users as $user)
	<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
	@endforeach
	@if($match->winningteam == null && !Auth::user()->in_match($match->id))
		<a href="{{ URL::to_action("matches@join", array($match->id)) }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> Join Match</a>
	@elseif($match->winningteam == null && Auth::user()->in_match($match->id))
		<a href="{{ URL::to_action("matches@leave", array($match->id)) }}" class="btn btn-danger" style="margin-bottom:15px"><i class="icon-minus"></i> Leave Match</a>
	@elseif($match->winningteam != null)
		Winners:
		@foreach($match->users as $user)
			@if($user->pivot->teamnumber == $match->winningteam)
			<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
			@endif
		@endforeach
	@endif
</div>
@endsection
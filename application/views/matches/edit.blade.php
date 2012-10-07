@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing match <b>{{ e($match->id) }}</b></h2>
</div>
<div id="page" class="bigger">
	{{ Form::open("matches/edit_meta/".$match->id, "POST", array("class" => "form")) }}
		{{ Form::token()}}
		{{ Form::field("text", "mapname", "", array(Input::old("mapname", $match->mapname), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('mapname'))) }}
		@if($map)
			<p>Linked to map '<a href="{{ URL::to_action("maps@view", array($map->id)) }}">{{ $map->title }}</a>'</p>
		@endif
		<div class="titlebar"><h4>Game type</h4></div>
		{{ Form::field("select", "gametype", "", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("gametype", $match->gametype), array('class' => 'input')), array('error' => $errors->first('gametype'))) }}
		<div class="titlebar"><h4>Team Count (How many teams are playing the match)</h4></div>
		{{ Form::field("text", "team_count", "", array(Input::old("team_count", $match->team_count)), array("error" => $errors->first("team_count"))) }}
		<div class="titlebar"><h4>Match Info</h4></div>
		{{ Form::field("wysiwyg", "info", " ", array(Input::old("info", $match->info), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("info"))) }}		
		<div class="titlebar"><h4>Private Match (Can people view this match)</h4></div>
		{{ Form::field("checkbox", "private", "", array(Input::old("private", !($match->public))), array("error" => $errors->first("private"))) }}
		<div class="titlebar"><h4>Invite Only (do people have to be invited to join the match)</h4></div>
		{{ Form::field("checkbox", "invite", "", array(Input::old("invite", $match->invite_only)), array("error" => $errors->first("invite"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("matches@view", "Cancel", array($match->id), array("class" => "btn")))) }}
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Winners</h3>
	</div>
	{{ Form::open("matches/set_win/".$match->id, 'POST', array('class' => 'form')) }} 	
	{{ Form::token() }}
	{{ Form::field("select", "winteam", "", array(array_merge(array("--------------", "Draw"), $teamarray), Input::old("winteam", $match->winningteam + 1), array('class' => 'input')), array('error' => $errors->first('winteam'))) }}
	{{ Form::submit("Set Winning Team", array("class" => "btn btn-primary")) }}
	<div class="titlebar">
		<h3>Owners</h3>
	</div>
	<ul class="ulfix">
	@foreach($owners as $user)
		<li class="xpadding">
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/30" alt="avatar" /> {{$user->username}}
			@if(!$user->pivot->owner)
				<small>(Hasn't yet accepted the invite)</small>
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@else
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional owners (Use MLM username)</h4></div>
	{{ Form::open("matches/add_owner/".$match->id, 'POST', array('class' => 'xpadding')) }} 	
		<fieldset> 
			<div>
			{{ Form::token() }}
			{{ Form::text("username") }} 
			{{ Form::submit("Invite", array("class" => "btn btn-primary")) }}
			</div>
		</fieldset>
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Players</h3>
	</div>
	<ul class="ulfix">
	@foreach($match->users as $user)
		<li class="xpadding">
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/30" alt="avatar" /> {{$user->username}}
			@if(!$user->pivot->invited)
				<small>(Hasn't yet accepted the invite)</small>
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@endif
			@if($user->pivot->teamnumber != 0)
				<small>(Team {{ $user->pivot->teamnumber }})</small>
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional players (Use MLM username)</h4></div>
	{{ Form::open("matches/invite_user/".$match->id, 'POST', array('class' => 'xpadding')) }} 	
		<fieldset> 
			<div>
			{{ Form::token() }}
			{{ Form::text("username") }} 
			{{ Form::submit("Invite", array("class" => "btn btn-primary")) }}
			</div>
		</fieldset>
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Match Status</h3>
	</div>
	<p>Match Status: {{ array_get(Config::get("matches.status"), $match->status) }} <small>({{ $statusreason }})</small></p>
	@if ( $match->status == "planning" || $match->status == "planned" || $match->status == "in progress")
		<a href="{{ URL::to_action("matches@cancel", array($match->id)) }}" class="btn btn-danger">Cancel Match</a>
	@endif
</div>
</div>
@endsection
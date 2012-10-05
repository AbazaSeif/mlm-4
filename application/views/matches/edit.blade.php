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
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("matches@view", "Cancel", array($match->id), array("class" => "btn")))) }}
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Winners</h3>
	</div>
	{{ Form::open("matches/setwin/".$match->id, 'POST', array('class' => 'form')) }} 	
	{{ Form::token() }}
	{{ Form::field("select", "winteam", "", array(array_merge(array("" => "--------------"), $teamarray), Input::old("winteam", $match->winningteam - 1), array('class' => 'input')), array('error' => $errors->first('winteam'))) }}
	{{ Form::submit("Set Winning Team", array("class" => "btn btn-primary")) }}
	<div class="titlebar">
		<h3>Owners</h3>
	</div>
	<ul class="ulfix">
	@foreach($owners as $user)
		<li class="xpadding">
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/30" alt="avatar" /> {{$user->username}}
			@if(!$user->pivot->owner)
				Hasn't yet accepted the invite
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@else
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional owners (Use MLM username)</h4></div>
	{{ Form::open("matches/add_author/".$match->id, 'POST', array('class' => 'xpadding')) }} 	
		<fieldset> 
			<div>
			{{ Form::token() }}
			{{ Form::text("username") }} 
			{{ Form::submit("Invite", array("class" => "btn btn-primary")) }}
			</div>
		</fieldset>
	{{ Form::close() }}
</div>
</div>
@endsection
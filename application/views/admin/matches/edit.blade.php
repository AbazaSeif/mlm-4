@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Editing match <b>{{$match->id}}</b></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
	{{ Form::token() }}
	<formset>
		{{ Form::field("text", "mapname", "Map Name", array(Input::old("mapname", $match->mapname), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('mapname'))) }}
		@if($map)
		<p>Linked to map '<a href="{{ URL::to_action("maps@view", array($map->id)) }}">{{ $map->title }}</a>'</p>
		@endif
		{{ Form::field("select", "gametype", "Game Type", array(array_merge(array("" => "--------------"), Config::get("maps.types")), Input::old("gametype", $match->gametype), array('class' => 'input')), array('error' => $errors->first('gametype'))) }}
		{{ Form::field("text", "team_count", "Team count", array(Input::old("team_count", $match->team_count)), array("error" => $errors->first("team_count"))) }}
		{{ Form::field("wysiwyg", "info", "Match Info", array(Input::old("info", $match->info), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("info"))) }}		
		{{ Form::field("checkbox", "private", "Private match", array(Input::old("private", !($match->public))), array("error" => $errors->first("private"))) }}
		{{ Form::field("checkbox", "invite", "Invite Only", array(Input::old("invite", $match->invite_only)), array("error" => $errors->first("invite"))) }}
		{{ Form::field("select", "winteam", "Winning Team", array(array_merge(array("--------------", "Draw"), $teamarray), Input::old("winteam", $match->winningteam + 1), array('class' => 'input')), array('error' => $errors->first('winteam'))) }}
		
		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
</div>
@endsection
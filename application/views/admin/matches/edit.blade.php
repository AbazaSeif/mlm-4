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
		
		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
</div>
@endsection
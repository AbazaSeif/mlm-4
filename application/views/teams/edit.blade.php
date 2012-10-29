@layout("layout.main")

@section("content")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing team <b>{{ e($team->name) }}</b></h2>
</div>
<div id="page" class="bigger">
	{{ Form::open("teams/edit_meta/".$team->id, "POST", array("class" => "form")) }}
		{{ Form::token()}}
		{{ Form::field("text", "name", "", array(Input::old("name", $team->name), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('name'))) }}
		<div class="titlebar"><h4>Team Long bio</h4></div>
		{{ Form::field("wysiwyg-user", "description", " ", array(Input::old("description", $team->description), array("rows" => "15", 'class' => 'input-xxlarge')), array("error" => $errors->first("description"))) }}
		<div class="titlebar"><h4>Short bio <small>(140 characters)</small></h4></div>
		{{ Form::field("textarea", "summary", "", array(Input::old("summary", $team->summary), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'))) }}
		<div class="titlebar"><h4>Private Team <small>(Viewable only by members)</small></h4></div>
		{{ Form::field("checkbox", "private", "", array(Input::old("private", !($team->public))), array("error" => $errors->first("private"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("teams@view", "Cancel", array($team->id), array("class" => "btn")))) }}
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Owners</h3>
	</div>
	<ul class="ulfix">
	@foreach($owners as $user)
		<li class="xpadding">
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/30" alt="avatar" /> {{$user->username}}
			@if($user->pivot->owner === 0)
				<small>(Hasn't yet accepted the invite)</small>
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional owners (Use MLM username)</h4></div>
	{{ Form::open("teams/add_owner/".$team->id, 'POST', array('class' => 'xpadding')) }} 	
		<fieldset> 
			<div>
			{{ Form::token() }}
			{{ Form::text("username") }} 
			{{ Form::submit("Invite", array("class" => "btn btn-primary")) }}
			</div>
		</fieldset>
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Members</h3>
	</div>
	<ul class="ulfix">
	@foreach($team->users as $user)
		<li class="xpadding">
			<img src="http://minotar.net/helm/{{ $user->mc_username }}/30" alt="avatar" /> {{$user->username}}
			@if(!$user->pivot->invited)
				<small>(Hasn't yet accepted the invite)</small>
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@endif
			@if($team->is_owner($user) == false)
				<small>{{ HTML::link_to_action("teams@kick", "Kick from team", array($team->id, $user->username), array("class" => "btn btn-danger")) }}</small>
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional members to the team (Use MLM username)</h4></div>
	{{ Form::open("teams/invite_user/".$team->id, 'POST', array('class' => 'xpadding')) }} 	
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
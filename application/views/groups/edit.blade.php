@layout("layout.main")

@section("content")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing Group <b>{{ e($group->name) }}</b></h2>
</div>
<div id="page" class="bigger">
	{{ Form::open("groups/edit_meta/".$group->id, "POST", array("class" => "form")) }}
		{{ Form::token()}}
		{{ Form::field("text", "name", "", array(Input::old("name", $group->name), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('name'))) }}
		{{ Form::field("text", "description", "Group description", array(Input::old("description", $group->description), array('class' => 'subtitle')), array('error' => $errors->first('description'))) }}
		{{ Form::field("checkbox", "private", "Private Team", array(Input::old("private", !($group->open))), array("error" => $errors->first("private"), "alt" => "(Only joinable through an invitation)")) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary")), " ", HTML::link_to_action("user", "Cancel", array(), array("class" => "btn")))) }}
	{{ Form::close() }}
	<div class="titlebar">
		<h3>Owners</h3>
	</div>
	<ul class="ulfix">
	@foreach($owners as $user)
		<li class="xpadding">
			<img src="{{ $user->avatar_url }}" alt="avatar" width="30"/> {{$user->username}}
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
	{{ Form::open("groups/add_owner/".$group->id, 'POST', array('class' => 'xpadding')) }} 	
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
	@foreach($group->users as $user)
		<li class="xpadding">
			<img src="{{ $user->avatar_url }}" alt="avatar" width="30"/> {{$user->username}}
			@if(!$user->pivot->invited)
				<small>(Hasn't yet accepted the invite)</small>
			@endif
			@if($user->id == Auth::user()->id)
				<small>(You cannot remove yourself)</small>
			@endif
			@if($group->is_owner($user) == false)
				<small>{{ HTML::link_to_action("groups@kick", "Kick from group", array($group->id, $user->username), array("class" => "btn btn-danger")) }}</small>
			@endif
		</li>
	@endforeach
	</ul>
	<div class="titlebar"><h4>Invite additional members to the group (Use MLM username)</h4></div>
	{{ Form::open("groups/invite_user/".$group->id, 'POST', array('class' => 'xpadding')) }} 	
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
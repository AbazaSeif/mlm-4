@layout("layout.main")

@section('content')
@if($is_owner)
<ul class="submenu nav nav-pills">
	<li class="disabled"><a href="#">Actions:</a></li>
	<li>{{ HTML::link_to_action("teams@edit", "Edit Team", array($team->id)) }}</li>
	<li>{{ HTML::link_to_action("teams@applications", "Team Applications", array($team->id)) }}</li>
</ul>
@endif

<div id="content">
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
</div>
@endsection
@layout("layout.main")

@section('content')
@include("matches.menu")
<div id="content">
	Players:
	@foreach($match->users as $user)
	<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
	@endforeach
	@if($match->winningteam == null)
		<a href="{{ URL::to_action("matches@join", array($match->id)) }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> Join Team</a>
		<a href="{{ URL::to_action("matches@setwin", array($match->id)) }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> Set Winning Team</a>
	@else
		Winners:
		@foreach($match->users as $user)
			@if($user->pivot->teamnumber == $match->winningteam)
			<li>{{ $user->username }} - Team {{ $user->pivot->teamnumber }}</li>
			@endif
		@endforeach
	@endif
</div>
@endsection
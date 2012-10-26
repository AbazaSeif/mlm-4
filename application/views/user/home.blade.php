@layout("layout.main")
<?php $countries = require path("app")."countries.php"; ?>

@section('content')
@if($ownpage)
	@include("user.menu")
@endif
<div id="content" class="profile clearfix">
<header id="vcard" class="clearfix">
	<div class="avatar">
		@if($ownpage)
			<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="http://minotar.net/helm/{{$user->mc_username}}/80" alt="avatar" /></a>
		@else
			<a href="#" style="cursor:default" title="{{$user->username}}'s Skin"><img src="http://minotar.net/helm/{{$user->mc_username}}/80" alt="avatar" /></a>
		@endif
	</div>
	<div class="name">
		<h1>{{$user->username}}</h1>
		<h2><img src="{{ URL::to_asset("images/static/mc-icon.png") }}">{{$user->mc_username}}</h2>
		<h3>Joined {{ date("F j, Y", strtotime($user->created_at)) }}</h3>
	</div>
	<div class="stats">
		<ul>
			<li><a href="#"><span>{{ $user->comment_count }}</span>Comments</a></li>
			<li><a href="#"><span>456</span>Maps</a></li>
			<li><a href="#"><span>789</span>Wins</a></li>
			<li><a href="#"><span>012</span>Loses</a></li>
			<li><a href="#"><span>345</span>Ranking</a></li>
		</ul>
	</div>
	<div class="abotalit">
		<ul>
			<li style="padding-left:0;">
			@if ($user->rank == 4)<div class="user-rank admin" title="MLM Admin"></div>
			@elseif ($user->rank == 3)<div class="user-rank dev" title="MLM Developer"></div>
			@elseif ($user->rank == 2)<div class="user-rank editor" title="MLM Editor"></div>
			@elseif ($user->rank == 1)<div class="user-rank mod" title="MLM Moderator"></div>@endif
			</li>
			<li><a href="#" class="nm"><i class="icon-envelope-alt"></i></a></li>
			<li></li>
		</ul>
	</div>
</header>
	<div id="page">
		<div id="feed">
			<div class="titlebar">
				<h2>Feed</h2>
			</div>
		</div>
	</div>
	<aside id="sidebar">
		<div class="widget teaminfo">
			<header><h1>Team</h1></header>
		<div class="content">
			<a href="#"><img src="http://placekitten.com/100/100" />
				<div class="data">
					<p>The Quick Brown Fox Jumps Over The Lazy Dog</p>
					<ul class="numbers">
						<li>Wins<strong>888</strong></li>
						<li>Loses<strong>888</strong></li>
					</ul>
				</div>
			</a>
		</div>
		</div>
			<div class="widget">
				<header><h1>{{$user->username}}'s Info</h1></header>
			<div class="content">
			<div class="info">
		<ul>
		@if ($user->profile->reddit)
		<li>
		<label>Reddit</label>
		<p><a href="http://reddit.com/user/{{$user->profile->reddit}}" target="_blank" rel="nofollow">{{$user->profile->reddit}}</a></p>
		</li>
		@endif
		@if ($user->profile->twitter)
		<li>
		<label>Twitter</label>
		<p><a href="http://twitter.com/{{$user->profile->twitter}}" target="_blank" rel="nofollow">{{$user->profile->twitter}}</a></p>
		</li>
		@endif
		@if ($user->profile->youtube)
		<li>
		<label>YouTube</label>
		<p><a href="http://youtube.com/user/{{$user->profile->youtube}}" target="_blank" rel="nofollow">{{$user->profile->youtube}}</a></p>
		</li>
		@endif
		<li>
		<label>Member since</label>
		<p>{{ date("F j, Y", strtotime($user->created_at)) }}</p>
		</li>
		<li>
		<label>Last updated</label>
		<p>{{ date("F j, Y", strtotime($user->updated_at)) }}</p>
		</li>
		</ul>
			</div>
			</div>
	</aside>
</div>
@endsection
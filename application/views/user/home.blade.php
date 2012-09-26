@layout("layout.main")
<?php $countries = require path("app")."countries.php"; ?>

@section('content')
@if($ownpage)
	@include("user.menu")
@endif
<div id="content" class="profile clearfix">
	<div id="page">
		<div id="vcard" class="clearfix">
			<div class="picture">
				@if($ownpage)
					<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="http://minotar.net/helm/{{$user->mc_username}}/150" alt="avatar" /></a>
				@else
					<a href="#" style="cursor:default" title="{{$user->username}}'s Skin"><img src="http://minotar.net/helm/{{$user->mc_username}}/150" alt="avatar" /></a>
				@endif
			</div>
				<div class="data">
					{{-- User ranks --}}
					@if ($user->rank == 4)
					<div class="user-rank admin" title="MLM Admin"></div>
					@elseif ($user->rank == 3)
					<div class="user-rank dev" title="MLM Developer"></div>
					@elseif ($user->rank == 2)
					<div class="user-rank editor" title="MLM Editor"></div>
					@elseif ($user->rank == 1)
					<div class="user-rank mod" title="MLM Moderator"></div>
					@endif
					<h1>{{$user->username}}</h1>
					<h2><i class="flag flag-{{$user->profile->country}}"></i>{{$countries[$user->profile->country]}}</h2>
					@if ($user->profile->webzone)
					<h3>{{ HTML::link($user->profile->webzone, $user->profile->webzone, array("target" => "_blank","rel" => "nofollow")) }}</h3>
					@else
					<div class="clearfix" style="height:35px"></div>
					@endif
					<ul class="numbers">
						<li>Comments<strong>{{ $user->comment_count }}</strong></li>
						<li>Posts<strong>888</strong></li>
						<li>Rank<strong>888</strong></li>
					</ul>
				</div>
		</div>
		<div id="feed">
			<div class="titlebar clearfix">
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
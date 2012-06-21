@layout("layout.main")
<?php $countries = require path("app")."countries.php"; ?>

@section('content')
@if($ownpage)
	@include("user.menu")
@endif
<div id="content" class="profile clearfix">
	<div id="left">
			<div id="vcard" class="clearfix">
				<div class="pic">
				@if($ownpage)
					<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="http://minotar.net/helm/{{$user->mc_username}}/150.png" alt="avatar" /></a>
				@else
					<a href="#"><img src="http://minotar.net/helm/{{$user->mc_username}}/150.png" alt="avatar" /></a>
				@endif
				</div>
				<div class="data">
					<h1>{{$user->username}}</h1>
					<h3><i class="flag flag-{{$user->profile->country}}"></i>{{$countries[$user->profile->country]}}</h3>
					@if ($user->profile->webzone)
					<h4>{{ HTML::link($user->profile->webzone, $user->profile->webzone, array("target" => "_blank","rel" => "nofollow")) }}</h4>
					@else
					<div class="clearfix" style="height:35px"></div>
					@endif
					<div class="user-rank admin" title="MLM Admin"></div>
					<? /* Rank badges needs to be configured and set correct permissons.
					@if ($user->profile->rank => 0)
					<div class="user-rank admin" title="MLM Admin"></div> All of the access
					@if ($user->profile->rank => 1)
					<div class="user-rank dev" title="MLM Developer"></div> All of the access
					@if ($user->profile->rank => 2)
					<div class="user-rank contributor" title="MLM Contributor"></div> (or In-game Referee) Only has access to admin/news , all access to tournaments
					@if ($user->profile->rank => 3)
					<div class="user-rank mod" title="MLM Moderator"></div> only has access to admin/users,permisson to edit/delete map submissions, ban users, edit/delete user comments
					@else (user->profile->rank => 99) normies have no access to admin page :( Poor normies.
					@endif
					*/ ?>
					<ul class="numbers clearfix">
						<li>Comments<strong>888</strong></li>
						<li>Posts<strong>888</strong></li>
						<li>Rank<strong>888</strong></li>
					</ul>
				</div>
			</div>
	<div class="info clearfix">
		<ul>
		<li class="sep"><h4>Other info</h4></li>
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
		<label>Last update</label>
		<p>{{ date("F j, Y", strtotime($user->updated_at)) }}</p>
		</li>
		<? /*
		<li class="sep"><h4>Separator</h4></li>
		<li>
		<label>Name</label>
		<p>Content</p>
		</li>*/ ?>
		</ul>
	</div>
</div>
		<aside id="right">
			<section class="team">
				<header><h1>Team</h1></header>
				<div class="widget">
						<a href="#"><img src="http://placehold.it/100x100" />
						<div class="teaminfo">
						<p>The Quick Brown Fox Jumps Over The Lazy Dog</p>
						<ul class="winlose clearfix">
						<li>Wins<strong>888</strong></li>
						<li>Loses<strong>888</strong></li>
						</ul>
						</div>
						</a>
				</div>
			</section>
			<section class="sidecontent">
			<img src="http://placehold.it/336x280" alt="space">
			</section>
		</aside>
</div>
@endsection
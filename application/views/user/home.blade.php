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
					<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="http://minotar.net/helm/{{$user->mc_username}}/150.png" alt="avatar" /></a>
				</div>
				<div class="data">
					<h1>{{$user->username}}</h1>
					<h3><i class="flag flag-{{$user->profile->country}}"></i>{{$countries[$user->profile->country]}}</h3>
					@if ($user->profile->webzone)
					<h4>{{ HTML::link($user->profile->webzone, $user->profile->webzone, array("target" => "_blank","rel" => "nofollow")) }}</h4>
					@else
					<div class="clearfix" style="height:35px"></div>
					@endif
					<div class="user-rank developer" title="MLM Developer"></div>
					<ul class="numbers clearfix">
						<li>Comments<strong>888</strong></li>
						<li>Posts<strong>888</strong></li>
						<li>Rank<strong>888</strong></li>
					</ul>
				</div>
			</div>
	<div class="info clearfix">
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
		<? /*
		<li class="sep"><h4>Separator</h4></li>
		<li>
		<label>Name</label>
		<p>Content</p>
		</li>
		</ul>*/ ?>
	</div>
</div>
		<aside id="right">
			<section class="sidecontent">
				<div class="head"><h1>Team</h1></div>
				<div class="widget">
						<a href="#"><img src="http://placehold.it/100x100" /> ButCuba</a>
				</div>
			</section>
			<section class="sidecontent">
			<img src="http://placehold.it/336x280" alt="space">
			</section>
		</aside>
</div>
@endsection
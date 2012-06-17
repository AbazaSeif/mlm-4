@layout($layout)

@section('content')
@parent
<div id="content" class="profile clearfix">
	<div id="left">
			<div id="vcard" class="clearfix">
				<div class="pic">
					<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="http://minotar.net/helm/{{$user->mc_username}}/150.png" alt="avatar" /></a>
				</div>
				<div class="data">
					<h1>{{$user->username}}</h1>
					<?php $countries = require path("app")."countries.php"; ?>
					<h3><i class="flag flag-{{$user->profile->country}}"></i>{{$countries[$user->profile->country]}}</h3>
					<h4>{{ HTML::link($user->profile->webzone, $user->profile->webzone) }}</h4>
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
		<li>
			<label>Reddit</label>
			<p><a href="http://reddit.com/user/{{$user->profile->reddit}}" target="_blank">{{$user->profile->reddit}}</a></p>
		</li>
		<li>
			<label>Twitter</label>
			<p><a href="http://twitter.com/{{$user->profile->twitter}}" target="_blank">{{$user->profile->twitter}}</a></p>
		</li>
		<li>
			<label>YouTube</label>
			<p><a href="http://youtube.com/user/{{$user->profile->youtube}}" target="_blank">{{$user->profile->youtube}}</a></p>
		</li>
		<li>
			<label>Member since</label>
			<p>{{ date("F j Y", strtotime($user->created_at)) }}</p>
		</li>
		<li class="sep"><h4>Separator</h4></li>
		<li>
			<label>Name</label>
			<p>Content</p>
		</li>
		</ul>
	</div>
</div>
		<aside id="right">
			<section class="sidecontent">
				<div class="head"><h1>Team</h1></div>
				<div class="widget">
					<div class="badgeCount">
						<a href="#"><img src="http://minotar.net/helm/t2t2t/50.png" /> ButCuba</a>
					</div>
				</div>
			</section>
		</aside>
</div>
@endsection
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
					<h3><i class="flag flag-us"></i>United States</h3>
					<h4><a href="{{$user->webzone}}">http://example.com</a></h4>
					<div class="user-rank developer" title="MLM Developer"></div>
					<ul class="numbers clearfix">
						<li>Comments<strong>888</strong></li>
						<li>Posts<strong>888</strong></li>
						<li>Rank<strong>888</strong></li>
					</ul>
				</div>
			</div>

	<div class="big-info clearfix">
		<div class="title clearfix">
			<h2>TL;DR info for {{$user->username}}</h2>
		</div>
		<ul>
		<li>
			<label>Instant Messaging</label>
			<strong>Skype</strong>
		</li>
		<li>
			<label>Website</label>
			<strong><a href="http://utopicme.com" rel="nofollow">http://utopicme.com</a></strong>
		</li>
		<li>
			<label>Member since</label>
			<strong>{{ HTML::entities(date("F j Y", strtotime($user->created_at))) }}</strong>
		</li>
		<li class="sep"><h4>Separator</h4></li>
		<li>
			<label>Name</label>
			<strong>Content</strong>
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
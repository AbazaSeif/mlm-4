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
		<h2><img src="{{ URL::to_asset("images/static/mc-icon.png") }}" title="Minecraft Username">{{$user->mc_username}}</h2>
		<h3>Joined {{ date("F j, Y", strtotime($user->created_at)) }}</h3>
	</div>
	<div class="stats">
		<ul>
			<li><a href="#user-comments" data-toggle="tab"><span>{{ $user->comment_count }}</span>Comments</a></li>
			<?php $uid = $user->id ?>
			<li><a href="#user-maps" data-toggle="tab"><span>{{ DB::table("map_user")->where_user_id($uid)->count(); }}</span>Maps</a></li>
			<li><a href="#user-wins" data-toggle="tab"><span>789</span>Wins</a></li>
			<li><a href="#user-loses" data-toggle="tab"><span>012</span>Loses</a></li>
			<li><a href="#user-ranking" data-toggle="tab"><span>345</span>Ranking</a></li>
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
			<li><a href="{{ URL::to("messages/new") }}" title="Messages" data-value="Message {{$user->username}}"><i class="icon-envelope-alt"></i></a></li>
			@if ($user->profile->reddit)
			<li><a href="http://reddit.com/user/{{$user->profile->reddit}}" target="_blank" rel="nofollow" title="reddit" data-value="{{$user->profile->reddit}}"><i class="icon-arrow-up"></i></a></li>
			@endif
			@if ($user->profile->twitter)<li><a href="http://twitter.com/{{$user->profile->twitter}}" target="_blank" rel="nofollow" title="Twitter" data-value="{{$user->profile->twitter}}"><i class="icon-twitter"></i></a></li>
			@endif
			@if ($user->profile->youtube)
			<li><a href="http://youtube.com/user/{{$user->profile->youtube}}" target="_blank" rel="nofollow" title="YouTube" data-value="{{$user->profile->youtube}}"><i class="icon-play"></i></a></li>
			@endif
			@if ($user->profile->webzone)
			<li><a href="{{$user->profile->webzone}}" target="_blank" rel="nofollow" title="Website" data-value="{{$user->profile->webzone}}"><i class="icon-globe"></i></a></li>
			@endif
		</ul>
	</div>
</header>
<script type="text/javascript">
</script>
<div id="sidebar" class="left">
	<div class="titlebar"><h2>Team</h2></div>
</div>
	<div id="page" class="right">
		<div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active in" id="user-comments">
            <div class="titlebar"><h2>Comments</h2></div>
          </div>
          <div class="tab-pane fade" id="user-maps">
            <div class="titlebar"><h2>Maps</h2></div>
          </div>
          <div class="tab-pane fade" id="user-wins">
            <div class="titlebar"><h2>Wins</h2></div>
          </div>
          <div class="tab-pane fade" id="user-loses">
            <div class="titlebar"><h2>Loses</h2></div>
          </div>
          <div class="tab-pane fade" id="user-ranking">
            <div class="titlebar"><h2>Ranking</h2></div>
          </div>
        </div>
	</div>
	</div>
</div>
@endsection
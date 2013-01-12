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
			<a href="http://minecraft.net/profile" target="_blank" title="Change your skin..."><img src="{{$user->avatar_url}}" alt="avatar" /></a>
		@else
			<a href="#" style="cursor:default" title="{{$user->username}}'s Skin"><img src="{{$user->avatar_url}}" alt="avatar" /></a>
		@endif
	</div>
	<div class="name">
		<h1>{{$user->username}}</h1>
		<h2><img src="{{ URL::to_asset("images/static/mc-icon.png") }}" title="Minecraft Username">{{$user->mc_username}}</h2>
		<h3>Joined {{ date("F j, Y", strtotime($user->created_at)) }}</h3>
	</div>
	<div class="stats">
		<ul>
			<li class="active"><a href="#user-maps" data-toggle="tab"><span>{{ count($user->maps) }}</span>Maps</a></li>
			<li><a href="#user-comments" data-toggle="tab"><span>{{ $user->comment_count }}</span>Comments</a></li>
		</ul>
	</div>
	<div class="abotalit">
		<ul>
			@if ($user->rank == 4)<li style="padding-left:0;"><div class="user-rank admin" title="MLM Admin"></div></li>
			@elseif ($user->rank == 3)<li style="padding-left:0;"><div class="user-rank dev" title="MLM Developer"></div></li>
			@elseif ($user->rank == 2)<li style="padding-left:0;"><div class="user-rank editor" title="MLM Editor"></div></li>
			@elseif ($user->rank == 1)<li style="padding-left:0;"><div class="user-rank mod" title="MLM Moderator"></div></li>
			@endif
			<li><a href="{{ URL::to("messages/new/".$user->username) }}" title="Message {{$user->username}}"><i class="icon-envelope-alt"></i></a></li>
			@if ($user->profile->reddit)
			<li><a href="http://reddit.com/user/{{$user->profile->reddit}}" target="_blank" rel="nofollow" title="reddit"><i class="icon-arrow-up"></i></a></li>
			@endif
			@if ($user->profile->twitter)<li><a href="http://twitter.com/{{$user->profile->twitter}}" target="_blank" rel="nofollow" title="Twitter"><i class="icon-twitter"></i></a></li>
			@endif
			@if ($user->profile->youtube)
			<li><a href="http://youtube.com/user/{{$user->profile->youtube}}" target="_blank" rel="nofollow" title="YouTube"><i class="icon-play"></i></a></li>
			@endif
			@if ($user->profile->webzone)
			<li><a href="{{$user->profile->webzone}}" target="_blank" rel="nofollow" title="Website"><i class="icon-globe"></i></a></li>
			@endif
		</ul>
	</div>
</header>
<div>
	<div id="UserTabs" class="tab-content">
		<div class="tab-pane fade active in" id="user-maps">
			<div class="titlebar"><h2>Maps</h2></div>
			<div id="multiview">
				<ul class="list">
				@forelse($user->maps as $map)
				@if($map->published)
					<li>
					<a href="{{ URL::to_action("maps@view", array($map->id, $map->slug)) }}" title="View map">
						<div class="mv-image">
							@if($map->image)
							<img src="{{ URL::to_asset("images/static/blank.gif") }}" data-original="{{ e($map->image->file_medium) }}" alt="{{ e($map->title) }}" />
							@else
							<img src="{{ URL::to_asset("images/static/noimage.jpg") }}" data-original="{{ URL::to_asset("images/static/noimage.jpg") }}" alt="No Image" />
							@endif
						</div>
						<div class="mv-details">
							<div class="mv-icon">
								@if($map->featured)
								<span title="Featured Map"><i class="icon-star"></i></span>
								@elseif($map->official)
								<span title="Official Map"><i class="icon-trophy"></i></span>
								@endif
							</div>
							<div class="mv-title"><h1>{{ e($map->title) }}</h1></div>
							<div class="mv-summary"><p>{{ e($map->summary) }}</p></div>
							<div class="mv-meta">
								<span>By
									@foreach($map->users as $author)
									<b>{{ $author->username }}</b>,
									@endforeach
								</span>
								@if($map->version)
								<span>Version <b>{{e($map->version->version)}}</b>,</span>
								@endif
								<span>Type: <b>{{ array_get(Config::get("maps.types"), $map->maptype) }}</b></span>
							</div>
						</div>
						</a>
					</li>
				@endif
				@empty
				<div class="mv-details"><div class="mv-title">
				<h1 class="center">@if($ownpage)You haven't
					@else{{ $user->username }} has not
					@endif posted any maps :(
					@if($ownpage)<br><a href="/maps">Post a new map!</a>
					@endif
				</h1>
				</div></div>
				@endforelse
				</ul>
			</div>
		</div>
		<div class="tab-pane fade" id="user-comments">
			<div class="titlebar"><h2>Comments</h2></div>
				<div id="multiview">
				<ul class="list">
				@forelse($user->comments as $item)
					<li>
						@if($item->news_id != null)
						<a href="{{ URL::to_action("news@view", array($item->news->id, $item->news->slug)) }}" title="View comment">
						@else
						<a href="{{ URL::to_action("maps@view", array($item->map->id, $item->map->slug)) }}" title="View comment">
						@endif
						<div class="mv-details">
							<div class="mv-summary">{{ $item->html }}</div>
							<div class="mv-meta">
							<span>commented on <b>
								@if($item->news_id != null)
								{{ Str::limit($item->news->title, 30) }}
								@elseif($item->map_id != null)
								{{ Str::limit($item->map->title, 30) }}
								@else
								<b>[Deleted]</b>
								@endif
								</b></span> on <span><b>{{ date("M j,Y g:ia", strtotime($item->created_at)) }}</b></span>
							</div>
						</div>
						</a>
					</li>
				@empty
				<div class="mv-details"><div class="mv-title">
				<h1 class="center">@if($ownpage)You haven't
					@else{{ $user->username }} has not
					@endif posted any comments :(
				</h1>
				</div></div>
				@endforelse
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
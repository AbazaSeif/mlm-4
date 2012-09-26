<div id="comments">
	@if( $map->comment_count == 0)
	<div class="titlebar"><h2>No Comments</h2></div>
	@elseif ( $map->comment_count == 1)
	<div class="titlebar"><h2><b>1</b> Comment</h2></div>
	@else
	<div class="titlebar"><h2><b>{{ $map->comment_count }}</b> Comments</h2></div>
	<div class="showcomments" style="display:none;"></div>
	@endif

<ol class="commentlist">
	@foreach($map->comments as $comment)
	<li>
		<div id="comment{{$comment->id}}">
			<div class="vcard"> 
			<img class="avatar" src="http://minotar.net/helm/{{$comment->user->mc_username}}/150.png" alt="{{ $comment->user->username }}'s skin" title="{{ $comment->user->username }}'s skin">
			<a class="username" href="/user/{{ $comment->user->username }}" title="{{$comment->user->username}}'s Profile">{{ $comment->user->username }}</a> Says:
			</div>
		<div class="body">
			{{ $comment->html }}
		</div>
		<div class="meta">
			<span class="time"><a href="{{ URL::to_action("news@view", array($map->id, $map->slug)) }}#comment{{$comment->id}}">{{ date("M j,Y g:ia", strtotime($comment->created_at)) }}</a></span>
			<div class="actions">
			<span><a href="#"><i class="icon-share-alt"></i> Reply</a></span> {{-- Supposed to bring the comment imput up and add comment under parent --}}
			<span><a href="#"><i class="icon-arrow-up"></i> Upvote</a></span> {{-- Adds a star somewhere in the comment if it has more than 10 upvotes --}}
			<span><a href="#"><i class="icon-flag"></i> Report</a></span> {{-- this is a popup with a dropdown with reasons and a little imput field --}}
			@if (Auth::user() && Auth::user()->admin)
			<span> | <a href="#" onclick="return false"><i class="icon-cog"></i> Moderate</a></span> {{-- Delete comment, Message user, Ban user --}}
			@else
			@endif
			</div>
		</div>
		</div>
	</li>
	@endforeach
</ol>
<div id="respond">
	@if(Auth::check())
		<h3>Post a new comment</h3>
		<div id="comment">
			<p class="help">Live preview</p>
			<div class="vcard"> 
			<img class="avatar" src="http://minotar.net/helm/{{Auth::user()->mc_username}}/150.png" alt="{{Auth::user()->username}}'s skin">
			<a class="username" href="/user/{{Auth::user()->username}}" title="{{Auth::user()->username}}'s Profile">{{Auth::user()->username}}</a> Says:
		</div>
		<div class="body">
			<div id="preview"></div>
		</div>
		</div>
		{{ Form::open("maps/comment/".$map->id) }}
		{{ Form::token() }}
		{{ Form::field("textarea", "comment", "", array(Input::old("comment"), array("id" => "mrk", "class" => "input-xxlarge")), array('error' => $errors->first('comment'))) }}
		{{ Form::submit("Post", array("class" => "btn-primary")) }}
		{{ HTML::link('#', 'Preview', array("class" => "btn", "id" => "prevb")); }}
		{{ Form::close() }}
	@else
	<h4>You must be <a href="/login">logged in</a> to leave a comment.</h4>
	@endif
</div>
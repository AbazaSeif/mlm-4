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
		<span class="time"><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comment{{$comment->id}}">{{ date("M j,Y g:ia", strtotime($comment->created_at)) }}</a></span>
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
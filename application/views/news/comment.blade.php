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
		<span class="time"><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comment{{$comment->id}}" title="Permalink to comment">{{ date("M j, Y g:ia", strtotime($comment->created_at)) }}</a></span>
		<div class="actions">
		@if (Auth::user() && Auth::user()->admin)
		<span><a href="/admin/comments#comment{{ $comment->id }}" target="_blank"><i class="icon-cog"></i> Moderate</a></span> {{-- Delete comment, Message user, Ban user --}}
		@else
		@endif
		</div>
	</div>
	</div>
</li>
<li>
	<div id="comment-{{$comment->id}}">
		<div class="vcard">
			<img class="avatar" src="{{$comment->user->avatar_url}}" alt="{{ $comment->user->username }}'s skin" title="{{ $comment->user->username }}'s skin">
			<a class="username" href="/user/{{ $comment->user->username }}" title="{{$comment->user->username}}'s Profile">{{ $comment->user->username }}</a> Says:
		</div>
		<div class="body">
			{{ $comment->html }}
		</div>
		<div class="meta">
			<span class="time"><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comment{{$comment->id}}" title="Permalink to comment">{{ date("M j, Y g:ia", strtotime($comment->created_at)) }}</a></span>
			<div class="actions">
			@if(Auth::check())
			<span><a href="#"><i class="icon-share-alt"></i> Reply</a></span> {{-- Supposed to bring the comment imput up and add comment under parent --}}
			<span><a href="#"><i class="icon-arrow-up"></i> Upvote</a></span> {{-- Adds a star somewhere in the comment if it has more than 10 upvotes --}}
			<span><a href="#" rel="popover" data-html="true"
			data-content='
			{{ Form::open("news/reportcomment", "POST", array("class" => "center")) }}
			{{ Form::token() }}
			{{ Form::hidden("id", $comment->id) }}
			{{ Form::field("select", "type", "Reason for Reporting", array(Config::get("admin.report-types"))) }}
			{{ Form::field("textarea", "details", "Additional Details", array(Input::old("summary"), array("rows" => "5"))) }}
			{{ Form::submit("Submit Report", array("class" => "btn-danger")) }}
			{{ Form::close() }}
			' data-original-title='Report Comment'><i class="icon-flag"></i> Report</a></span> {{-- this is a popup with a dropdown with reasons and a little imput field --}}
			@endif
			@if (Auth::user() && Auth::user()->admin)
			<span> | <a href="#" onclick="return false"><i class="icon-cog"></i> Moderate</a></span> {{-- Delete comment, Message user, Ban user --}}
			@else
			@endif
			</div>
		</div>
		@if(count($comment->children) > 0)
			<ul>
				@foreach($comment->children as $childcomment)
					{{ render("news.comment", array("comment" => $childcomment, "article" => $article)) }}
				@endforeach
			</ul>
		@endif
	</div>
</li>
@layout("layout.main")

@section("content")
@include("news.menu")
@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
@endif
<div id="content" class="news clearfix">
<div id="page">
<div class="post single"> 
		<section class="post-image"> 
		{{ HTML::image($article->image->file_large, "Image") }}
		</section> 
	<div class="post-content clearfix">
	<div class="post-info">
		<span class="date"><p class="bold">{{ date("M j", strtotime($article->created_at)) }}</p>{{ date("Y", strtotime($article->created_at)) }}<br>{{ date("g:ia T", strtotime($article->created_at)) }}</span>
		<span class="comments-nr"><a href="#comments"><p class="bold">{{ $article->comment_count }}</p>{{ Str::plural('comment', $article->comment_count) }}</a></span>
		<p><span>By</span> <a href="/user/{{ $article->user->username }}" title="{{ $article->user->username }}'s Profile" rel="author">{{ $article->user->username }}</a></p>
		<p><span>In</span> <a href="/news/category/" title="View all posts in CATEGORY" rel="category tag">CATEGORY</a></p>
	</div>
		<div class="post-entry"> 
		<h1 class="title">{{ e($article->title) }}</h1> 
		{{ $article->content }}
	</div> 
	</div>

<div id="comments">
	@if( $article->comment_count == 0)
	<div class="titlebar clearfix"><h2>No Comments</h2></div>
	@else
	<div class="titlebar clearfix"><h2><b>{{ $article->comment_count }}</b> Comments</h2></div>
	<div class="showcomments" style="display:none;"></div>
	@endif

<ol class="commentlist">
	@foreach($article->comments as $comment)
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
	@endforeach
</ol>

	<div id="respond">
	@if(Auth::check())
		<h3>Leave a new comment</h3>
		<div id="comment">
			<div class="vcard"> 
			<img class="avatar" src="http://minotar.net/helm/{{$comment->user->mc_username}}/150.png" alt="{{ $comment->user->username }}'s skin" title="{{ $comment->user->username }}'s skin">
			<a class="username" href="/user/{{ $comment->user->username }}" title="{{$comment->user->username}}'s Profile">{{ $comment->user->username }}</a> Says:
			</div>
		<div class="body">
			<div id="preview"></div>
		</div>
		</div>
		{{ Form::open("news/comment/".$article->id) }}
		{{ Form::token() }}
		{{ Form::field("textarea", "comment", "", array(Input::old("comment"), array("id" => "mrk", "class" => "input-xxlarge")), array('error' => $errors->first('comment'), "help" => "Markdown supported")) }}
		{{ Form::submit("Post", array("class" => "btn-primary")) }}
		{{ HTML::link('#', 'Preview', array("class" => "btn", "id" => "prevb")); }}
		{{ Form::close() }}
	@else
	<h4>You must be <a href="/login">logged in</a> to leave a comment.</h4>
	@endif
	</div>
</div>
</div>
</div>
@include("news.sidebar")	
</div>
@endsection
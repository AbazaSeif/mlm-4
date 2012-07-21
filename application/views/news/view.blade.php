@layout("layout.main")

@section("content")
<div id="content" class="news clearfix">
@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
	@endif
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
	<h2>No Comments</h2>
	@else
	<div class="titlebar clearfix">
	<h2><b>{{ $article->comment_count }}</b> Comments</h2>
	</div>
	@endif					
<ul id="commentlist">
	@foreach($article->comments as $comment)
	<li>
		<div class="comment">					
			<div id="comment{{$comment->id}}">
				<img class="avatar" src="http://minotar.net/helm/{{$comment->user->mc_username}}/50.png" alt="{{ $comment->user->username }}'s skin" title="{{ $comment->user->username }}'s skin">
				<a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comment{{$comment->id}}">{{ date("M j,Y g:ia", strtotime($comment->created_at)) }}</a>
				<a href="/user/{{ $comment->user->username }}" title="{{$comment->user->username}}'s Profile">{{ $comment->user->username }}</a> says:
			</div>
		<div class="message">
			<p>{{ $comment->html }}</p>
		</div>
		</div>
	</li>
	@endforeach
</ul>
<div id="respond">
	@if(Auth::check())
		<h4>Leave a comment</h4>
		{{ Form::open("news/comment/".$article->id) }}
		{{ Form::token() }}
		{{ Form::field("textarea", "comment", "", array(Input::old("comment"), array("class" => "input-xxlarge")), array('error' => $errors->first('comment'))) }}
		{{ Form::submit("Comment", array("class" => "btn-primary")) }}
		{{ Form::close() }}
	@else
	You must be <a href="/login">logged in</a> to leave a comment.
	@endif
</div>
</div>
</div>
@include("news.sidebar")	
</div>
@endsection
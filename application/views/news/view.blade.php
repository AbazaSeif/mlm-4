@layout("layout.main")

@section("content")
<div id="content" class="news clearfix">
@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
	@endif
<article class="post single"> 
		<section class="post-image"> 
		{{ HTML::image($article->image->file_large, "Image") }}
		</section> 
	<div class="post-content clearfix">
	<div class="post-info">
		<span class="date"><p class="bold">{{ date("M j", strtotime($article->created_at)) }}</p>{{ date("Y", strtotime($article->created_at)) }}<br>{{ date("g:ia T", strtotime($article->created_at)) }}</span>
		<span class="comments-nr"><a href="#"><p class="bold">{{ $article->comment_count }}</p> {{ Str::plural('comment', $article->comment_count) }}</a></span>
		<p><span>By</span> <a href="/user/{{ $article->user->username }}" title="{{ $article->user->username }}'s Profile" rel="author">{{ $article->user->username }}</a></p>
		<p><span>In</span> <a href="/news/category/" title="View all posts in CATEGORY" rel="category tag">CATEGORY</a></p>
	</div>
		<div class="post-entry"> 
		<h1 class="title">{{ e($article->title) }}</h1> 
		{{ nl2br(e($article->summary)) }}
		{{ $article->content }}
	</div> 
	</div>
	<h3>Comments ({{ $article->comment_count }})</h3>
	@foreach($article->comments as $comment)
		{{ $comment->user->username }} {{ $comment->created_at }}<br />
		{{ $comment->html }}
	@endforeach
	@if(Auth::check())
		<h4>Leave a comment</h4>
		{{ Form::open("news/comment/".$article->id) }}
		{{ Form::token() }}
		{{ Form::field("textarea", "comment", "Comment", array(Input::old("comment"), array("class" => "input-xxlarge")), array('error' => $errors->first('comment'))) }}
		{{ Form::submit("Comment", array("class" => "btn-primary")) }}
		{{ Form::close() }}
	@else
	You must be logged in to leave a comment.
	@endif
</article>
@include("news.sidebar")	
</div>
@endsection
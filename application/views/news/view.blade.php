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
	<h2 class="title">{{ e($article->title) }}</h2>
	<div class="meta clearfix">
		<div class="left">
		<a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}" class="more"><i class="icon-link"></i> Permalink</a>
		<a href="/user/{{ $article->user->username }}" class="author" title="{{ $article->user->username }}'s Profile" rel="author"><i class="icon-user"></i> {{ $article->user->username }}</a>
		<a href="#discussion" class="comment-nr" title="Jump to comments"><i class="icon-comments"></i> {{ $article->comment_count }}</a>		
		</div>
		<div class="right">
		<span class="date"><a href="#"><i class="icon-calendar"></i> {{ HTML::entities(date("F j, Y g:ia", strtotime($article->created_at))) }}</a></span>
		</div>
	</div>
	<div class="entry">
		{{ HTML::image($article->image->file_medium, "Image",array("class" => "image")) }}
		{{ $article->content }}
	</div>
</div>
@include("news.comments")
</div>
</div>
@include("news.sidebar")
</div>
@endsection
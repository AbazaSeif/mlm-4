@layout("layout.main")

@section('content')
@include("news.menu")
<div id="content" class="news clearfix">
<div id="page">

@foreach($newslist->results as $article)
<div class="post">
	<h2 class="title">{{ HTML::link_to_action("news@view", $article->title, array($article->id, $article->slug)) }}</h2>
		<p class="meta"><span class="date">Posted {{ HTML::entities(date("F j, Y g:ia T", strtotime($article->created_at))) }}</span><span class="posted">Posted by <a href="/user/{{ $article->user->username }}" title="{{ $article->user->username }}'s Profile" rel="author">{{ $article->user->username }}</a></span></p>
	<div class="entry">
		{{ HTML::image($article->image->file_large, "Image") }}
		{{ nl2br(e($article->summary)) }}
	<p class="links"><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}" class="more">Read More</a><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comments" title="b0x" class="comments">{{ $article->comment_count }} {{ Str::plural('Comment', $article->comment_count) }}</a></p>
	</div>
</div>
@endforeach


@foreach($newslist->results as $article)
	<div class="post"> 
		<div class="post-image"> 
		{{ HTML::image($article->image->file_large, "Image") }}
		</div> 
	<div class="post-content">
	<div class="post-info">
		<span class="date"><p class="bold">{{ HTML::entities(date("M j", strtotime($article->created_at))) }}</p>{{ HTML::entities(date("Y", strtotime($article->created_at))) }}<br>{{ HTML::entities(date("g:ia T", strtotime($article->created_at))) }}</span>
		<span class="comments-nr"><a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comments"><p class="bold">{{ $article->comment_count }}</p> {{ Str::plural('comment', $article->comment_count) }}</a></span>
		<p><span>By</span> <a href="/user/{{ $article->user->username }}" title="{{ $article->user->username }}'s Profile" rel="author">{{ $article->user->username }}</a></p>
		<p><span>In</span> <a href="/news/category/" title="View all posts in CATEGORY" rel="category tag">CATEGORY</a></p>
	</div>
		<div class="post-entry"> 
		<h1 class="title">{{ HTML::link_to_action("news@view", $article->title, array($article->id, $article->slug)) }}</h1> 
		{{ nl2br(e($article->summary)) }}
		{{ HTML::link_to_action("news@view", "Read More &raquo;" , array($article->id, $article->slug), array("class" => "more-link", )) }}
	</div> 
	</div>
</div>
@endforeach
</div>
@include("news.sidebar")
</div>
@endsection
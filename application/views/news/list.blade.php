@layout("layout.main")

@section('content')
<div id="content" class="news clearfix">
<div class="titlebar clearfix">
	<h1>The News</h1>
</div>
<div class="articles clearfix">
	@foreach($newslist->results as $article)
	<div class="post"> 
		<section class="post-image"> 
		{{ HTML::image($article->image->file_large, "Image") }}
		</section> 
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
<?php
// For Leon's lazyness
$fakepaginator = Paginator::make($newslist->results, 100, 10);
echo $fakepaginator->links();
?>
</div>
@include("news.sidebar")
</div>
@endsection
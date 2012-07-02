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
	<div class="post-content">
	<div class="post-info">
		<span class="date"><p class="bold">{{ HTML::entities(date("M j", strtotime($article->created_at))) }}</p>{{ HTML::entities(date("Y", strtotime($article->created_at))) }}<br>{{ HTML::entities(date("g:ia T", strtotime($article->created_at))) }}</span>
		<span class="comments-nr"><a href="#"><p class="bold">888</p> comments</a></span>
		<p><span>By</span> <a href="/user/{{ $article->user->username }}" title="{{ $article->user->username }}'s Profile" rel="author">{{ $article->user->username }}</a></p>
		<p><span>In</span> <a href="/news/category/" title="View all posts in CATEGORY" rel="category tag">CATEGORY</a></p>
	</div>
		<div class="post-entry"> 
		<h1 class="title">{{ e($article->title) }}</h1> 
		{{ nl2br(e($article->summary)) }}
		{{ HTML::link_to_action("news@view", "Read More &raquo;" , array($article->id, $article->slug), array("class" => "more-link", )) }}
	</div> 
	</div>
</article>
@include("news.sidebar")	
</div>
@endsection
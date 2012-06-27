@layout("layout.main")

@section('content')
<div id="content" class="news clearfix">
<div class="titlebar clearfix">
		<h1>The News</h1>
	</div>
<div class="articles clearfix">
	@foreach($newslist->results as $article)
	<article class="post"> 
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
		<h1 class="title">{{ HTML::link_to_action("news@view", $article->title, array($article->id, $article->slug)) }}</h1> 
		{{ nl2br(e($article->summary)) }}
		{{ HTML::link_to_action("news@view", "Read More &raquo;" , array($article->id, $article->slug), array("class" => "more-link", )) }}
	</div> 
	</div>
</article>
@endforeach
<?php
// For Leon's lazyness
$fakepaginator = Paginator::make($newslist->results, 100, 10);
echo $fakepaginator->links();
?>
</div>

<aside id="sidebar">
<ul>
<li>
	<div id="search" >
		<form method="get" action="#" class="nobg">
				<div class="input-append">
                <input class="sbar" size="16" type="text"><button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i></button>
              </div>
		</form>
	</div>
</li>
<li>
	<header><h1>Sidebar Header</h1></header>
	<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
</li>
<li>
	<header><h1>Categories</h1></header>
	<ul>
		<li><a href="#">Aliquam libero</a></li>
		<li><a href="#">Consectetuer adipiscing elit</a></li>
		<li><a href="#">Metus aliquam pellentesque</a></li>
		<li><a href="#">Suspendisse iaculis mauris</a></li>
		<li><a href="#">Urnanet non molestie semper</a></li>
		<li><a href="#">Proin gravida orci porttitor</a></li>
	</ul>
</li>
<li>
	<header><h1>Archives</h1></header>
	<ul>
		<li><a href="#">Aliquam libero</a></li>
		<li><a href="#">Consectetuer adipiscing elit</a></li>
		<li><a href="#">Metus aliquam pellentesque</a></li>
		<li><a href="#">Suspendisse iaculis mauris</a></li>
		<li><a href="#">Urnanet non molestie semper</a></li>
		<li><a href="#">Proin gravida orci porttitor</a></li>
	</ul>
</li>
<li>
	<header><h1>Archives</h1></header>
	<ul>
		<li><a href="#">Aliquam libero</a></li>
		<li><a href="#">Consectetuer adipiscing elit</a></li>
		<li><a href="#">Metus aliquam pellentesque</a></li>
		<li><a href="#">Suspendisse iaculis mauris</a></li>
		<li><a href="#">Urnanet non molestie semper</a></li>
		<li><a href="#">Proin gravida orci porttitor</a></li>
	</ul>
</li>
</ul>
</aside>
</div>
@endsection
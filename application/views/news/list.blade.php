@layout("layout.main")

@section('content')
@include("news.menu")
<div id="content" class="news clearfix">
<div id="page">

@foreach($newslist->results as $article)
<div class="post">
	<h2 class="title">{{ HTML::link_to_action("news@view", $article->title, array($article->id, $article->slug)) }}</h2>
	<div class="entry">
		{{ HTML::image($article->image->file_large, "Image",array("class" => "post-image")) }}
		{{ nl2br(e($article->summary)) }}

	<div class="meta clearfix">
		<div class="left">
		<a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}" class="more">Read Full Post</a>
		<a href="{{ URL::to_action("news@view", array($article->id, $article->slug)) }}#comments" class="comments" title="{{ $article->comment_count }} {{ Str::plural('Comments', $article->comment_count) }}"><i class="icon-comments"></i> {{ $article->comment_count }}</a>		
		</div>
		<div class="right">
		<span class="date"><a href="#"><i class="icon-calendar"></i> {{ HTML::entities(date("F j, Y g:ia", strtotime($article->created_at))) }}</a></span>
		</div>
	</div>
	</div>
</div>
@endforeach

</div>
@include("news.sidebar")
</div>
@endsection
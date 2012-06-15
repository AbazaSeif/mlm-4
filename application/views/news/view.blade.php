@layout("layout.main")

@section("content")
<div id="content" class="news">
@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
	@endif
<article class="post single">
	<h2 class="title">{{ e($article->title) }}</h2>
		<p class="meta">
		<span class="date">{{ HTML::entities(date("F j, Y g:ia", strtotime($article->created_at))) }}</span><span class="posted">By <a href="#">{{ $article->user->username }}</a></span>
		</p>
		<div>{{ HTML::image($article->image->file_original, "image") }}</div>
<div class="entry">
		{{ $article->content }}
</div>
</article>
</div>
@endsection
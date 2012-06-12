@layout("layout.main")

@section("content")
<div id="content" class="news">
	@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
	@endif
<div>{{ HTML::image($article->image->file_large, "image") }}</div>
	<h2>{{ e($article->title) }}</h2>
	<p>Written by {{ $article->user->username }}</p>
	<p>{{ nl2br(e($article->summary)) }}</p>
	{{ $article->content }}
</div>
@endsection
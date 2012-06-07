@layout("layout.main")

@section("content")
<div class="content">
	<h2>{{ e($article->title) }}</h2>
	<p>Written by {{ $article->user->username }}</p>
	<p>{{ nl2br(e($article->summary)) }}</p>
	<div>{{ HTML::image($article->image->file_large, "image") }}</div>
	{{ $article->content }}
</div>
@endsection
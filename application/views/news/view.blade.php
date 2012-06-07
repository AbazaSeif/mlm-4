@layout("layout.main")

@section("content")
<div class="content">
	@if(!$article->published)
		<div class="alert">
			<h4 class="alert-heading">Not yet published!</h4>
			<p>While you as an admin can view this, other users can't</p>
		</div>
	@endif
	<h2>{{ e($article->title) }}</h2>
	<p>Written by {{ $article->user->username }}</p>
	<p>{{ nl2br(e($article->summary)) }}</p>
	<div>{{ HTML::image($article->image->file_large, "image") }}</div>
	{{ $article->content }}
</div>
@endsection
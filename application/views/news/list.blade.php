@layout("layout.main")

@section('content')

<div class="content">
	@foreach($newslist->results as $article)
		<h3>{{ HTML::link_to_action("news@view", $article->title, array($article->id, $article->slug)) }}</h3>
		{{ HTML::image($article->image->file_small, "Image") }}
		{{ $article->summary }}
	@endforeach
	{{ $newslist->links() }}
</div>
@endsection
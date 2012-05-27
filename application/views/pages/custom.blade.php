@layout('layout.main')


@section('content')
	<div class="content">
		<span>{{ $custom_page->title }}</span>
		<div>{{ $custom_page->data }}</div>
	</div>
@endsection
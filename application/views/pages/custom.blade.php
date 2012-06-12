@layout('layout.main')


@section('content')
	<div id="content">
		<span>{{ $custom_page->title }}</span>
		<div>{{ $custom_page->data }}</div>
	</div>
@endsection
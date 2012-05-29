@layout('layout.admin')

@section('content')
@parent
<div class="content">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>URL Slug</th>
				<th>Link</th>
			</tr>
		</thead>
		@foreach ($pages as $page)
			<tr>
				<td>{{ $page->id }}</td>
				<td>{{ $page->title }}</td>
				<td>{{ $page->url_slug }}</td>
				<td><a href="{{ URL::to($page->url_slug) }}">View</a></td>
			</tr>
		@endforeach
	</table>
</div>
@endsection
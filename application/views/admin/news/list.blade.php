@layout("layout.admin")

@section("content")
@parent
<div class="content">
	{{ HTML::link_to_action("admin.news@new", "+ New") }}
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>News article</th>
				<th>Actions</th>
			</tr>
		</thead>
		@foreach ($news as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("news@view", $item->title, array($item->id, $item->slug)) }}</td>
				<td>{{ HTML::link_to_action('admin.news@edit', "Edit", array($item->id)) }}</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection
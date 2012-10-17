@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Pages</h2>
	</div>
	<a href="{{ URL::to_action("admin.pages@new") }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> New Page</a>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>URL Slug</th>
				<th>Link</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($pages as $page)
			<tr>
				<td>{{ $page->id }}</td>
				<td>{{ $page->title }}</td>
				<td>{{ $page->url_slug }}</td>
				<td><a href="{{ URL::to($page->url_slug) }}">View</a></td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.pages@edit", array($page->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.pages@delete", array($page->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
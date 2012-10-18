@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>News Articles</h2>
	</div>
	<a href="{{ URL::to_action("admin.news@new") }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> New Article</a>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>News article</th>
				<th>Date created</th>
				<th>Posted by</th>
				<th><abbr title="Published">P</abbr></th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($news as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("news@view", $item->title, array($item->id, $item->slug), array("target" => "_blank")) }}</td>
				<td>{{ date("F j, Y g:ia", strtotime($item->created_at)) }}</td>
				<td>USERNAME</td>
				<td>
					@if($item->published)
						<i class="icon-eye-open" title="Published"></i>
					@else
						<i class="icon-eye-close" title="Not Published"></i>
					@endif
				</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown">Actions</a>
					<a class="btn btn-primary dropdown-toggle btn-small" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.news@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						@if($item->published)
						<li><a href="{{ URL::to_action("admin.news@unpublish", array($item->id)) }}" title="will remove from news page and will keep article saved"><i class="icon-eye-close"></i> Unpublish</a></li>
						@else
						<li><a href="{{ URL::to_action("admin.news@publish", array($item->id)) }}" title="will publish this article to the News page"><i class="icon-eye-open"></i> Publish</a></li>
						@endif
						<li><a href="{{ URL::to_action("admin.news@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
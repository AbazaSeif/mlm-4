@layout("layout.admin")

@section("content")
@parent
<div id="content">
	<div class="titlebar clearfix">
		<h2>News Articles</h2>
	</div>
	<a href="{{ URL::to_action("admin.news@new") }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> New Article</a>
	<table id="sortable" class="table table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>News article</th>
				<th>Date created</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		@foreach ($news as $item)
		<tbody>
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("news@view", $item->title, array($item->id, $item->slug), array("target" => "_blank")) }}</td>
				<td>{{ date("F j, Y g:ia", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary" href="#" data-toggle="dropdown" >
					@if ($item->published == 1)
					<i class="icon-ok-sign icon-white" title="This article is published"></i>
					@elseif ($item->published == 0)
					<i class="icon-exclamation-sign icon-white" title="This article is not published"></i>
					@else
					@endif Actions</a>
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.news@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						@if ($item->published == 1)
						<li><a href="{{ URL::to_action("admin.news@unpublish", array($item->id)) }}" title="will remove from news page and will keep article saved"><i class="icon-warning-sign"></i> Unpublish</a></li>
						@elseif ($item->published == 0)
						<li><a href="{{ URL::to_action("admin.news@publish", array($item->id)) }}" title="will publish this article to the News page"><i class="icon-globe"></i> Publish</a></li>
						@else
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
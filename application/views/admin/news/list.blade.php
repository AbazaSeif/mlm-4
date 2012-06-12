@layout("layout.admin")

@section("content")
@parent
<div id="content">
	<a href="{{ URL::to_action("admin.news@new") }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> New Article</a>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>News article</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		@foreach ($news as $item)
		<tbody>
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("news@view", $item->title, array($item->id, $item->slug)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary" href="#" data-toggle="dropdown"><i class="icon-user icon-white"></i> Actions</a>
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.news@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						<li><a href="{{ URL::to_action("admin.news@unpublish", array($item->id)) }}"><i class="icon-exclamation-sign"></i> Unpublish</a></li>
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
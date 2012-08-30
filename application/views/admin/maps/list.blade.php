@layout("layout.admin")

@section("content")
@parent
<div id="content">
	<div class="titlebar clearfix">
		<h2>Maps</h2>
	</div>
	<table id="sortable" class="table table-condensed">
		<thead>
			<tr>
				<th>ID</th>
				<th>Map name</th>
				<th>Date created</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		@foreach ($maps as $item)
		<tbody>
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("maps@view", $item->title, array($item->id, $item->slug), array("target" => "_blank")) }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
				<div class="btn-group">
					<a class="btn btn-primary" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("admin.maps@edit", array($item->id)) }}"><i class="icon-pencil"></i> Edit</a></li>
						@if ($item->featured == 1)
						<li><a href="{{ URL::to_action("admin.maps@unfeature", array($item->id)) }}" title="will make this map unfeatured"><i class="icon-remove"></i> UnFeature</a></li>
						@elseif ($item->featured == 0)
						<li><a href="{{ URL::to_action("admin.maps@feature", array($item->id)) }}" title="will make this map featured"><i class="icon-heart"></i> Feature</a></li>
						@else
						@endif
						@if ($item->official == 1)
						<li><a href="{{ URL::to_action("admin.maps@unofficial", array($item->id)) }}" title="will make this map unofficial"><i class="icon-exclamation-sign"></i> UnOfficial</a></li>
						@elseif ($item->official == 0)
						<li><a href="{{ URL::to_action("admin.maps@official", array($item->id)) }}" title="will make this map official"><i class="icon-star"></i> Official</a></li>
						@else
						@endif
						<li><a href="{{ URL::to_action("admin.maps@delete", array($item->id)) }}"><i class="icon-trash"></i> Delete</a></li>
						</ul>
				</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection
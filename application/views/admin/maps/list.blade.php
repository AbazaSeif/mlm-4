@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
	<div class="titlebar">
		<h2>Maps</h2>
	</div>
	<a href="{{ URL::to_action("maps@new") }}" class="btn" style="margin-bottom:15px"><i class="icon-plus"></i> New Map</a>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Map name</th>
				<th>Date created</th>
				<th><abbr title="Status">S</abbr></th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($maps as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ HTML::link_to_action("maps@view", $item->title, array($item->id, $item->slug), array("target" => "_blank")) }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
					@if($item->published)
						<i class="icon-eye-open" title="Approved"></i>
					@else
						<i class="icon-eye-close" title="Not Approved"></i>
					@endif
				</td>
				<td>
				{{ HTML::link_to_action("admin@maps@view", "Moderate Map", array($item->id), array("class" => "btn btn-primary btn-small"))}}
				</td>
		@endforeach
			</tr>
		</tbody>
	</table>
</div>
@endsection
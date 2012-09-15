@layout('layout.admin')

@section('content')
@parent
<div id="content" class="clearfix">
	<div id="page">
		<div class="titlebar clearfix">
			<h2>Moderation queue</h2>
		</div>
		<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Type of moderation</th>
				<th>Item type</th>
				<th>Item creator</id>
				<th>Date created</th>
				<th>View</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($modqueue->results as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ $item->type }}</td>
				<td>{{ $item->itemtype }}</td>
				<td>{{ $item->user->username }}</td>
				<td>{{ date("F j, Y g:ia", strtotime($item->created_at)) }}</td>
				<td>{{ HTML::link_to_action("admin.modqueue@view", "View", array($item->id)) }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<div id="sidebar">
		<div class="titlebar clearfix">
			<h2>Admin log</h2>
		</div>
		<ol>
			@foreach($log->results as $logitem)
				<li>
					{{$logitem->user->username}} {{$logitem->action}} {{$logitem->module}} item ID#{{$logitem->target}}
					@if($logitem->text)
					<br />{{$logitem->text}}
					@endif
				</li>
			@endforeach
		</ol>
		{{ $log->links() }}
	</div>
</div>
@endsection
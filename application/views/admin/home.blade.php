@layout('layout.admin')

@section('content')
@parent
<div id="content" class="clearfix">
	<div id="page">
		<div class="titlebar clearfix">
			<h2>Moderation queue</h2>
		</div>
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
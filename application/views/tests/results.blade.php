@layout("layout.main")

@section("content")
	<div id="content" class="clearfix">
		Test results id: #{{$uniq}}. Make sure this number appears both above and next page:<br />
		{{ HTML::link("/", "Back home") }}
	</div>
@endsection
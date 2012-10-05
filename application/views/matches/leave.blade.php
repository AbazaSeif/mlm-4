@layout("layout.main")

@section("content")
@include("matches.menu")
<div id="content">
<div class="titlebar">
	<h2>Leaving Match <strong>{{ e($match->id) }}</strong></h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
	{{ Form::token() }}
	<p>Are you sure you would like to leave the match?</p>
	{{ Form::submit("Leave Match", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("match.view", "Back", array("id" => $match->id), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
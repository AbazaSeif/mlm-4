@layout("layout.admin")

@section("content")
@parent
<div id="content">
<div class="titlebar clearfix">
	<h2>Delete article</h2>
</div>
	{{ Form::open(null, 'POST', array('class' => 'globalid')) }}
	{{ Form::token() }}
	<p>Are you sure you want to delete <strong>{{ e($newsitem->title) }}</strong>?</p>
	{{ Form::submit("Delete", array("class" => "btn btn-danger")) }}
	{{ HTML::link_to_action("admin.news", "Back", array(), array("class" => "btn")) }}
	{{ Form::close() }}
</div>
@endsection
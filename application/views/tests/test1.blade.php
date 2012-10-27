@layout("layout.main")

@section("content")
<div id="content" class="clearfix">
<div class="titlebar">
	<h2>Test nr. 1</h2>
</div>
<div id="page" class="bigger">
	{{ Form::open("test/test1", "POST", array("class" => "form")) }}
		{{ Form::actions(array(Form::submit("Run Test 1", array("class" => "btn-primary")))) }}
		{{ Form::token()}}
		{{ Form::field("text", "text1", "Testing text field", array("Test value 1", array('class' => 'title', 'autocomplete' => 'off'))) }}
		{{ Form::field("textarea", "text2", "Testing textarea field", array("Test value 2")) }}
		{{ Form::field("select", "text3", "Testing select field", array(array(1234 => "Test value 3"), 1234)) }}
	{{ Form::close() }}
</div>
</div>
@endsection
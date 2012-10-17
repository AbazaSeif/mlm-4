@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>New article</h2>
</div>
<div id="page" class="maxwidth">
	{{ Form::open(null, 'POST', array('class' => 'form')) }}
		{{ Form::token()}}
		{{ Form::field("text", "title", "", array(Input::old("title"), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		<div class="titlebar"><h4>Article main image <small>(Use default if no image is found)</small></h4></div>
		{{ Form::field("imageselect", "image", "", array(Input::old("image"), $oldimage), array("error" => $errors->first("image"))) }}
		<div class="titlebar"><h4>Article content</h4></div>
		{{ Form::field("wysiwyg", "news_content", "", array(Input::old("news_content"), array('class' => 'input-xxlarge')), array('error' => $errors->first('news_content'))) }}
		<div class="titlebar"><h4>Summary of the Article <small>(250 characters max)</small></h4></div>
		{{ Form::field("textarea", "summary", "", array(Input::old("summary"), array("rows" => "15", 'class' => 'summary')), array('error' => $errors->first('summary'))) }}
		<div class="titlebar"><h4>Would you like to publish this article right away?</h4></div>
		{{ Form::field("checkbox", "published", "", array(1, Input::old("published")), array("error" => $errors->first("published"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary"))," ",HTML::link_to_action("admin@news", "Cancel",array(), array("class" => "btn") ))) }}
	{{ Form::close() }}
</div>
</div>
@endsection
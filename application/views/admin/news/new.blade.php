@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar"><h2>New article</h2></div>
<div id="page" class="maxwidth">
{{ Form::open(null, 'POST', array('class' => 'form')) }}
	{{ Form::token()}}
	{{ Form::field("text", "title", "", array(Input::old("title"), array('class' => 'title', 'autocomplete' => 'off', 'placeholder' => 'Article Title')), array('error' => $errors->first('title'))) }}
	{{ Form::field("imageselect", "image", "Article main image", array(Input::old("image"), $oldimage), array("alt" => "(Use default if no image is found)", "error" => $errors->first("image"))) }}
	{{ Form::field("wysiwyg", "news_content", "Article content", array(Input::old("news_content"), array('class' => 'input-xxlarge')), array('error' => $errors->first('news_content'))) }}
	{{ Form::field("textarea", "summary", "Summary of the Article", array(Input::old("summary"), array("rows" => "15", 'class' => 'summary')), array('alt' => '(250 characters max)', 'error' => $errors->first('summary'))) }}
	{{ Form::field("checkbox", "published", "Would you like to publish this article right away?", array(1, Input::old("published")), array("error" => $errors->first("published"))) }}
	{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary"))," ",HTML::link_to_action("admin@news", "Cancel",array(), array("class" => "btn") ))) }}
{{ Form::close() }}
</div>
</div>
@endsection
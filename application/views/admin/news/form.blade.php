@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content" class="edit clearfix">
<div class="titlebar">
	<h2>Editing article <b>{{$newsitem->title}}</b></h2>
</div>
<div id="page" class="maxwidth">
	{{ Form::open(null, 'POST', array('class' => 'form')) }}
		{{ Form::token()}}
		{{ Form::field("text", "title", "", array(Input::old("title", $newsitem->title), array('class' => 'title', 'autocomplete' => 'off')), array('error' => $errors->first('title'))) }}
		{{ Form::field("imageselect", "image", "Article main image", array(Input::old("image", $newsitem->image_id), $previewimage), array("error" => $errors->first("image"))) }}
		{{ Form::field("wysiwyg", "news_content", "Article content", array(Input::old("news_content", $newsitem->content), array('class' => 'input-xxlarge')), array('error' => $errors->first('news_content'))) }}
		{{ Form::field("textarea", "summary", "Summary of the Article", array(Input::old("summary", $newsitem->summary), array("rows" => "15", 'class' => 'summary')), array('alt' => '(250 characters max)', 'error' => $errors->first('summary'))) }}
		{{ Form::field("checkbox", "published", "Is this article published?", array(1, Input::old("published", $newsitem->published)), array("error" => $errors->first("published"))) }}
		{{ Form::actions(array(Form::submit("Save", array("class" => "btn-primary"))," ",HTML::link_to_action("admin@news", "Cancel",array(), array("class" => "btn") ))) }}
	{{ Form::close() }}
</div>
</div>
@endsection
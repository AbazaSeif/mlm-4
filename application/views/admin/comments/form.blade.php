@layout("layout.main")

@section("content")
@include("admin.menu")
<div id="content">
<div class="titlebar">
	<h2>Editing Comment <b>{{ $comment->id }}</b> by <b>{{ $comment->user->username }}</b></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'form-horizontal')) }}
	{{ Form::token() }}
	<formset>
		{{ Form::field("textarea", "source", "Comment", array(Input::old("source", $comment->source), array('class' => 'input-large')), array('error' => $errors->first('source'))) }}
		{{ Form::actions(array( Form::submit("Save", array("class" => "btn btn-primary")) )) }}
	</formset>
{{ Form::close() }}
@if($modqueue == true)
<div class="titlebar">
<h2>Modqueue Item <strong>{{ e($modqueue->id) }}</strong></h2>
</div>
{{ Form::open(null, 'POST', array('class' => 'xpadding')) }}
{{ Form::token() }}
{{ Form::field("hidden", "modqueueid", "", array($modqueue->id)) }}
<p>Modqueue item found for: <strong>{{ e($comment->title) }}</strong></p>
<p>ID: {{ $modqueue->id }}</p>
<p>Type: {{ $modqueue->type }}</p>
<p>ItemID: {{ $modqueue->itemid }}</p>
<p>ItemType: {{ $modqueue->itemtype }}</p>
<p>User: {{ $modqueue->user->username }}</p>
<p>Date Created: {{ date("F j, Y g:ia", strtotime($modqueue->created_at)) }}</p>
<p>Additional Data: {{ $modqueue->data }}</p>
<div class="titlebar"><h4>Admin Notes <small>(Notes about this item such as why not published (No image, incorrect grammer etc.))</small></h4></div>
{{ Form::field("textarea", "admin_notes", "", array(Input::old("admin_notes", $modqueue->admin_notes), array("rows" => "5", 'class' => 'admin_notes')), array('error' => $errors->first('admin_notes'))) }}
{{ Form::submit("Delete from Modqueue", array("class" => "btn btn-danger", "name" => "action", "value" => "deletemodqueue")) }}
{{ Form::submit("Save Admin Notes", array("class" => "btn btn-warning", "name" => "action", "value" => "savemodqueuenotes")) }}
{{ Form::close() }}
@endif
</div>
@endsection
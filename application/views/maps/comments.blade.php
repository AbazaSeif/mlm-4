<div id="comments">
	@if( $map->comment_count == 0)
	<div class="titlebar"><h2>No Comments/Feedback</h2></div>
	@elseif ( $map->comment_count == 1)
	<div class="titlebar"><h2><b>1</b> Comment/Feedback</h2></div>
	@else
	<div class="titlebar"><h2><b>{{ $map->comment_count }}</b> Comments/Feedback</h2></div>
	<div class="showcomments" style="display:none;"></div>
	@endif

<ol class="commentlist">
	@foreach($map->comments as $comment)
		@if($comment->reply_id == null)
		@include("maps.comment")
		@foreach($map->comments as $replycomment)
			@if($replycomment->reply_id == $comment->id)
				@include("maps.commentreply")
			@endif
		@endforeach
		@endif
	@endforeach
</ol>
<div id="respond">
	@if(Auth::check())
		<h3>Post a new comment</h3>
		<div id="comment">
			<p class="help">Live preview</p>
			<div class="vcard"> 
			<img class="avatar" src="{{Auth::user()->avatar_url}}" alt="{{Auth::user()->username}}'s skin">
			<a class="username" href="/user/{{Auth::user()->username}}" title="{{Auth::user()->username}}'s Profile">{{Auth::user()->username}}</a> Says:
		</div>
		<div class="body">
			<div id="preview"></div>
		</div>
		</div>
		{{ Form::open("maps/comment/".$map->id) }}
		{{ Form::token() }}
		{{ Form::field("textarea", "comment", "", array(Input::old("comment"), array("id" => "mrk", "class" => "input-xxlarge")), array('error' => $errors->first('comment'))) }}
		{{ Form::submit("Post", array("class" => "btn-primary")) }}
		{{ HTML::link('#', 'Preview', array("class" => "btn", "id" => "prevb")); }}
		{{ Form::close() }}
	@else
	<h4>You must be <a href="/login">logged in</a> to leave a comment.</h4>
	@endif
</div>
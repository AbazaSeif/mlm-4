{{ Messages::get_html() }}
<div class="row-fluid">
	<div class="span2">
		@include("images.menu")
	</div>
	<div class="span10">
		<ul class="image-list thumbnails">
		@forelse ($images->results as $image)
			<li class="span2"><a href="#" class="thumbnail" data-image="{{ e(json_encode($image->to_array())) }}" onClick="{{e("MLM.images.select($(this).data(\"image\"))")}}; return false;">{{ HTML::image($image->file_small) }}</a>
				{{-- HTML::link($image->file_small, "Small") --}}
				{{-- HTML::link($image->file_medium, "Medium") --}}
				{{-- HTML::link($image->file_large, "Large") --}}
				{{-- HTML::link($image->file_original, "Original") --}}
			</li>
		@empty
			<li>None found :'(</li>
		@endforelse
		</ul>
	</div>
</div>

{{ $images->links() }}

@if($uploads && Auth::user()->admin)
	@if (isset($errors))
		@foreach ($errors->all('<p>:message</p>') as $error)
			{{ $error }}
		@endforeach
	@endif
	{{ Form::open_for_files("imgmgr/upload", "POST", array("id" => "imageupload", "class" => FORM::TYPE_INLINE )) }}
	<div id="fileupload-form">
		{{ Form::label("upload-file", "Image") }}
		{{ Form::file("uploaded", array("id" => "upload-file")) }}
		{{ Form::label("upload-filename", "Title") }}
		{{ Form::text("title", null, array("id" => "upload-filename")) }}
		{{ Form::submit("Upload", array('class' => 'btn btn-primary')) }}
		<div class="error"></div>
	</div>
	<div id="uploading-bar" class="progress" style="display: none;">
		<div class="bar"></div>
	</div>
	{{ Form::close() }}
	<div class="uploads"><ul id="uploaded-img" class="thumbnails"></ul></div>
@endif
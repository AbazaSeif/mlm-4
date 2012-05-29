{{-- Meant to be as a popup, so style accordingly --}}
{{ Messages::get_html() }}

<ul class="unstyled">
	@foreach ($images->results as $image)
		<li>
			{{ HTML::image($image->file_small) }}
			{{ e($image->filename) }}
			{{ HTML::link($image->file_small, "S") }}
			{{ HTML::link($image->file_medium, "M") }}
			{{ HTML::link($image->file_large, "L") }}
			{{ HTML::link($image->file_original, "O") }}
		</li>
	@endforeach
</ul>
{{ $images->links() }}

@if(Auth::user()->admin)
	@if (isset($errors))
		@foreach ($errors->all('<p>:message</p>') as $error)
			{{ $error }}
		@endforeach
	@endif
	{{ Form::open_for_files("imgmgr/upload") }}
	{{ Form::label("uploaded", "Image") }}
	{{ Form::file("uploaded") }}
	{{ Form::label("title", "Title") }}
	{{ Form::text("title") }}
	{{ Form::submit("Upload", array('class' => 'btn-primary')) }}
	{{ Form::close() }}
@endif
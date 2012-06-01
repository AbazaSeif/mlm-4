<html>
<head>
<title>Image Uploader & Gallery</title>
<link rel="stylesheet" type="text/css" href="{{ URL::to_asset("css/style.css") }}" />
</head>
<body id="imgallery">
{{ Messages::get_html() }}
<table>
	<thead>
		<tr>
			<th>Image</th>
			<th>Filename</th>
			<th>Sizes</th>
		</tr>
	</thead>
		@foreach ($images->results as $image)
			<tr>
			<td>{{ HTML::image($image->file_small) }}</td>
			<td>{{ e($image->filename) }}</td>
			<td>
<ul class="nav nav-pills">
<li class="dropdown">
    <a class="imgsizes btn btn-primary" data-toggle="dropdown" data-target="#" href="#">
      Sizes
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li>{{ HTML::link($image->file_small, "Small") }}</li>
	  <li>{{ HTML::link($image->file_medium, "Medium") }}</li>
	  <li>{{ HTML::link($image->file_large, "Large") }}</li>
	  <li>{{ HTML::link($image->file_original, "Original") }}</li>
    </ul>
</li>
</ul>
			</td>
			</tr>
		@endforeach
	</table>
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
	{{ Form::submit("Upload", array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
@endif

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="{{ URL::to_asset("js/plugins.js") }}"></script>
<script src="{{ URL::to_asset("js/script.js") }}"></script>
</body>
</html>
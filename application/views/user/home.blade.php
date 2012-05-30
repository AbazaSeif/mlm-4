@layout('layout.user')

@section('content')
@parent
<div class="content" id="profile">
	<div id="heading">
		<div class="well">
			<a href="http://minecraft.net/profile" class="thumbnail" target="_blank" title="Change your skin...">
            <img src="http://minotar.net/helm/random/60.png" alt="" />
			</a>
		<h2>The Username</h2>
		<p>Description, Tagline?</p>
		</div>
	</div>
<div class="container">
  <div class="row">
    <div class="span4">
      <h3>Sidebar</h3>
    </div>
    <div class="span8">
      <h3>Content</h3>
    </div>
  </div>
</div>

</div>
@endsection
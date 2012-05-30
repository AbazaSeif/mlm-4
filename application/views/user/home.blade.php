@layout('layout.user')

@section('content')
@parent
<div class="content" id="profile">
	<div id="heading">
		<div class="well">
			<a href="#" class="thumbnail" title="Change your skin">
            <img src="http://minotar.net/helm/{{ Auth::user()->username }}/60.png" alt="" />
			</a>
		<h2>{{ Auth::user()->username }}</h2>
		<p>Team butCuba / He designed this site, biatch</p>
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
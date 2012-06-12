@layout('layout.user')

@section('content')
@parent
<div id="content" class="profile">
	<div id="heading">
		<div class="well">
			<a href="http://minecraft.net/profile" class="thumbnail" target="_blank" title="Change your skin...">
            	<img src="http://minotar.net/helm/{{$user->mc_username}}/60.png" alt="" />
			</a>
			<h2>{{$user->username}}</h2>
			<p>Minecrafter</p>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="span4">
				<h3>Information</h3>
				<ul>
				<li><h2>Team</h2></li>
				<li><h2>Rank</h2></li>
				<li><h2>Posts</h2></li>
				<li><h2>Comments</h2></li>
				</ul>
			</div>
			<div class="span8">
				<h3>Recent updates</h3>
			</div>
		</div>
	</div>
</div>
@endsection
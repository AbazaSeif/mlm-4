@layout("layout.main")

@section('content')
@include("matches.menu")
<div id="content">
<h2>Matches currently running</h2>
<hr>
List here with matches that are currently going on, with options to spectate/livestream etc.??
<h2>Matches starting soon</h2>
<hr>
List here of all matches that will be starting soon
<h2>Matches recently ended</h2>
<hr>
List of matches that ended recently
<h2>Matches in planning</h2>
<hr>
List of matches which are currently in planning
</div>
@endsection
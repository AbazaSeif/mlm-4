@layout("layout.main")

@section("content")
<div id="content">
	<div class="titlebar">
		<h2>Team Applications</h2>
	</div>
	{{ Form::open(null, "POST") }}
	{{ Form::token() }}
	<div class="titlebar"><h4>Application description &nbsp<small>What the applicant should put i.e. Age, Location etc.</small></h4></div>
	{{ Form::field("textarea", "text", "", array(Input::old("text", $team->applications_text), array("rows" => "5", "class" => "input-xxlarge")), array('error' => $errors->first('text'))) }}
	{{ Form::submit("Save application description", array("name" => "action", "value" => "save", "class" => "btn btn-primary")) }}
	@if(!$team->applications_open) 
	{{ Form::submit("Open application submission", array("name" => "action", "value" => "application_submission", "class" => "btn btn-success")) }}
	@else
	{{ Form::submit("Close application submission", array("name" => "action", "value" => "application_submission", "class" => "btn btn-danger")) }}
	@endif
	{{ HTML::link_to_action("teams.view", "Back", array("id" => $team->id), array("class" => "btn")) }}
	{{ Form::close() }}
	<div class="titlebar">
		<h2>Submitted Applications</h2>
	</div>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Text</th>
				<th>Date submitted</th>
				<th>Notes</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($applications as $item)
			{{ Form::open("teams/save_application_notes/".$team->id."/".$item->id, "POST") }}
			{{ Form::token() }}
			<tr>
				<td>{{ $item->id }}</td>
				<td><a href="{{ URL::to_action("users", array($item->user->username)) }}">{{ $item->user->username }}</a></td>
				<td>{{ nl2br(e($item->text)) }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
					{{ Form::field("textarea", "notes", "", array(Input::old("notes", $item->notes), array("rows" => "3")), array('error' => $errors->first('notes'))) }}
				</td>
				<td>
				<div class="btn-group">
					<li><button type="submit" class="btn btn-primary btn-small"> Save Notes</li>
					<a class="btn btn-primary btn-small" href="#" data-toggle="dropdown" >Actions</a>
					<a class="btn btn-primary btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="{{ URL::to_action("teams@reject_application", array($team->id, $item->id)) }}"><i class="icon-ban-circle"></i> Reject</a></li>
						<li><a href="{{ URL::to_action("teams@accept_application", array($team->id, $item->id)) }}"><i class="icon-ok"></i> Accept</a></li>
						<li><a href="{{ URL::to_action("messages@new", array($item->user->username)) }}"><i class="icon-envelope"></i> Message User</a></li>
						</ul>
				</div>
				</td>
			</tr>
			{{ Form::close() }}
			@endforeach
		</tbody>
	</table>
	<div class="titlebar">
		<h2>Completed Applications</h2>
	</div>
	<table id="sortable" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Text</th>
				<th>Date submitted</th>
				<th>Result</th>
				<th>Notes</th>
				<th class="disabled">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($doneapplications as $item)
			{{ Form::open("teams/save_application_notes/".$team->id."/".$item->id, "POST") }}
			{{ Form::token() }}
			<tr>
				<td>{{ $item->id }}</td>
				<td><a href="{{ URL::to_action("users", array($item->user->username)) }}">{{ $item->user->username }}</a></td>
				<td>{{ $item->text }}</td>
				<td>{{ date("F j, Y h:i e", strtotime($item->created_at)) }}</td>
				<td>
					@if($item->state === 1)
						<i class="icon-ok" title="Accepted"></i>
					@elseif ($item->state === 0)
						<i class="icon-ban-circle" title="Rejected"></i>
					@endif
				</td>
				<td>
					{{ Form::field("textarea", "notes", "", array(Input::old("notes", $item->notes), array("rows" => "3")), array('error' => $errors->first('notes'))) }}
				</td>
				<td>
				<div class="btn-group">
					<li><button type="submit" class="btn btn-primary btn-small"> Save Notes</a></li>
					<a class="btn btn-primary btn-small" href="{{ URL::to_action("teams@delete_application", array($team->id, $item->id)) }}"><i class="icon-trash"></i> Delete</a>
				</div>
				</td>
			</tr>
			{{ Form::close() }}
			@endforeach
		</tbody>
	</table>
	
</div>
@endsection
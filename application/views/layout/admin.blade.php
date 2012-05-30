@layout('layout.main')

@section('content')
	<nav id="pagemenu">
		<ul class="nav nav-tabs">
			<li>{{ HTML::link('admin', 'Admin Home'); }}</li>
			<li>{{ HTML::link("admin/user", "Users") }}</li> 
			<li>{{ HTML::link("admin/pages", "Pages") }}</li>
			<li><a data-toggle="modal" href="#imguploader" >Upload images</a></li>
		</ul>
	</nav>
@endsection

<div id="imguploader" class="modal fade in hide" style="display: block; ">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">×</button>
              <h3>Upload Images...</h3>
            </div>
            <div class="modal-body">
			<iframe src="/imgmgr" align="middle" frameborder="0" height="50%" width="100%">Your browser sucks</iframe>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal">Close</a>
              <a href="#" class="btn btn-primary">Save changes</a>
            </div>
          </div>

@layout("layout.main")

@section('content')
<div id="content">
<div class="titlebar clearfix">
	<h2>FAQ</h2>
</div>
<a name="top"></a>
@foreach($faqlist->results as $faq)
	<li><h5><a href={{ "#".$faq->question }}>{{ $faq->question}}</a></h5></li>
@endforeach
<hr>
@foreach($faqlist->results as $faq)
	<br>
	<li><h5><a name={{ $faq->question}}>{{ $faq->question }}</a></h5></li>
		{{ $faq->answer }}
	<br>
@endforeach
</div>
@endsection
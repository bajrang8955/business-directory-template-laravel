@extends('frontend/layouts/master')

@section('title', $post->title)

@section('content')





<div class="container">

	<ol class="breadcrumb">
	    <li><a href="{{ URL::to('news') }}">News</a></li>
	    <li class="active">{{ $post->title }}</li>
	</ol>

	<div id="post">

		<div class="row">

			<div class="col-md-9">

				<div class="bg-white">
					<div class="pull-right" style="font-size: 12px; color: #A7A7A7;">{{ $post->created_at->format('F j, Y') }}</div>
					<h1>{{ $post->title }}</h1>
					<hr />
					<p>{!! $post->content !!}</p>

				</div>
				

			</div>

		    <div class="col-md-3 hidden-sm hidden-xs">

		        <div class="widget sticky">
		          <a href="{{URL::to('contact')}}"><img class="img-responsive" src="{{URL::to('img/banner-placeholder.png')}}" title=""/></a>

		        </div>  


		    </div>

		</div>

	</div>

</div>



@stop


@section('scripts')

{!! HTML::script('js/jquery.sticky.js') !!}

<script type="text/javascript">

$(".sticky").sticky({topSpacing:15});

</script>

@stop
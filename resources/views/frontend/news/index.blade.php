@extends('frontend/layouts/master')

@section('title', 'News')

@section('content')


<div class="container">

	<div class="" style="">

		<h1 class="page-headline">News</h1>

		<div class="row">
			<div class="col-md-9">

				<div class="bg-white posts">
					@foreach($posts as $post)
					<div class="post">
						<div class="pull-right" style="font-size: 12px; color: #A7A7A7;">{{ $post->created_at->format('F j, Y') }}</div>
						<a href="{{ URL::to('news/'.$post->id.'/'.$post->slug) }}"><h2>{{ $post->title }}</h2></a>
						<p>{{ str_limit(strip_tags($post->content), 200) }} <a href="{{ URL::to('news/'.$post->id.'/'.$post->slug) }}">[read more]</a></p>
					</div>

					@endforeach
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
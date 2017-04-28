@extends('frontend/layouts/master')

@section('title', $category->name)

@section('content')


<div class="container">

	@include('frontend/partials/searchbar')

	<div class="" style="">

		<h1 class="page-headline">{{$category->name}}</h1>


		<div class="row">
			<div class="col-md-9">

				<div class="listings">

					@if(count($listings) == 0)
						<p>This category has no listings</p>
					@endif

					@foreach($listings as $listing)

					<div class="listing">
						<div class="row">
							<div class="col-sm-3 hidden-xs">
								<a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}" title="{{ $listing->title }}">
									<img class="img-responsive logo pull-right" alt="{{ $listing->title }} Logo" title="{{ $listing->title }}" src="{{ (isset($listing) && $listing->logo != null)?URL::to('img/listing/logo/'.$listing->logo):URL::to('img/nopreview.png') }}" />
								</a>
							</div>
							<div class="col-sm-9">
								<div class="pull-right">
									@if($listing->verified == true)
									<div class="verified"><img class="verified" alt="verified" src="{{URL::to('img/verified.png')}}" title="Verified Owner"/></div>
									@endif
								</div>

								<h2><a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}">{{ $listing->title }}</a></h2>

								@if($listing->phone)
								<p class="phone"><i class="fa fa-phone fa-fw"></i> {{ substr($listing->phone, 0, -5)."*****"}}</p>
								@endif

								@if($listing->address)
								<p class="address"><i class="fa fa-map-marker fa-fw"></i> {{ $listing->address }}</p>
								@endif

								<p class="excerpt">{{ str_limit($listing->description, 190) }}</p>

								<a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}" title="{{ $listing->title }}"><button class="btn btn-sm btn-blue pull-right">View Listing <i class="fa fa-chevron-right fa-fw"></i></button></a>

							</div>
						</div>
					</div>


					@endforeach

					{!! $listings->render() !!}

				</div>

			</div>

			<div class="col-md-3 hidden-xs hidden-sm">

				<div class="widget sticky">
					<a href="http://www.ehealthbusiness.com.au" target="_blank"><img class="img-responsive" src="{{URL::to('img/bannerad.png')}}" title=""/></a>

				</div>	
				

			</div>

		</div>

	</div>

</div>

@stop

@section('scripts')

{!! HTML::script('js/jquery.sticky.js') !!}

<script>
$(".sticky").sticky({topSpacing:15});
</script>

@stop
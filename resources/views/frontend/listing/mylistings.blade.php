@extends('frontend/layouts/master')

@section('title', 'My Listings')

@section('content')


<div class="container">

	<div class="" style="">

		<h1 class="page-headline">My Listings</h1>

		<div class="row">
			<div class="col-md-9">

				<div class="listings">

					@if(count($listings) == 0)
						<p>You don't have any listings. <a href="{{ URL::to('submit-listing') }}">Click here</a> to submit a listing.</p>
					@endif

					@foreach($listings as $listing)

					<div class="listing">


						@if($listing->approved == false)
						<div class="layer-underreview" style=""><i class="fa fa-clock-o"></i> Under Review</div>
						@endif

						<div class="row">
							<div class="col-sm-3 hidden-xs">
								<a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}">
									<img class="img-responsive logo pull-right" alt="" src="{{ (isset($listing) && $listing->logo != null)?URL::to('img/listing/logo/'.$listing->logo):URL::to('img/nopreview.png') }}" />
								</a>
							</div>
							<div class="col-sm-9">
								<div class="pull-right">
									@if($listing->verified == true)
									<div class="verified"><img class="verified" src="{{URL::to('img/verified.png')}}" title="Verified Owner" /></div>
									@endif
								</div>
								<h2><a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}">{{ $listing->title }}</a></h2>

								@if($listing->phone)
								<p class="phone"><i class="fa fa-phone fa-fw"></i> {{ $listing->phone }}</p>
								@endif

								@if($listing->address)
								<p class="address"><i class="fa fa-map-marker fa-fw"></i> {{ $listing->address }}</p>
								@endif
								
								<p>{{ str_limit($listing->description, 230) }}</p>
								<div class="pull-right" style="position:relative;z-index:99;">
									<a href="{{ URL::to('listing/edit/'.$listing->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
									<a data-href="{{ URL::to('listing/delete/'.$listing->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>

								</div>

							</div>



						</div>


					</div>


					@endforeach

					{!! $listings->render() !!}

				</div>

			</div>

			<div class="col-md-3 hidden-xs hidden-sm">

				<div class="widget sticky">
					<h2>Review Information</h2>
					<p class="text-hint">Listings will be approved and verified manually by our team. Please ensure that the phone number and email of your listing is correct.</p>

				</div>	
				

			</div>

		</div>

	</div>

</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Do you really want to delete this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


@stop


@section('scripts')

{!! HTML::script('js/jquery.sticky.js') !!}

<script>

$(".sticky").sticky({topSpacing:15});

$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

</script>

@stop
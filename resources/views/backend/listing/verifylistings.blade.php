@extends('backend/layouts/master')

@section('content')


<h2>Verify Listings</h2>
<p>Listings which need to be verified. Call them and make sure that the email and phone number is right before pressing the "verify" button.</p>


<hr/>

<table class="table table-condensed table-striped table-hover table-vert-align-middle">
	<tr>
		<th>ID</th>
		<th>Listing Title</th>
		<th>Owner</th>
		<th>Listing Phone</th>
		<th>Listing Email</th>
		<th></th>
	</tr>

	@if(count($listings) == 0)
		<tr>
			<td colspan="5" style="text-align:center;">No listings to verify available.</td>
		</tr>
	@else
		@foreach ($listings as $listing)
		<tr>
			<td>{{ $listing->id }}</td>
			<td><a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}" target="_blank">{{ $listing->title }}</a></td>
			<td>{{ (!$listing->user)? "n/a":$listing->user->email }}</td>
			<td><input value="{{ $listing->phone }}" class="form-control input-sm" name="phone" autocomplete="off"/></td>
			<td><input value="{{ $listing->email }}" class="form-control input-sm" name="email" autocomplete="off"/></td>
			<td style="text-align:right;">
				<input type="hidden" name="id" value="{{ $listing->id }}" />
				<div class="btn btn-sm btn-success btn-verify" data-url="{{ URL::to('admin/ajax/listing/verify') }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Verify">Verify</div>
			</td>
		</tr>
		@endforeach
	@endif



</table>

@stop


@section('scripts')

<script>




$( ".btn-verify" ).click(function() {

	var $this = $(this);

	var url = $this.data('url');

	$this.button('loading');

	var row = $this.closest('tr');

    var data = row.find("input").serialize() + "&_token={!! csrf_token() !!}";
    

	$.ajax({
	    url: url,
	    type: 'post',
	    data: data,
	    headers: {
	        'X-XSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    dataType: 'json',
	    success: function (data) {

	    	if(data.success == true){
	    		row.fadeOut();
	    	}else{
	    		$this.button('reset');
	    		//alert("Error");
	    	}
	        
	    }
	});



});

</script>

@stop
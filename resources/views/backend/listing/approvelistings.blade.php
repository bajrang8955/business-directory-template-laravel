@extends('backend/layouts/master')

@section('content')


<h2>Approve Listings</h2>
<p>New submitted listings which need to be approved. Check the listing and press the "approve" button if it is no spam.</p>

<hr/>



<table class="table table-condensed table-striped table-hover table-vert-align-middle">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Owner</th>
		<th>Created</th>
		<th></th>
	</tr>

	@if(count($listings) == 0)
		<tr>
			<td colspan="5" style="text-align:center;">No listings to approve available.</td>
		</tr>
	@else
		@foreach ($listings as $listing)
		<tr>
			<td>{{ $listing->id }}</td>
			<td><a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}" target="_blank">{{ $listing->title }}</a></td>
			<td>{{ (!$listing->user)? "n/a":$listing->user->email }}</td>
			<td>{{ date("d/m/Y", strtotime($listing->created_at)) }}</td>
			<td style="text-align:right;">
				<input type="hidden" name="id" value="{{ $listing->id }}" />
				<div class="btn btn-sm btn-warning btn-spam" data-url="{{ URL::to('admin/ajax/listing/spam') }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Spam">Spam</div>
				<div class="btn btn-sm btn-success btn-approve" data-url="{{ URL::to('admin/ajax/listing/approve') }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Approve">Approve</div>
			</td>
		</tr>
		@endforeach
	@endif



</table>

@stop


@section('scripts')

<script>

$( ".btn-approve" ).click(function() {

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


$( ".btn-spam" ).click(function() {

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
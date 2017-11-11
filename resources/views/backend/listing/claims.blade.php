@extends('backend/layouts/master')

@section('content')


<h2>Claims</h2>
<p>Users who claimed listings. Approve these claims and call/ mail them if you are not sure.</p>


<hr/>

<table class="table table-condensed table-striped table-hover table-vert-align-middle">
	<tr>
		<th>Claimed listing</th>
		<th>by User</th>
		<th></th>
	</tr>

	@if(count($claims) == 0)
		<tr>
			<td colspan="5" style="text-align:center;">No claims to approve available.</td>
		</tr>
	@else
		@foreach ($claims as $claim)
		<tr>
			<td><a href="{{ URL::to('listing/'.$claim->listing->id.'/'.$claim->listing->slug) }}" target="_blank">{{ $claim->listing->title }}</a></td>
			<td><a href="{{ URL::to('admin/user/edit/'.$claim->user->id) }}" target="_blank">{{ $claim->user->email }}</a></td>
			<td style="text-align:right;">
				<input type="hidden" name="id" value="{{ $claim->id }}" />
				<div class="btn btn-sm btn-danger btn-delete" data-url="{{ URL::to('admin/ajax/listing/claim-delete') }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Delete Claim">Delete Claim</div>
				<div class="btn btn-sm btn-success btn-assignlisting" data-url="{{ URL::to('admin/ajax/listing/claim-assignlisting') }}" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Assign listing to user">Assign listing to user</div>
			</td>
		</tr>
		@endforeach
	@endif



</table>

@stop


@section('scripts')

<script>

$( ".btn-assignlisting" ).click(function() {

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


$( ".btn-delete" ).click(function() {

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
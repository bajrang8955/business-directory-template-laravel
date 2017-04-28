@extends('backend/layouts/master')

@section('content')


	<div class="row">
	
		<div class="col-md-3">
			<h2>Stats</h2>
			<table class="table table-condensed">
			  <tr>
			  	<td>Registered Users</td><td style="text-align:right;">{{$usercount}}</td>
			  </tr>
			  <tr>
			  	<td>Active Listings</td><td style="text-align:right;">{{$listingcount}}</td>
			  </tr>
			</table>
		</div>

	</div>

@stop


@section('scripts')


@stop
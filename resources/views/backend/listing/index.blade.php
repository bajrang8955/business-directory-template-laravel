@extends('backend/layouts/master')

@section('content')


<h2>Listings</h2>


<hr/>

<form action="{{ URL::to('admin/listings') }}" method="GET" enctype="multipart/form-data">
	<div class="pull-left input-group" style="width:400px;">
	    <input name="q" type="text" class="form-control" placeholder="Search ..." value="{{ Input::get('q') }}" autocomplete="off">
	    <div class="input-group-btn">
	        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
	    </div>
	</div>
</form>

<div class="pull-right form-group">
	<a href="{{ URL::to('admin/listing/create') }}"><div class="btn btn-default"><i class="fa fa-plus"></i> New Listing</div></a>
</div>

<table class="table table-condensed table-striped table-hover">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Owner</th>
		<th>Created</th>
		<th>Edited</th>
		<th></th>
	</tr>

	@foreach ($listings as $listing)

	<tr>
		<td>{{ $listing->id }}</td>
		<td><a href="{{ URL::to('listing/'.$listing->id.'/'.$listing->slug) }}" target="_blank">{{ $listing->title }}</a></td>
		<td>{{ (!$listing->user)? "n/a":$listing->user->email }}</td>
		<td>{{ date("d/m/Y", strtotime($listing->created_at)) }}</td>
		<td>{{ date("d/m/Y", strtotime($listing->updated_at)) }}</td>
		<td style="text-align:right;">
			<a href="{{ URL::to('admin/listing/edit/'.$listing->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
			<a data-href="{{ URL::to('admin/listing/delete/'.$listing->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
		</td>
	</tr>
	@endforeach

	


</table>

{!! $listings->render() !!}

@stop


@section('scripts')

@stop
@extends('backend/layouts/master')

@section('content')


<h2>Users</h2>

<hr/>

<form action="{{ URL::to('admin/users') }}" method="GET" enctype="multipart/form-data">
	<div class="pull-left input-group" style="width:400px;">
	    <input name="q" type="text" class="form-control" placeholder="Search ..." value="{{ Input::get('q') }}" autocomplete="off">
	    <div class="input-group-btn">
	        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
	    </div>
	</div>
</form>

<div class="pull-right form-group">
	<a href="{{ URL::to('admin/user/create') }}"><div class="btn btn-default"><i class="fa fa-plus"></i> New User</div></a>
</div>


<table class="table table-condensed table-striped table-hover">
	<tr>
		<th>ID</th>
		<th>Email</th>
		<th class="hidden-xs">Last Name</th>
		<th class="hidden-xs">First Name</th>
		<th class="hidden-xs">Listings</th>
		<th class="hidden-xs">Created</th>
		<th></th>
	</tr>

	@foreach ($users as $user)
	<tr>
		<td>{{ $user->id }}</td>		
		<td>{{ $user->email }}</td>
		<td class="hidden-xs">{{ $user->lastname }}</td>
		<td class="hidden-xs">{{ $user->firstname }}</td>
		<td class="hidden-xs">{{ $user->listings->count() }}</td>
		<td class="hidden-xs">{{ date("d/m/Y", strtotime($user->created_at)) }}</td>
		<td style="text-align:right;">
			<a href="{{ URL::to('admin/user/edit/'.$user->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
			<a data-href="{{ URL::to('admin/user/delete/'.$user->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
		</td>
	</tr>
	@endforeach

</table>

{!! $users->render() !!}

@stop


@section('scripts')


@stop
@extends('backend/layouts/master')

@section('content')


<h2>{{ ($user->id)?'Edit User':'Create User' }}</h2>

<hr/>


<form action="{{ ($user->id) ? URL::to('admin/user/edit/'.$user->id) : URL::to('admin/user/edit') }}" method="post">

{!! csrf_field() !!}

<div class="row">
	<div class="col-md-6">

		<input type="hidden" class="form-control" id="id" name="id" value="{{ $user->id }}">

		@if ($user->id)
	    <div class="pull-right form-group">
	    	<a data-href="{{ URL::to('admin/user/delete/'.$user->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
	    </div>
		@endif

	    <div class="clearfix"></div>

		@if ($user->id)
		<div class="row">
	    	<div class="col-sm-3">
	        	<label for="userid" class="control-label">ID</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="userid" value="{{ $user->id }}" disabled>
	        </div>
	    </div>
	    @endif
	    
	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="firstname" class="control-label">First Name</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $user->first_name }}">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="lastname" class="control-label">Last Name</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user->last_name }}">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="email" class="control-label">Email</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="email" class="control-label">Verified</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <select name="confirmed" class="form-control">
	            	<option value="1" {{ $user->confirmed == 1 ? 'selected' : '' }}>Yes</option>
	            	<option value="0" {{ $user->confirmed == 0 ? 'selected' : '' }}>No</option>
	            </select>	
	        </div>
	    </div>


	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="password" class="control-label">New Password</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="password" class="form-control" id="password" name="password">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="password_confirmation" class="control-label">New Password (Confirmation)</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
	        </div>

	    </div>



        <div class="pull-right">

        	<a href="{{ URL::to('admin/users') }}"><div class="btn btn-default">Cancel</div></a>
          	<button type="submit" class="btn btn-success">{!! ($user->id)?'<i class="fa fa-check"></i> Save':'Create' !!}</button>

	    </div>

	</div>



</div>


</form>







@stop


@section('scripts')


@stop
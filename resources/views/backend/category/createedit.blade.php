@extends('backend/layouts/master')

@section('content')


<h2>{{ ($category->id)?'Edit Category':'Create Category' }}</h2>

<hr/>


<form action="{{ ($category->id) ? URL::to('admin/category/edit/'.$category->id) : URL::to('admin/category/edit') }}" method="post">

{!! csrf_field() !!}

<div class="row">
	<div class="col-md-6">

		<input type="hidden" class="form-control" id="id" name="id" value="{{ $category->id }}">

		@if ($category->id)
	    <div class="pull-right form-group">
	    	<a data-href="{{ URL::to('admin/category/delete/'.$category->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
	    </div>
		@endif



	    <div class="clearfix"></div>

	    @if ($category->id)
		<div class="row">
	    	<div class="col-sm-3">
	        	<label for="userid" class="control-label">ID</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="categoryid" value="{{ $category->id }}" disabled>
	        </div>
	    </div>
	    @endif

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="name" class="control-label">Name</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="parentid" class="control-label">Parent Category</label>
	        </div>
	        <div class="col-sm-9 form-group">

				<select class="form-control" name="parentid">
					<option>none</option>

					@if(isset($categories))
						@foreach($categories as $c)
							@if(!$category->id || (($category->id) && $c->id != $category->id))
							<option value="{{$c->id}}" {{ $category->parent_id == $c->id ? 'selected' : '' }}>{{$c->name}}</option>
							@endif
						@endforeach
					@endif

				</select>

	        </div>
	    </div>

	 	<div class="row">
	    	<div class="col-sm-3">
	        	<label for="order" class="control-label">Order</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="order" name="order" value="{{ $category->order }}">
	        </div>
	    </div>   

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="icon" class="control-label">Icon FA</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <select name="icon" class="form-control">
	            	<option></option>
	            	<option value="fa-glass" {{ $category->icon == 'fa-glass' ? 'selected' : '' }}>fa-glass</option>
	            	<option value="fa-building" {{ $category->icon == 'fa-building' ? 'selected' : '' }}>fa-building</option>
	            	<option value="fa-university" {{ $category->icon == 'fa-university' ? 'selected' : '' }}>fa-university</option>
	            	<option value="fa-graduation-cap" {{ $category->icon == 'fa-graduation-cap' ? 'selected' : '' }}>fa-graduation-cap</option>
	            	<option value="fa-wheelchair" {{ $category->icon == 'fa-wheelchair' ? 'selected' : '' }}>fa-wheelchair</option>
	            	<option value="fa-home" {{ $category->icon == 'fa-home' ? 'selected' : '' }}>fa-home</option>
	            	<option value="fa-plus-square" {{ $category->icon == 'fa-plus-square' ? 'selected' : '' }}>fa-plus-square</option>
	            	<option value="fa-cab" {{ $category->icon == 'fa-cab' ? 'selected' : '' }}>fa-cab</option>
	            	<option value="fa-wrench" {{ $category->icon == 'fa-wrench' ? 'selected' : '' }}>fa-wrench</option>
	            	<option value="fa-cog" {{ $category->icon == 'fa-cog' ? 'selected' : '' }}>fa-cog</option>
	            	
	            	

	            </select>	
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="icon_color" class="control-label">Icon Color</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="icon_color" name="icon_color" value="{{ $category->icon_color }}" placeholder="e.g. #fff">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-3">
	        	<label for="icon_bgcolor" class="control-label">Icon BG Color</label>
	        </div>
	        <div class="col-sm-9 form-group">
	            <input type="text" class="form-control" id="icon_bgcolor" name="icon_bgcolor" value="{{ $category->icon_bgcolor }}" placeholder="e.g. #000">
	        </div>

	    </div>



        <div class="pull-right">

        	<a href="{{ URL::to('admin/categories') }}"><div class="btn btn-default">Cancel</div></a>
          	<button type="submit" class="btn btn-success">{!! ($category->id)?'<i class="fa fa-check"></i> Save':'Create' !!}</button>

	    </div>

	</div>



</div>


</form>







@stop


@section('scripts')


@stop
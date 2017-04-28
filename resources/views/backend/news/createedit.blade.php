@extends('backend/layouts/master')

@section('styles')


{!! HTML::style('css/summernote.css') !!}

@stop


@section('content')


<h2>{{ ($post->id)?'Edit News':'Create News' }}</h2>

<hr/>


<form action="{{ ($post->id) ? URL::to('admin/news/edit/'.$post->id) : URL::to('admin/news/edit') }}" method="post">

{!! csrf_field() !!}

<div class="row">
	<div class="col-md-10">

		<input type="hidden" class="form-control" id="id" name="id" value="{{ $post->id }}">

		@if ($post->id)
	    <div class="pull-right form-group">
	    	<a data-href="{{ URL::to('admin/post/delete/'.$post->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
	    </div>
		@endif

	    <div class="clearfix"></div>

	    
	    <div class="row">
	    	<div class="col-sm-2">
	        	<label for="title" class="control-label">Title</label>
	        </div>
	        <div class="col-sm-10 form-group">
	            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-sm-2">
	        	<label for="content" class="control-label">Content</label>
	        </div>
	        <div class="col-sm-10 form-group">
	        	<textarea id="content" name="content" class="form-control">{{ $post->content }}</textarea>
	        </div>
	        
	    </div>


        <div class="pull-right">

        	<a href="{{ URL::to('admin/news') }}"><div class="btn btn-default">Cancel</div></a>
          	<button type="submit" class="btn btn-success">{!! ($post->id)?'<i class="fa fa-check"></i> Save':'Create' !!}</button>

	    </div>

	</div>



</div>


</form>







@stop





@section('scripts')

	{!! HTML::script('js/summernote.min.js') !!}

	<script>

	$('#content').summernote({
		height: 350,
	});

	</script>

@stop
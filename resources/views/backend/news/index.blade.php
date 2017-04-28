@extends('backend/layouts/master')

@section('content')


<h2>News</h2>

<hr/>

<div class="pull-right form-group">
	<a href="{{ URL::to('admin/news/create') }}"><div class="btn btn-default"><i class="fa fa-plus"></i> New Post</div></a>
</div>

<table class="table table-condensed table-striped table-hover">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Created</th>
		<th>Edited</th>
		<th></th>
	</tr>

	@foreach ($posts as $post)

	<tr>
		<td>{{ $post->id }}</td>
		<td>{{ $post->title }}</a></td>
		<td>{{ date("d/m/Y", strtotime($post->created_at)) }}</td>
		<td>{{ date("d/m/Y", strtotime($post->updated_at)) }}</td>
		<td style="text-align:right;">
			<a href="{{ URL::to('admin/news/edit/'.$post->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
			<a data-href="{{ URL::to('admin/news/delete/'.$post->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
		</td>
	</tr>
	@endforeach

	


</table>

@stop


@section('scripts')



@stop
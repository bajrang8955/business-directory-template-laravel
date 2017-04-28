@extends('backend/layouts/master')


@section('styles')


@stop

@section('content')


<h2>Categories</h2>

<hr/>

<div class="pull-right form-group">
	<a href="{{ URL::to('admin/category/create') }}"><div class="btn btn-default"><i class="fa fa-plus"></i> New Category</div></a>
</div>

<table class="table table-condensed table-striped table-hover table-categories">
	<tr>
		<th>Name</th>
		<th>Parent</th>
		<th></th>
	</tr>

	@foreach ($main_categories as $category)
	
		<tr>
			<td><a href="{{ URL::to('admin/category/edit/'.$category->id) }}">{{ $category->name }}</a></td>
			<td>{{ ($category->parent)? $category->parent->name : '-' }}</td>
			<td style="text-align:right;">
				<a href="{{ URL::to('admin/category/edit/'.$category->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
				<a data-href="{{ URL::to('admin/category/delete/'.$category->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
			</td>
		</tr>

		@if($category->children)
			
			@foreach ($category->children as $child)

			<tr>
				<td style="padding-left:20px;"><a href="{{ URL::to('admin/category/edit/'.$child->id) }}">{{ $child->name }}</a></td>
				<td>{{ ($child->parent)? $child->parent->name : '-' }}</td>
				<td style="text-align:right;">
					<a href="{{ URL::to('admin/category/edit/'.$child->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
					<a data-href="{{ URL::to('admin/category/delete/'.$child->id) }}" data-toggle="modal" data-target="#confirm-delete"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
				</td>
			</tr>

			@endforeach
		@endif

	@endforeach




	{{--
	<tr>
		<td>{{ $category->id }}</td>
		<td>{{ $category->name }}</td>
		<td>{{ ($category->parent)? $category->parent->name : '-' }}</td>
		<td style="text-align:right;">
			<a href="{{ URL::to('admin/category/edit/'.$category->id) }}"><div class="btn btn-xs btn-default"><i class="fa fa-pencil-square-o"></i> Edit</div></a>
			<a href="{{ URL::to('admin/category/delete/'.$category->id) }}"><div class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</div></a>
		</td>
	</tr>
	@endforeach
	--}}

</table>


@stop


@section('scripts')

@stop
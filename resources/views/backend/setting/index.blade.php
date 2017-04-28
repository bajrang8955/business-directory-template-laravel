@extends('backend/layouts/master')

@section('content')


<h2>Settings</h2>

<hr/>
<p style="color:red;">Do not change any values before you know what they are for!</p>

<form action="{{ URL::to('admin/settings') }}" method="post">

	{!! csrf_field() !!}

<table class="table table-condensed table-striped table-hover">
	<tr>
		<th>ID</th>
		<th>Key</th>
		<th>Value</th>
	</tr>

	@foreach ($settings as $setting)

	<tr>
		<td>{{ $setting->id }}</td>
		<td>{{ $setting->key }}</td>
		<td><input type="text" class="form-control input-sm" name="{{ $setting->key }}" value="{{ $setting->value }}" /></td>

	</tr>
	@endforeach

	


</table>


<button type="submit" class="btn btn-success pull-right">Save</button>

</form>

@stop


@section('scripts')

@stop
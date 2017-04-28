@extends('frontend/layouts/master')

@section('title', 'Change Password')

@section('content')


<div class="container">
	<h1 class="page-headline">Change Password</h1>

	<form action="{{ URL::to('change-password') }}" method="post">

		{!! csrf_field() !!}

		<div class="bg-white" style="margin-top:20px;">

			<div class="row">
				<div class="col-md-6 form-group">

					<div class="row">
						<div class="col-sm-5 form-group">Password</div>
						<div class="col-sm-7 form-group"><input name="password" type="password" class="form-control" /></div>
					</div>

					<div class="row">
						<div class="col-sm-5 form-group">Password Confirmation</div>
						<div class="col-sm-7 form-group"><input name="password_confirmation" type="password" class="form-control" /></div>
					</div>

					<div class="pull-right">
						<input type="submit" class="btn btn-success" value="Change"/>
					</div>

					<div class="clearfix"></div>
				</div>

				<div class="col-md-6 form-group">
					<p class="text-hint">Here you can set a new password for your account. You have to type it twice to ensure it is right. Please press "Change" to apply your new password.</p>

				</div>

			</div>

		</div>

	</form>

</div>

@stop
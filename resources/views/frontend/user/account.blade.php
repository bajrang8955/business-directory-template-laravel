@extends('frontend/layouts/master')

@section('title', 'My Account')

@section('content')


<div class="container">

	<h1 class="page-headline">My Account</h1>

	<div class="bg-white" style="margin-top:20px;">

		

		<div class="row">
			<div class="col-md-6 form-group">

				<div class="row">
					<div class="col-sm-5 form-group"><strong>Email</strong></div>
					<div class="col-sm-7 form-group">{{ Auth::user()->email }}</div>
				</div>


				@if(Auth::user()->lastname || Auth::user()->firstname)

					<hr />

					@if(Auth::user()->lastname)
					<div class="row">
						<div class="col-sm-5 form-group"><strong>Last Name</strong></div>
						<div class="col-sm-7 form-group">{{ Auth::user()->lastname }}</div>
					</div>
					@endif

					@if(Auth::user()->firstname)
					<div class="row">
						<div class="col-sm-5 form-group"><strong>First Name</strong></div>
						<div class="col-sm-7 form-group">{{ Auth::user()->firstname }}</div>
					</div>
					@endif

				@endif


				<hr />

				<div class="row">
					<div class="col-sm-5 form-group"><strong>Password</strong></div>
					<div class="col-sm-7 form-group">****** <a href="{{URL::to('change-password')}}">(Change password)</a></div>
				</div>



			</div>

			<div class="col-md-6 form-group">
				<p class="text-hint">These are your account details. Your email can only be changed by an administrator. Please contact us if you need help. The password for this account can be changed by clicking "Change password".</p>

			</div>

		</div>

	</div>

</div>

@stop
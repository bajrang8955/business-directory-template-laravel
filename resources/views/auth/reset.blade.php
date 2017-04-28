@extends('frontend/layouts/master')

@section('content')

<div class="container">

<form method="POST" action="{{ URL::to('password/reset') }}">

	<div class="row" style="margin-top:20px;margin-bottom:60px;">

		<div class="col-md-4 col-md-offset-4">

			<h1 class="page-headline">New Password</h1>


		    {!! csrf_field() !!}
		    <input type="hidden" name="token" value="{{ $token }}">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

		    <div class="bg-white" style="">

			    <div class="form-group">
			        Email
			        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
			    </div>

			    <div class="form-group">
			        Password
			        <input type="password" class="form-control" name="password">
			    </div>

			    <div class="form-group">
			        Confirm Password
			        <input type="password" class="form-control" name="password_confirmation">
			    </div>

			    <div class="form-group">
			        <button type="submit" class="btn btn-blue pull-right">Save</button>
			    </div>

			    <div class="clearfix"></div>

			</div>

		</div>

	</div>



</form>

</div>

@stop
@extends('frontend/layouts/master')

@section('content')

<div class="container">

<form method="POST" action="{{ URL::to('password/reset') }}">

	<div class="row" style="margin-top:20px;margin-bottom:60px;">

		<div class="col-md-4 col-md-offset-4">

			<h1 class="page-headline">Resend Confirmation</h1>



		</div>

	</div>



</form>

</div>

@stop
@extends('frontend/layouts/master')

@section('content')

<div class="container">


<form method="POST" action="{{ URL::to('login') }}">


	<div class="row" style="margin-top:20px;margin-bottom:60px;">

		<div class="col-md-4 col-md-offset-4">

			<h1 class="page-headline">Login</h1>

		    {!! csrf_field() !!}

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
			        <input type="password" class="form-control" name="password" id="password">
			        <p style="margin-top:3px; font-size:12px;"><a href="{{ URL::to('password/email') }}">Forgot password?</a></p>

			    </div>

			    <div class="form-group">
			        <button id="btn-login" type="submit" class="btn btn-blue pull-right" data-loading-text="<i class='fa fa-spinner'></i> Login">Login</button>
			    </div>

			    <div class="clearfix"></div>

			 </div>

			 <div class="pull-right" style="margin-top:6px; font-size:12px;">
			 	<p class="text-hint">No Account? <a href="{{ URL::to('register') }}">Register here</a><p>
			 </div>

	    </div>

	</div>


</form>



</div>

@stop


@section('scripts')

<script>


  $( "#btn-login" ).click(function() {
      var $this = $(this);
      $this.button('loading');
      setTimeout(function() {
          $this.button('reset');
      }, 15000);
  });

</script>

@stop
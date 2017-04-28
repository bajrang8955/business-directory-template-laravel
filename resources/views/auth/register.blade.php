

@extends('frontend/layouts/master')

@section('content')

<div class="container">

<form method="POST" action="{{ URL::to('register') }}">

    <div class="row" style="margin-top:20px;margin-bottom:20px;">

        <div class="col-md-4 col-md-offset-4">

            <h1 class="page-headline">Register</h1>

            <div class="bg-white" style="margin-top:30px;">
            
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

                <div class="form-group">
                    Firstname
                    <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
                </div>

                <div class="form-group">
                    Lastname
                    <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                </div>

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
                    {!!captcha_img()!!}
                    <p>Type the displayed characters</p>
                    <input type="text" class="form-control" name="captcha" autocomplete="off">
                </div>


                <div class="form-group">
                    <label><input type="checkbox" name="termsconditions" value="1"> I have read and understood the <a href="{{URL::to('terms-conditions')}}" target="_blank">Terms and Conditions</a></label>
                </div>


                <div class="form-group">
                    <button type="submit" id="btn-register" class="btn btn-blue pull-right" data-loading-text="<i class='fa fa-spinner'></i> Register">Register</button>
                </div>

                <div class="clearfix"></div>


            </div>

            <div class="pull-right" style="margin-top:6px; font-size:12px;"><p class="text-hint">Already have an account? <a href="{{ URL::to('login') }}">Login here</a><p></div>

        </div>

    </div>



</form>


</div>

@stop



@section('scripts')

<script>


  $( "#btn-register" ).click(function() {
      var $this = $(this);
      $this.button('loading');
      setTimeout(function() {
          $this.button('reset');
      }, 15000);
  });

</script>

@stop

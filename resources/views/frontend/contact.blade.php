@extends('frontend/layouts/master')

@section('content')


<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			<h1 class="page-headline">Contact</h1>

			<div class="bg-white" style="">


				{!! Form::open(array('url' => 'contact', 'class' => 'form', 'method' => 'POST')) !!}

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
				    {!! Form::label('Your Name') !!}
				    {!! Form::text('name', null, 
				        array('required', 
				              'class'=>'form-control')) !!}
				</div>

				<div class="form-group">
				    {!! Form::label('Your E-mail Address') !!}
				    {!! Form::text('email', null, 
				        array('required', 
				              'class'=>'form-control')) !!}
				</div>

				<div class="form-group">
				    {!! Form::label('Your Message') !!}
				    {!! Form::textarea('message', null, 
				        array('required', 
				              'class'=>'form-control')) !!}
				</div>

                <div class="form-group">
                    {!!captcha_img()!!}
                    <p>Type the displayed characters</p>
                    <input type="text" class="form-control" name="captcha" autocomplete="off">
                </div>
                
				<div class="form-group">
				    {!! Form::submit('Contact Us!', 
				      array('class'=>'btn btn-primary')) !!}
				</div>
				{!! Form::close() !!}


			</div>
		</div>
	</div>

</div>

@stop
@extends('frontend/layouts/master')

@section('title', ($listing->id)?'Edit Listing':'Submit Listing')

@section('styles')



@stop

@section('content')


<div class="container">

<h1 class="page-headline">{{ ($listing->id)?'Edit Listing':'Submit Listing' }}</h1>

<div class="bg-white" style="">


	<form action="{{ ($listing->id) ? URL::to('listing/edit/'.$listing->id) : URL::to('listing/edit') }}" method="post" enctype="multipart/form-data">

	{!! csrf_field() !!}

	<div class="row">
		<div class="col-md-8">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

			<input type="hidden" class="form-control" id="id" name="id" value="{{ $listing->id }}">

		    <div class="clearfix"></div>


		    <div class="row">

		    	<div class="col-sm-3">
		        	<label for="title" class="control-label">Organisation Name</label>
		        </div>
		        <div class="col-sm-9 form-group">
		            <input type="text" class="form-control" id="title" name="title" value="{{ (Input::old('title')) ? Input::old('title') : $listing->title }}">
		        </div>
		    </div>

			<div class="row data-block">

		    	<div class="col-sm-3">
		        	<label for="categories" class="control-label">Categories</label>
		        </div>
		        <div class="col-sm-9 form-group">

			    <select class="form-control selectpicker" name="categories[]" multiple>
			        @foreach($main_categories as $cat)
			        <optgroup label="{{$cat->name}}">
			          @foreach($cat->children as $child)
			            @if( (isset($selected_categories) && in_array($child->id, $selected_categories)) || is_array(Input::old('categories')) && in_array($child->id, Input::old('categories')) )
			              <option value="{{$child->id}}" selected>{{$child->name}}</option>
			            @else
			              <option value="{{$child->id}}">{{$child->name}}</option>
			            @endif
			          @endforeach
			        </optgroup>
			        @endforeach
			    </select>

		        </div>


		    </div>

		    <div class="row">

		    	<div class="col-sm-3">
		        	<label for="description" class="control-label">Description</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<textarea id="description" name="description" class="form-control" rows="10" placeholder="Write a description of your organisation.">{{ (Input::old('description')) ? Input::old('description') : $listing->description }}</textarea>
		        </div>

		    </div>

		    <div class="row data-block">

		    	<div class="col-sm-3">
		        	<label for="logo" class="control-label">Logo</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="file" class="form-control" name="logo" id="logoupload" accept='image/*'>
		        	<img id="logopreview" class="img-responsive" alt="" src="{{ ($listing->logo != null)?URL::to('img/listing/logo/'.$listing->logo):'' }}" />

		        </div>

		    </div>


		    <div class="row data-block">

		    	<div class="col-sm-3">
		        	<label for="location" class="control-label">Address</label>
		        </div>
                <div class="col-md-9">

                	<div id="geocomplete-fields">



	                	<input name="lng" type="hidden" class="form-control" value="{{ (Input::old('lng')) ? Input::old('lng') : $listing->longitude }}">
	                	<input name="lat" type="hidden" class="form-control" value="{{ (Input::old('lat')) ? Input::old('lat') : $listing->latitude }}">
	                	<input name="formatted_address" type="hidden" value="{{ (Input::old('formatted_address')) ? Input::old('formatted_address') : $listing->address }}">

	                	<div class="form-group">
		                    <div class="input-group">

		                        
		                        
		                        <input name="address" type="text" class="form-control" placeholder="Search ..." id="map-search" value="{{ (Input::old('address')) ? Input::old('address') : $listing->address }}">



		                        <div class="input-group-btn">
		                            <button type="button" id="map-search-button" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
		                        </div>
		                    </div>
		                </div>

	                    <div class="form-group">
	                        <div id="googlemap" style="height:250px; width:100%;"></div>
	                    </div>

	                </div>

                </div>


		    </div>

		    <div class="row data-block">

		    	<div class="col-sm-3">
		        	<label for="description" class="control-label">Service area</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<textarea id="service_area" name="service_area" class="form-control" rows="10" placeholder="Suburbs, areas or districts of your service.">{{ (Input::old('service_area')) ? Input::old('service_area') : $listing->service_area }}</textarea>
		        </div>

		    </div>



		    <div class="row data-block">

		    	<div class="col-sm-3">
		        	<label for="phone" class="control-label">Phone</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="phone" name="phone" value="{{ (Input::old('phone')) ? Input::old('phone') : $listing->phone }}" placeholder="e.g. 012345678">
		        </div>

		    	<div class="col-sm-3">
		        	<label for="phoneafterhours" class="control-label">Phone (After Hours)</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="phone_afterhours" name="phone_afterhours" value="{{ (Input::old('phone_afterhours')) ? Input::old('phone_afterhours') : $listing->phone_afterhours }}" placeholder="e.g. 012345678">
		        </div>

		    	<div class="col-sm-3">
		        	<label for="website" class="control-label">Website</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="website" name="website" value="{{ (Input::old('website')) ? Input::old('website') : $listing->website }}" placeholder="e.g. http://www.example.com">
		        </div>

		    	<div class="col-sm-3">
		        	<label for="email" class="control-label">Email</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="email" name="email" value="{{ (Input::old('email')) ? Input::old('email') : $listing->email }}" placeholder="e.g. info@example.com">
		        </div>

		    </div>

		    <div class="row data-block">
		    	<div class="col-sm-3">
		        	<label for="twitter" class="control-label">Twitter</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="twitter" name="twitter" value="{{ (Input::old('twitter')) ? Input::old('twitter') : $listing->twitter }}" placeholder="e.g. http://www.twitter.com/example">
		        </div>

		    	<div class="col-sm-3">
		        	<label for="facebook" class="control-label">Facebook</label>
		        </div>
		        <div class="col-sm-9 form-group">
		        	<input type="text" class="form-control" id="facebook" name="facebook" value="{{ (Input::old('facebook')) ? Input::old('facebook') : $listing->facebook }}" placeholder="e.g. http://www.facebook.com/example">
		        </div>

		    </div>

		    <div class="row data-block">
		    	<div class="col-sm-3">
		        	<label for="location" class="control-label">Opening Times</label>

		        </div>
		        <div class="col-sm-9">


		        	<div class="clearfix"></div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Monday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">

				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="monday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('monday_start') && Input::old('monday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Monday"] && $openingtimes["Monday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="monday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('monday_end') && Input::old('monday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Monday"] && $openingtimes["Monday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Tuesday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">
				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="tuesday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('tuesday_start') && Input::old('tuesday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Tuesday"] && $openingtimes["Tuesday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="tuesday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('tuesday_end') && Input::old('tuesday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Tuesday"] && $openingtimes["Tuesday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Wednesday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">

				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="wednesday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('wednesday_start') && Input::old('wednesday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Wednesday"] && $openingtimes["Wednesday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="wednesday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('wednesday_end') && Input::old('wednesday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Wednesday"] && $openingtimes["Wednesday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Thursday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">
				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="thursday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('thursday_start') && Input::old('thursday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Thursday"] && $openingtimes["Thursday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="thursday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('thursday_end') && Input::old('thursday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Thursday"] && $openingtimes["Thursday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Friday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">

				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="friday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('friday_start') && Input::old('friday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Friday"] && $openingtimes["Friday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="friday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('friday_end') && Input::old('friday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Friday"] && $openingtimes["Friday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Saturday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">

				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="saturday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('saturday_start') && Input::old('saturday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Saturday"] && $openingtimes["Saturday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="saturday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('saturday_end') && Input::old('saturday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Saturday"] && $openingtimes["Saturday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		        	<div class="row form-group">
		        		<div class="col-xs-12 col-sm-2 col-md-2" style="padding-top:7px;">Sunday</div>
				    	<div class="col-xs-12 col-sm-10 col-md-10">

				    		<div class="row">

				    			<div class="col-sm-5 col-sm-offset-1">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="sunday_start" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('sunday_start') && Input::old('sunday_start') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Sunday"] && $openingtimes["Sunday"]->start == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>   

							    </div>

						        <div class="col-sm-1" style="padding-top:7px;">to</div>  

						        <div class="col-sm-5">

							        <div class="input-group">
							        	<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							    		<select name="sunday_end" class="form-control">
							    			<option value="">closed</option>
											<?php
											    $time = strtotime('00:00:00'); // start
											    for ($i = 0; $i < 48; $i++)
											    {
											    	$selected = "";
											        $time_str_mysql = date('H:i:s', $time);
											        $time_str_frontend = date('h:i A', $time);

											        if(Input::old('sunday_end') && Input::old('sunday_end') == $time_str_mysql){
											        	$selected = "selected";
											        }elseif(isset($openingtimes) && $openingtimes["Sunday"] && $openingtimes["Sunday"]->end == $time_str_mysql){
											        	$selected = "selected";
											        }

											        echo "<option value=\"$time_str_mysql\" $selected>$time_str_frontend</option>";
											        $time = strtotime('+30mins', strtotime($time_str_mysql)); // add 30 mins
											    }
											?>
							    		</select>
							        </div>    

						        </div>  

					    	</div>
				    	</div>
			    	</div>

		    	</div>

		    </div>



		    <div class="data-block">
		        <div class="pull-right">

		          	<button type="submit" class="btn btn-lg btn-success">{!! ($listing->id)?'<i class="fa fa-check"></i> Save':'Submit' !!}</button>

			    </div>
			    <div class="clearfix"></div>

		    </div>

		</div>



	</div>




	</form>

</div>

</div>

@stop


@section('scripts')


{!! HTML::script('js/jquery.geocomplete.min.js') !!}

<script>

	function initSubmitMap() {
		var options = {
		  details: "#geocomplete-fields",
		  map: "#geocomplete-fields #googlemap",
		  location: "{{ (Input::old('address')) ? Input::old('address') : $listing->address }}",
		  mapOptions: {
		    zoom: 10
		  },
		  markerOptions: {
		    draggable: true
		  },
		};

		$( "#geocomplete-fields #map-search-button" ).click(function() {
		  	$("#map-search").geocomplete("find", $("input[name=address]").val());
		});
		        
		$("#geocomplete-fields #map-search").geocomplete(options).bind("geocode:dragged", function(event, result){
			$("#geocomplete-fields input[name=lat]").val(result.lat());
			$("#geocomplete-fields input[name=lng]").val(result.lng()); 
			$("#geocomplete-fields #map-search").geocomplete("find", result.toString());
		});
	}

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#logopreview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#logoupload").change(function(){
        readURL(this);
    });



</script>

@stop
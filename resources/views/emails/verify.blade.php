@extends('emails/master')

@section('content')

<h1 style="font-size:22px;">Verify Your Email Address</h1>

<p>Thanks for creating an account with Business Directory.</p>
<p>Please follow the link below to verify your email address:<br/>
{!! link_to('register/verify/' . $confirmation_code) !!}</p>


@stop
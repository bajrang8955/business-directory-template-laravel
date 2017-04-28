@extends('emails/master')

@section('content')

<h1 style="font-size:22px;">Verify Your Email Address</h1>

<p>Click the link below to reset your password:</p>
<p>{!! link_to('password/reset/'.$token) !!}</p>

@stop
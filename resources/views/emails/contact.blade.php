@extends('emails/master')

@section('content')

<h1 style="font-size:22px;">New Contact Form Message</h1>

<p>Name: {{ $name }}</p>

<p>{{ $email }}</p>

<p>{{ $user_message }}</p>


@stop
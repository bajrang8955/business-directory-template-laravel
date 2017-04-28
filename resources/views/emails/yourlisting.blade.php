@extends('emails/master')

@section('content')

<h1 style="font-size:22px;">Manage Your Listing</h1>

<p>To update and maintain your Business Directory listing and account, please use the details below.<p>

<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td style="padding-right:10px;font-weight:bold;">Email:</td><td>{{ $email }}</td>
</tr>
<tr>
	<td style="padding-right:10px;font-weight:bold;">Password:</td><td>{{ $password }}</td>
</tr>
<tr>
	<td style="padding-top:20px;padding-right:10px;font-weight:bold;">Your Listing:</td><td style="padding-top:20px;">{!! link_to('listing/'.$listingid) !!}</td>
</tr>
</table>

<p>If you are having issues with your listing or account, please submit a request via this email <a href="mailto:{{env('DEFAULT_EMAIL')}}">{{env('DEFAULT_EMAIL')}}</a> stating your issue.</p>

<p>Regards,<br />
Management at Business Directory<p>

@stop
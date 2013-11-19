@extends('base')

@section('content')
	<h1>Log in</h1>
	@if(!empty($message))
	<p>{{ $message }}</p>
	@endif
	{{ Form::open(array('url' => URL::route('authenticate'), 'class' => 'form-signin')) }}
	<p>{{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Your username')) }}</p>
	<p>{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Your password' )) }}</p>
	<p>{{ Form::submit('Log in', array('class' => 'btn btn-primary btn-block')) }}</p>
	{{ Form::close() }}
	<p><a href="{{ URL::route('register') }}">Create account</a></p>
@stop

@extends('base')

@section('content')
	<h1>Log in</h1>
	@if(!empty($message))
	<h2>{{ $message }}</h2>
	@endif
	{{ Form::open(array('url' => URL::route('authenticate'))) }}
	<p>{{ Form::label('username', 'Your username') }}: {{ Form::text('username') }}</p>
	<p>{{ Form::label('password', 'Your password') }}: {{ Form::password('password') }}</p>
	<p>{{ Form::submit('Log in') }}
	{{ Form::close() }}
	<a href="{{ URL::route('register') }}">Create account</a>
@stop
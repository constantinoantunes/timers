@extends('base')

@section('content')
	<h1>Register</h1>
	@if (count($errors->all())>0)
	<ul>
	@foreach($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
	</ul>
	@endif
	{{ Form::model($user) }}
	<p>{{ Form::label('username', 'Your username') }}: {{ Form::text('username') }}</p>
	<p>{{ Form::label('password', 'Your password') }}: {{ Form::password('password') }}</p>
	<p>{{ Form::label('password_confirmation', 'Confirm your password') }}: {{ Form::password('password_confirmation') }}</p>
	<p>{{ Form::submit('Register') }}</p>
	{{ Form::close() }}
@stop
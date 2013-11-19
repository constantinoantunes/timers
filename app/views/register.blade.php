@extends('base')

@section('content')
	<h1>Register</h1>
	@if (count($errors->all())>0)
	<ul class="list-unstyled">
	@foreach($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
	</ul>
	@endif
	{{ Form::model($user, array('role' => 'form')) }}
	<p>{{ Form::text('username', Null, array('class' => 'form-control', 'placeholder' => 'Your username')) }}</p>
	<p>{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Your password')) }}</p>
	<p>{{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm your password')) }}</p>
	<p>{{ Form::submit('Register', array('class' => 'btn btn-primary btn-block')) }}</p>
	{{ Form::close() }}
@stop

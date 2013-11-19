@extends('base')

@section('content')
	{{ Form::model($timer) }}
	<p>{{ Form::label('name', 'Timer name') }}: {{ Form::text('name') }}</p>
	<p>{{ Form::submit('Create') }}</p>
	{{ Form::close() }}
@stop

@extends('base')

@section('content')
	{{ Form::model($timer) }}
	<p>{{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Timer name')) }}</p>
	<p>{{ Form::submit('Create', array('class' => 'btn btn-primary btn-block')) }}</p>
	{{ Form::close() }}
@stop

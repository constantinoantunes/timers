@extends('base')

@section('content')
	<h1>Welcome {{ $user->username }}!</h1>
	<div id="timers" class="list-group">
	@foreach($timers as $timer)
		<div id="{{ $timer->id }}" class="list-group-item timer {{ $timer->getStateName() }}">
			<p class="name">Name: {{ $timer->name }}</p>
			<p>Time: <span class="elapsed">{{ $timer->getTotalElapsed() }}</span></p>
			<p class="actions">
				<a class="controller" href="#">
				@if ($timer->running)
				Stop
				@else
				Start
				@endif
				</a>
			</p>
		</div>
	@endforeach
	</div>
	<h2>Total time: <span id="total-elapsed">{{ $totalTime }}</span></h2>
	<p><a href="{{ URL::route('create-timer') }}" class="btn btn-primary btn-block">Create Timer</a></p>
	<p><a href="{{ URL::route('logout') }}" class="btn btn-default btn-block">Log out</a></p>
@stop

@section('extended-scripts')
<script type="text/javascript" src="assets/app.min.js"></script>
@stop

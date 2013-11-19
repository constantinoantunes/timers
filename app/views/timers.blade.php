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

@section('app')
<script type="text/javascript">
var TimerUpdater = {
	_timersToUpdate : [],
	_interval : null,
	start : function () {
		clearInterval(TimerUpdater._interval);
		TimerUpdater._interval = setInterval(TimerUpdater._update, 1000);
		TimerUpdater._update();
	},
	_update : function () {
		// updates timers
		for(var i in TimerUpdater._timersToUpdate)
		{
			var id = TimerUpdater._timersToUpdate[i];
			var timer = $('.timer#'+id);
			TimerUpdater.setElapsed(timer, TimerUpdater.getElapsed(timer) + 1);
		}
		
		// updates total for all timers
		var total = 0;
		$('.timer').each(function () {
			total += TimerUpdater.getElapsed($(this));
		});
		$('#total-elapsed').html(total);
	},
	getElapsed : function (timer) {
		return parseInt(timer.find('.elapsed').text());
	},
	setElapsed : function (timer, value) {
		timer.find('.elapsed').html(value);
	},
	register : function (timer) {
		var position = _.indexOf(TimerUpdater._timersToUpdate, timer.attr('id'));
		if (position < 0)
		{
			TimerUpdater._timersToUpdate.push(timer.attr('id'));
		}
	},
	unregister : function (timer) {
		var position = _.indexOf(TimerUpdater._timersToUpdate, timer.attr('id'));
		if (position >= 0)
		{
			TimerUpdater._timersToUpdate = _.without(TimerUpdater._timersToUpdate, timer.attr('id'));
		}
	}
};

$(document).ready(function () {
	var toggleTimerSate = function (timer) {
		if (timer.is('.stopped')) {
			$.post("{{ URL::route('start-timer') }}", { id: timer.attr('id'), _token: '{{ Session::token() }}'}, function (result) {
				if (result) {
					timer.removeClass('stopped');
					timer.addClass('running');
					timer.find('.controller').html('Stop');
					TimerUpdater.register(timer);
				}
			});
		}
		else {
			$.post("{{ URL::route('stop-timer') }}", {id: timer.attr('id'), _token: '{{ Session::token() }}'}, function (response) {
				if (response.result) {
					timer.removeClass('running');
					timer.addClass('stopped');
					timer.find('.controller').html('Start');
					TimerUpdater.unregister(timer);
					TimerUpdater.setElapsed(timer, response.elapsed);
				}
			});
		}
	};
	var setupTimer = function (timer) {
		if (timer.is('.running')) {
			TimerUpdater.register(timer);
		}
	};
	
	$('a.controller').click(function () {
		toggleTimerSate($(this).parent().parent());
		return false;
	});
	$('.timer').each(function () {
		setupTimer($(this));
	});
	TimerUpdater.start();
});
</script>
@stop

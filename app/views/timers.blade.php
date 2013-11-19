@extends('base')

@section('content')
	<h1>Welcome {{ $user->username }}!</h1><a href="{{ URL::route('logout') }}">Log out</a>
	<ul id="timers">
	@foreach($timers as $timer)
		<li id="{{ $timer->id }}" class="timer {{ $timer->getStateName() }}">
			<span class="name">{{ $timer->name }}</span>
			<span class="elapsed">{{ $timer->getTotalElapsed() }}</span>
			<span class="actions"><a class="controller" href="#">Start/Stop</a></span>
		</li>
	@endforeach
	</ul>
	<h2>Total: <span id="total-elapsed">{{ $totalTime }}</span></h2>
	<p><a href="{{ URL::route('create-timer') }}">Create Timer</a></p>
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
					TimerUpdater.register(timer);
				}
			});
		}
		else {
			$.post("{{ URL::route('stop-timer') }}", {id: timer.attr('id'), _token: '{{ Session::token() }}'}, function (response) {
				if (response.result) {
					timer.removeClass('running');
					timer.addClass('stopped');
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
	$('ul#timers li').each(function () {
		setupTimer($(this));
	});
	TimerUpdater.start();
});
</script>
@stop

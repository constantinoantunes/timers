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
			$.post(ROUTES.startTimer, { id: timer.attr('id'), _token: SESSION_TOKEN}, function (result) {
				if (result) {
					timer.removeClass('stopped');
					timer.addClass('running');
					timer.find('.controller').html('Stop');
					TimerUpdater.register(timer);
				}
			});
		}
		else {
			$.post(ROUTES.stopTimer, {id: timer.attr('id'), _token: SESSION_TOKEN}, function (response) {
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

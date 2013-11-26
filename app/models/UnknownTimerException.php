<?php

class UnknownTimerException extends Exception {
	public function UnknownTimerException ($timerId, $userId) {
		parent::__construct("Unknown timer '$timerId' in user '$userId' account.");
	}
}

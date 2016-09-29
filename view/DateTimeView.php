<?php

class DateTimeView {


	public function show() {

    $dayOfWeek = date('l');
    $date = date('jS');
    $monthAndYear = date('F Y');
    $time = date('H:i:s');
    
    $timeString = $dayOfWeek . ", the " . $date . " of "
      . $monthAndYear . ", The time is " . $time;

		return '<p>' . $timeString . '</p>';
	}
}

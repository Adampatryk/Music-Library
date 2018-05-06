<?php 
    date_default_timezone_set('Europe/London');
    function timeSince($timeString) {
        $time = strtotime($timeString);
        $time = time() - $time;
        
        if ($time < 1) {
            return "Just Now";
        }

        $intervals = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($intervals as $interval => $text) {
            if ($time < $interval) continue;
            $numberOfInterval = floor($time / $interval);

            return $numberOfInterval.' '.$text.(($numberOfInterval>1)?'s':'');
        }

    }
?>
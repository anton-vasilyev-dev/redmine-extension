<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class TimeFormat extends AbstractHelper
{
    public function __invoke($hoursFloat, $pad = 3)
    {
        $hours = floor($hoursFloat);
        $minutesFloat = ($hoursFloat - $hours)*60;
        $minutes = floor($minutesFloat);
        $secondsFloat = ($minutesFloat - $minutes)*60;
        $seconds = floor($secondsFloat);

        return str_pad($hours, $pad, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
    }
}
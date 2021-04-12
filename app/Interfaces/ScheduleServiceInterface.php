<?php

namespace App\Interfaces;

interface ScheduleServiceInterface
{
    public function getAvailableIntervals($date, $doctorId);
}

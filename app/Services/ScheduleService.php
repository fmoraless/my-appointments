<?php

namespace App\Services;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleService implements  ScheduleServiceInterface
{
    private function getDayFromDate($date){

        $dateCarbon = new Carbon($date);
        //day of Week
        //Carbon: 0(sunday)- 6 (saturday) //WorkDay: 0(monday) - 6 (sunday)
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);

        return $day;
    }

    public function getAvailableIntervals($date, $doctorId){
        $workDay = WorkDay::where('active', true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $doctorId)
            ->first([
                'morning_start','morning_end',
                'afternoon_start','afternoon_end'
            ]);
        if (!$workDay) {
            return [];
        }
        //para construir intervalos 5:00 - 5:30 , 5:30 - 6:00
        $morningStart = new Carbon($workDay->morning_start);
        $morningEnd = new Carbon($workDay->morning_end);

        //$morningStart->addMinutes(30); //prueba para pasar 30 minutos
        $morningIntervals = $this->getIntervals(
            $workDay->morning_start, $workDay->morning_end,
            $date, $doctorId
        );

        $afternoonIntervals = $this->getIntervals(
            $workDay->afternoon_start, $workDay->afternoon_end,
            $date, $doctorId
        );

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
    }

    private function getIntervals($start, $end, $date, $doctorId) {
        $start = new Carbon($start);
        $end = new Carbon($end);

        //$morningStart->addMinutes(30); //prueba para pasar 30 minutos
        $intervals = [];
        while($start < $end) {
            $interval = [];

            $interval['start'] = $start->format('g:i A');

            //si no existe una cita para esta hora con este medico
            $exists = Appointment::where('doctor_id', $doctorId)
                ->where('scheduled_date', $date)
                ->where('scheduled_time', $start->format('H:i:s'))
                ->exists();
            //dd($exists);

            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');

            if(!$exists){
                $intervals [] = $interval;
            }
        }
        return $intervals;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\While_;

class ScheduleController extends Controller
{
    public function hours(Request $request, ScheduleServiceInterface $scheduleService)
    {
        $rules = [
          'date' => 'required|date_format:"Y-m-d"',
          'doctor_id' => 'required|exists:users,id'
        ];
        $this->validate($request, $rules);
        //dd($request->all());
        $date = $request->input('date');


        //dd($day);
        //$day = $dateCarbon->dayOfWeek;
        //dd($day);
        $date = $request->input('date');
        $doctorId = $request->input('doctor_id');
        //dd($doctorId);
        return $scheduleService->getAvailableIntervals($date, $doctorId);

    }


}

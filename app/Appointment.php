<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type'
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class);
    }

    // Appointment hasOne 1 - 1/0 belongsTo CanceledAppointment
    // $appointment->cancelation->junstification
    public function cancelation()
    {
        return $this->hasOne(CanceledAppointment::class);
    }

    //Accesor
    //$appointment->shceduled_time_12
    public function getScheduledTime12Attribute(){
        return (new Carbon($this->scheduled_time))
            ->format('g:i A');
    }

}

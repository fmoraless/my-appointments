<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanceledAppointment extends Model
{
    public function canceled_by()
    {
        return $this->belongsTo(User::class);
    }
}

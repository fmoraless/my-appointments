<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

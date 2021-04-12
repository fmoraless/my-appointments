<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function doctors(Specialty $specialty)
    {
        return $specialty->users()->get([
            'users.id',
            'users.name'
        ]);
    }
}

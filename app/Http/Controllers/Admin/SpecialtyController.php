<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $specialties = Specialty::all();
        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }
    public function store(StoreSpecialtyRequest $request)
    {
        //dd($request->all());
        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'Especialidad registrada correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }
    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        //dd($request->all());
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'Especialidad actualizada correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }
    public function destroy(Specialty $specialty)
    {
        $deleted_name = $specialty->name;
        $specialty->delete();
        $notification = 'Especialidad "'. $specialty->name .'" eliminada correctamente';
        return redirect('/specialties')->with(compact('notification'));
    }
}

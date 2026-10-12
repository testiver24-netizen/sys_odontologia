<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //aqui pasa la peticion del input con el name='buscar'
          $buscar=$request->buscar;
       
        $doctors=Doctor::with(['user','especialidad']);
       
       if ($buscar) {
    $doctors->where(function ($query) use ($buscar) {
        $query->where('nombres', 'like', "%{$buscar}%")
              ->orWhere('apellidos', 'like', "%{$buscar}%")
              ->orWhere('numero_documento', 'like', "%{$buscar}%")
              ->orWhereHas('especialidad', function ($q) use ($buscar) {
                  $q->where('nombre', 'like', "%{$buscar}%");
               });
    });
}
       $doctors=$doctors->orderBy('id','desc')->paginate(3)->withQueryString();
        return view('admin.doctores.index',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades=Especialidad::all();
       return view('admin.doctores.create',compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(DoctorRequest $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Crear el user
            $user = new User();
            $user->name = $request->nombres . ' ' . $request->apellidos;
            $user->email = $request->email;
            $user->password = Hash::make($request->numero_documento);
            $user->estado = 'activo';
            $user->save();

            $user->assignRole('DOCTOR');

            // 2. Crear el doctor
            $doctor = new Doctor();
            $doctor->user_id = $user->id;
            $doctor->nombres = $request->nombres;
            $doctor->apellidos = $request->apellidos;
            $doctor->tipo_documento = $request->tipo_documento;
            $doctor->numero_documento = $request->numero_documento;
            $doctor->fecha_nacimiento = $request->fecha_nacimiento;
            $doctor->genero = $request->genero;
            $doctor->direccion = $request->direccion;
            $doctor->telefono = $request->telefono;
            $doctor->especialidad_id = $request->especialidad_id;
            $doctor->colegiatura = $request->colegiatura;
            $doctor->descripcion = $request->descripcion;
            $doctor->observaciones = $request->observaciones;

            // 3. Fotografía (si viene)
            if ($request->hasFile('fotografia')) {
                $doctor->fotografia = $request->file('fotografia')->store('doctores', 'public');
            }

            $doctor->save();
        });

        return redirect()->route('doctores.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Creado!',
            'text' => 'Doctor registrado correctamente.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor=Doctor::findOrfail($id);
        return view('admin.doctores.show',compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $especialidades=Especialidad::all();
          $doctor=Doctor::findOrfail($id);
        return view('admin.doctores.edit',compact('doctor','especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, string $id)
{
    $doctor = Doctor::findOrFail($id);

    DB::transaction(function () use ($request, $doctor) {
        // 1. Actualizar el user
        $user = $doctor->user;
        $user->name = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->email;
        $user->save();

        // 2. Actualizar el doctor
        $doctor->nombres = $request->nombres;
        $doctor->apellidos = $request->apellidos;
        $doctor->tipo_documento = $request->tipo_documento;
        $doctor->numero_documento = $request->numero_documento;
        $doctor->fecha_nacimiento = $request->fecha_nacimiento;
        $doctor->genero = $request->genero;
        $doctor->direccion = $request->direccion;
        $doctor->telefono = $request->telefono;
        $doctor->especialidad_id = $request->especialidad_id;
        $doctor->colegiatura = $request->colegiatura;
        $doctor->descripcion = $request->descripcion;
        $doctor->observaciones = $request->observaciones;

        // 3. Fotografía: si viene una nueva, borra la anterior y guarda la nueva
        if ($request->hasFile('fotografia')) {
            if ($doctor->fotografia) {
                Storage::disk('public')->delete($doctor->fotografia);
            }
            $doctor->fotografia = $request->file('fotografia')->store('doctores', 'public');
        }

        $doctor->save();
    });

    return redirect()->route('doctores.index')->with('swal', [
        'icon' => 'success',
        'title' => '¡Actualizado!',
        'text' => 'Doctor actualizado correctamente.',
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $doctor = Doctor::findOrFail($id);
    
    DB::transaction(function () use ($doctor) {
        if ($doctor->fotografia) {
            Storage::disk('public')->delete($doctor->fotografia);
        }

        $user = $doctor->user;

        $doctor->delete();   // 1. primero el doctor (el que tiene la llave foránea)
        $user?->forceDelete();    // 2. después el user
    });

    return redirect()->route('doctores.index')->with('swal', [
        'icon' => 'success',
        'title' => '¡Eliminado!',
        'text' => 'Doctor borrado correctamente.',
    ]);
}
}

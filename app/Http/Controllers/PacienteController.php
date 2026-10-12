<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       

        $buscar=$request->buscar;
       
        $pacientes=Paciente::with('user');
       if ($buscar) {
    $pacientes->where(function ($query) use ($buscar) {
        $query->where('nombres', 'like', "%{$buscar}%")
              ->orWhere('apellidos', 'like', "%{$buscar}%")
              ->orWhere('numero_documento', 'like', "%{$buscar}%");
    });
}
       $pacientes=$pacientes->paginate(3)->withQueryString();
       return view('admin.pacientes.index',compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PacienteRequest $request)
    {
       $user = new User();
$user->name = $request->nombres . ' ' . $request->apellidos;
$user->email = $request->email;
$user->password = Hash::make($request->numero_documento);
$user->estado = 'activo';
$user->save();

$user->assignRole('PACIENTE');

$paciente = new Paciente();
$paciente->user_id = $user->id;
$paciente->nombres = $request->nombres;
$paciente->apellidos = $request->apellidos;
$paciente->tipo_documento = $request->tipo_documento;
$paciente->numero_documento = $request->numero_documento;
$paciente->fecha_nacimiento = $request->fecha_nacimiento;
$paciente->genero = $request->genero;
$paciente->direccion = $request->direccion;
$paciente->telefono = $request->telefono;
$paciente->grupo_sanguineo = $request->grupo_sanguineo;
$paciente->alergias = $request->alergias;
$paciente->enfermedades = $request->enfermedades;
$paciente->medicamentos = $request->medicamentos;
$paciente->habitos = $request->habitos ? implode(', ', $request->habitos) : null;
$paciente->antecedentes = $request->antecedentes ? implode(', ', $request->antecedentes) : null;
$paciente->contacto_emergencia = $request->contacto_emergencia;
$paciente->telefono_emergencia = $request->telefono_emergencia;
$paciente->observaciones = $request->observaciones;
$paciente->save();

return redirect()->route('pacientes.index')->with('swal', [
    'icon' => 'success',
    'title' => '¡Creado!',
    'text' => 'Paciente registrado correctamente.',
]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $paciente=Paciente::with('user')->findOrFail($id);
       return view('admin.pacientes.show',compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paciente=Paciente::with('user')->findOrFail($id);
        return view('admin.pacientes.edit',compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PacienteRequest $request,string $id)
    {
    $paciente=Paciente::with('user')->findOrFail($id);
    $paciente->nombres              = $request->nombres;
$paciente->apellidos            = $request->apellidos;
$paciente->tipo_documento       = $request->tipo_documento;
$paciente->numero_documento     = $request->numero_documento;
$paciente->fecha_nacimiento     = $request->fecha_nacimiento;
$paciente->genero               = $request->genero;
$paciente->direccion            = $request->direccion;
$paciente->telefono             = $request->telefono;
$paciente->grupo_sanguineo      = $request->grupo_sanguineo;
$paciente->alergias             = $request->alergias;
$paciente->enfermedades         = $request->enfermedades;
$paciente->medicamentos         = $request->medicamentos;
$paciente->habitos              = $request->habitos ? implode(', ', $request->habitos) : null;
$paciente->antecedentes         = $request->antecedentes ? implode(', ', $request->antecedentes) : null;
$paciente->contacto_emergencia  = $request->contacto_emergencia;
$paciente->telefono_emergencia  = $request->telefono_emergencia;
$paciente->observaciones        = $request->observaciones;

$cambioDocumento = $paciente->isDirty('numero_documento');

$paciente->user->name  = $request->nombres . ' ' . $request->apellidos;
$paciente->user->email = $request->email;

if ($cambioDocumento) {
    $paciente->user->password = Hash::make($request->numero_documento);
}

$paciente->user->save();
$paciente->save();

return redirect()->route('pacientes.index')->with('swal', [
    'icon'  => 'success',
    'title' => '¡Actualizado!',
    'text'  => 'Paciente actualizado correctamente.',
]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paciente=Paciente::findOrfail($id);
        $paciente->user?->forceDelete();
        // $paciente->user?->forceDelete();
        // $paciente->delete();
        return redirect()->route('pacientes.index')->with('swal', [
    'icon' => 'success',
    'title' => 'Eliminado!',
    'text' => 'Paciente eliminado correctamente.',
]);
    }
    
}

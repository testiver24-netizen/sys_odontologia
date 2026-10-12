<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $buscar = $request->buscar;

    $especialidades = Especialidad::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'LIKE', "%{$buscar}%");
        })
        ->paginate(10)
        ->withQueryString();

    return view('admin.especialidades.index', compact('especialidades'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $datos = $request->validate([
        'nombre' => 'required|string|min:3|max:200|unique:especialidades,nombre',
        'descripcion' => 'nullable|string|min:3|max:200',
       
    ]);

    Especialidad::create($datos);

    return redirect()
        ->route('especialidades.index')
        ->with('swal', [
            'icon' => 'success',
            'title' => '¡Creado!',
            'text' => 'Especialidad registrada correctamente.',
        ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $datos=$request->validate([
              'nombre' => 'required|string|min:3|max:200|unique:especialidades,nombre,' .$id,
            'descripcion' => 'nullable|string|min:3|max:200',
        ]);
        $especialidad=Especialidad::find($id);
        $especialidad->update($datos);
        return redirect()
        ->route('especialidades.index')
        ->with('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'text' => 'Especialidad actualizado correctamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $especialidad=Especialidad::find($id);
    
        $especialidad->delete();
        return redirect()
        ->route('especialidades.index')
        ->with('swal', [
            'icon' => 'success',
            'title' => 'Eliminado!',
            'text' => 'Especialidad eliminada correctamente.',
        ]);
    }
}

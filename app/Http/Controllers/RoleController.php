<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $buscar = $request->buscar;

    $roles = Role::query()
       ->withCount('permissions')
        ->when($buscar, fn ($q) => $q->where('name', 'like', "%{$buscar}%"))
        ->paginate(3)
        ->withQueryString();

    return view('admin.roles.index', compact('roles'));
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
    public function store(RoleRequest $request)
    {
         $role = Role::create(['name' => strtoupper($request->name)]);

   
   

    return redirect()
        ->route('roles.index')
        ->with('swal', [
            'icon'=>'success',
            'title'=>'Guardado',
            'text'=>'Rol '.$role->name.' guardado correctamente',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(RoleRequest $request, string $id)
{
    $role = Role::findOrFail($id);
        if ($role->name === 'SUPER-ADMIN') {
    abort(403, 'Este rol no se puede modificar.');
}
    $role->update([
        'name' => strtoupper($request->name),
    ]);

    return redirect()
        ->route('roles.index')
        ->with('swal', [
            'icon'=>'success',
            'title'=>'Actualizado',
            'text'=>'Rol '.$role->name.' actualizado correctamente',
        ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()
        ->route('roles.index')
        ->with('swal', [
            'icon'=>'success',
            'title'=>'Eliminado',
            'text'=>'Rol '.$role->name.' eliminado correctamente',
        ]);
}
}

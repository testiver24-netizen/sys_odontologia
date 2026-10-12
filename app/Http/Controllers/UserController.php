<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $buscar = $request->buscar;
    $roles=Role::all();
    $users = User::query()
       ->withCount('permissions')
        ->when($buscar, fn ($q) => $q->where('name', 'like', "%{$buscar}%"))
        ->paginate(10)
        ->withQueryString();

    return view('admin.users.index', compact('users','roles'));
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
    public function store(UserRequest $request)
    {
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->estado=$request->estado;
        $user->save();
        $user->syncRoles($request->rol);
        return redirect()->route('users.index')->with('swal',[
            'icon'=>'success',
            'title'=>'!Creado¡',
            'text'=>'Usuario creado exitosamente',
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
    public function update(UserRequest $request, string $id)
    {
        $user=User::findOrfail($id);

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->estado=$request->estado;
        $user->save();
        $user->syncRoles($request->rol);
         return redirect()->route('users.index')->with('swal',[
            'icon'=>'success',
            'title'=>'!Eliminado',
            'text'=>'Usuario eliminado exitosamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use($id) {
             $user=User::findOrfail($id);
             // 1) borra el hijo primero
              $user->paciente?->delete();
               // 1) borra el hijo primero
              $user->doctor?->delete();
              // 1) despues borra el padre 
              $user->delete();
        });
      
       
       
       return redirect()->route('users.index')->with('swal',[
            'icon'=>'success',
            'title'=>'!Eliminado',
            'text'=>'Usuario eliminado exitosamente',
        ]);
    }
}

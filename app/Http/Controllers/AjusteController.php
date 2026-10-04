<?php

namespace App\Http\Controllers;

use App\Http\Requests\AjustesRequest;
use App\Models\Ajuste;
use App\Services\AjusteService;
use Illuminate\Http\Request;


class AjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ajuste=Ajuste::first();
        return view('admin.ajustes.index',compact('ajuste'));
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
    public function store(AjustesRequest $request,AjusteService $service)
    {
        
    // Siempre trabaja con el único registro (lo crea solo si no existe)
    $service->guardar($request->validated(), $request->file('url_logo'));

    return redirect()
        ->route('ajustes.index')
        ->with('success', 'Ajustes guardados correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ajuste $ajuste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ajuste $ajuste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ajuste $ajuste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ajuste $ajuste)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CitaPublica;

use Illuminate\Http\Request;

class CitaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("publica.inicio");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("agenda.reserva");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $citapublica = new CitaPublica();
            $citapublica->motivo = $request->input('motivo');
            $citapublica->fecha = $request->input('fecha');
            $citapublica->hora = $request->input('hora');
            $citapublica->nombre = $request->input('user');
            $citapublica->user_id = $request->input('user_id');

            $result = $citapublica->save();

            // Redirigir a la página de inicio después de guardar
            return redirect()->route('publicas')->with('success', 'Cita enviada exitosamente!');
        } catch (\Exception $e) {
            // Manejo de errores (puedes agregar un mensaje de error si lo deseas)
            return redirect()->back()->with('error', 'Ocurrió un error al enviar la cita.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publicas = CitaPublica::all();
        return response()->json($publicas);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function guardarFormulario(Request $request)
    {


    }
}

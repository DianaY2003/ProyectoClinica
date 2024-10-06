<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tratamientos = Tratamiento::all();

            return response()->json($tratamientos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("agenda.tratamiento");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar y guardar el tratamiento
            $tratamiento = new Tratamiento();
            $tratamiento->nombre = $request->input('nombre');
            $tratamiento->precio = $request->input('precio');
            
            // Guardar el tratamiento
            $tratamiento->save();
            
            return response()->json(["status" => 'Created', "data" => $tratamiento, 'message' => 'Tratamiento Registrado...!'], 201);
            
        } catch (\Exception $e) {
            return response()->json(["status" => 'fail', "data" => null, 'message' => 'Error al guardar el tratamiento...!'], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tratamiento $tratamiento)
    {
        try {
            $tratamiento = Tratamiento::findOrFail($id);

            return response()->json($tratamiento);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tratamiento $tratamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tratamiento $tratamiento)
    {
        try {
            $tratamiento = Tratamiento::findOrFail($tratamiento->id);
            $tratamiento->nombre = $request->nombre;
            $tratamiento->precio = $request->precio;
            $tratamiento->save();

            if($tratamiento->update()> 0){
                return response()->json(['status'=> 'Accepted','data'=>$tratamiento,'message'=>'Datos de tratamiento actualizados'],202);
            }else
            {
                return response()->json(['status'=> 'Not Accetable','data'=>null,'message'=> 'Error al actualizar el registro del tratamiento'],406);
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tratamiento $tratamiento)
    {
        try {
            $tratamiento = Tratamiento::find($tratamiento->id);
            
            if($tratamiento->delete()>0){
                return response()->json(['status'=> 'Delet','data'=>null,
                'message'=> 'Registro de tratamiento eliminado '],205);
            }else{
                return response()->json(['status'=> 'Conflict','data'=>null,
                'message'=> 'No se puede eliminar este registro'],409);
            }

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

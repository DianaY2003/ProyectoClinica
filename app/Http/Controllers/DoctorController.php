<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $doctores = Doctor::all();
            return response()->json($doctores);


        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //devolver una vista
        return view("agenda.doctor");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $nombre = $request->input("nombre");
            $record = Doctor::where("nombre", $nombre)->first();
            if($record){
                return response()->json(["status" => 'Conflict',"data"=> null, 
                "message" => 'Ya existe un Doctor con este nombre'],409);
            }else{
                $doctor = new Doctor();
                $doctor->nombre = $request->nombre;
                $doctor->especialidad = $request->especialidad;
                if($doctor->save() >=0){
                    return response()->json(["status" => 'Created',"data"=> $doctor,"message" => 'Doctor registrado con exito'],201);
                }else{
                    return response()->json(["status" => 'Fail',"data"=> null,
                "message" => 'Error al guardar el registro'],409);
                }
            }
           
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $doctor = doctor::findOrFail($id);
            return response()->json($doctor);

        }catch(\Exception $e){
            return $e->getMessage();

        }
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
        ]);
    
        $doctor = Doctor::findOrFail($id);
        $doctor->nombre = $request->input('nombre');
        $doctor->especialidad = $request->input('especialidad');
        $doctor->save();

        return response()->json([
            'id' => $doctor->id,
            'nombre' => $doctor->nombre,
            'especialidad' => $doctor->especialidad,
            'message' => 'Doctor actualizado correctamente.',
        ], 200);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $doctor = Doctor::findOrFail($id);
            if($doctor->delete() >=0){
                return response()->json(["status" => 'Deleted',"data"=> $doctor,"message" => 'Doctor eliminado con exito'],205);
            }else{
                return response()->json(["status" => 'Fail',"data"=> null,
            "message" => 'Error al eliminar el registro'],409);
            }

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}

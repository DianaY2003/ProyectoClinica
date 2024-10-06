<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $pacientes = Paciente::all();
            //convertimos a un array
            $response = $pacientes->toArray();
            $i = 0;

            foreach($pacientes as $paciente){
                $response[$i]["distrito"] = $paciente->distrito->toArray();
                $i++;
            }

            return response()->json($pacientes);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("agenda.paciente");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            //validando q no exista un nombre igual en la BD
            $nombre=$request->input("nombre");
            $record = Paciente::where("nombre",$nombre)->first();
            if($record){
                return response()->json(["status"=> 'Conflict', 'data'=>null,
                "Message"=> 'Ya existe un paciente registrado con este codigo'],409);
            }
            $paciente = new Paciente();
            $paciente->nombre=$request->nombre;
            $paciente->apellido=$request->apellido;
            $paciente->dui=$request->dui;
            $paciente->telefono=$request->telefono;
            $paciente->fecha_nacimiento=$request->fecha_nacimiento;
            $paciente->sexo=$request->sexo;
            $paciente->estado_civil=$request->estado_civil;
            $paciente->distrito_id=$request->distrito_id;
       
        if($paciente->save()>0){
           return response()->json(['status'=> 'Created','data'=>null,
           'message' => 'Paciente registrado...!'],201);
        }else{
            return response()->json(['status'=> 'Not Acceptable','data'=>null,
            'message' => 'Error al insertar el registro de paciente'],406);
        }
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        try{
            $paciente = Paciente::find($paciente->id);
            return response()->json($paciente);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $paciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        try{
            
            $paciente = Paciente::findOrfail($paciente->id);
            $paciente->nombre=$request->nombre;
            $paciente->apellido=$request->apellido;
            $paciente->dui=$request->dui;
            $paciente->telefono=$request->telefono;
            $paciente->fecha_nacimiento=$request->fecha_nacimiento;
            $paciente->sexo=$request->sexo;
            $paciente->estado_civil=$request->estado_civil;
            $paciente->distrito_id=$request->distrito_id;
            
            if($paciente->update()> 0){
                return response()->json(['status'=> 'Accepted','data'=>$paciente,'message'=>'Datos de pacientes actualizados'],202);
            }else
            {
                return response()->json(['status'=> 'Not Accetable','data'=>null,'message'=> 'Error al actualizar el registro del paciente'],406);
            }
    
            }
            catch(\Exception $e)
            {
                return $e->getMessage();
            }      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
    
    }
}

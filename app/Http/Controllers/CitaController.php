<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $citas = Cita::all();

            //convertimos a un array
            $response = $citas->toArray();
            $i = 0;

            foreach($citas as $cita){
                $response[$i]["paciente"] = $cita->paciente->toArray();
                $i++;
            }

            return response()->json($citas);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
        try {
            $cita = new Cita();
            $cita->motivo = $request->motivo;
            $cita->fecha = $request->fecha;
            $cita->hora = $request->hora;
            $cita->estado = $request->estado;
            $cita->paciente_id = $request->paciente_id;
            $cita->doctor_id = $request->doctor_id;
            $cita->observaciones = $request->observaciones;
            $cita->adiagnosticos = $request->adiagnosticos;
            $cita->pla_tratamiento = $request->pla_tratamiento;


            $result = $cita->save();

            if($result > 0){
                return response()->json(["status"=> 'Created',"data"=> $cita,'message'=>'Cita Registrada...!'],201);
            }else{
                return response()->json(["status"=> 'fail',"data"=> null,'message'=>'Error...!'],409);
            }
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cita = Cita::findOrFail($id);

            //convertimos a un array
            $response = $cita->toArray();
            $response["paciente"] = $cita->paciente->toArray();

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
 
             $cita = Cita::findOrFail($id);
             $cita->fecha = $request->fecha;
             $cita->hora = $request->hora;
             $cita->motivo = $request->motivo;
             $cita->estado = $request->estado;
             $cita->paciente_id = $request->paciente_id;
             $cita->doctor_id = $request->doctor_id;
             $cita->observaciones = $request->observaciones;
             $cita->adiagnosticos = $request->adiagnosticos;
             $cita->pla_tratamiento = $request->pla_tratamiento;
 
             if($cita->update() > 0){
                 return response()->json(["status"=> 'Accepted',"data"=> $cita,'message'=>'Cita Actualizada...!'],202);
             }else{
                 return response()->json(["status"=> 'fail',"data"=> null,'message'=>'Error al actualiza la cita...!'],409);
             }
             
         } catch (\Exception $e) {
             return $e->getMessage();
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            $cita = Cita::findOrFail($id);

            if($cita->delete()>0){
                return response()->json(["status"=> 'Delete',"data"=> null,'message'=>'Cita Eliminada...!'],205);
            }else{
                return response()->json(["status"=> 'Conflict',"data"=> null,'message'=>'No se puede eliminar esta cita...!'],409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function agenda(){
        return view('agenda.agenda');
    }

    public function showExpediente($id)
    {
        return view('agenda.expediente',['paciente_id' => $id]);
    }

    public function expedientePaciente($id)
    {
        $paciente = Paciente::with('citas')->findOrFail($id);
        return response()->json($paciente);
    }

    public function consulta($id)
    {
        return view('agenda.consulta',['cita_id' => $id]);
    }

    public function consultaPaciente($id)
    {
        $consulta = Cita::findOrFail($id);
        return response()->json($consulta);
    }
}

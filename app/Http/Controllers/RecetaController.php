<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Cita;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($cita_id)
    {
        try {
            $cita = Cita::findOrFail($cita_id);
            $recetas = $cita->recetas()->with('medicamentos')->get();

            $response = $recetas->toArray();
            $i = 0;

            foreach ($recetas as $receta) {
                $response[$i]["medicamentos"] = $receta->medicamentos->toArray();
                $i++;
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $cita_id)
    {
        try {
            $receta = Receta::where('cita_id', $cita_id)->first();

        if ($receta) {
            // Si ya existe, actualizamos los medicamentos
            $receta->medicamentos()->detach(); // Eliminar relaciones previas de medicamentos
            
            foreach ($request->medicamentos as $medicamento) {
                $receta->medicamentos()->attach($medicamento['id'], [
                    'cantidad' => $medicamento['cantidad'],
                    'dosis' => $medicamento['dosis']
                ]);
            }

            return response()->json(["status" => 'Updated', "data" => $receta, 'message' => 'Receta actualizada con éxito.'], 200);
        }
            else{
                $receta = new Receta();
            $receta->cita_id = $cita_id;

            $result = $receta->save();

            if ($result > 0) {
                foreach ($request->medicamentos as $medicamento) {
                    $receta->medicamentos()->attach($medicamento['id'], [
                        'cantidad' => $medicamento['cantidad'], // Usamos la cantidad del objeto actual
                        'dosis' => $medicamento['dosis']
                    ]);
                }

                return response()->json(["status" => 'Created', "data" => $receta, 'message' => 'Receta creada con éxito.'], 201);
            } else {
                return response()->json(["status" => 'fail', "data" => null, 'message' => 'Error al crear la receta...!'], 409);
            }}
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($cita_id)
    {
        try {
            $cita = Cita::findOrFail($cita_id);
            $receta = $cita->recetas()->with('medicamentos')->first();

            // $response = $receta;
            // $response["medicamentos"] = $receta->medicamentos->toArray();

            // return response()->json($response);
            // Aquí puedes acceder a los datos del pivot

            $medicamentos = $receta->medicamentos->map(function ($medicamento) {
                return [
                    'id' => $medicamento->id,
                    'cantidad' => $medicamento->pivot->cantidad,
                    'dosis' => $medicamento->pivot->dosis,
                ];
            });

            // Formateamos la respuesta
            return response()->json([
                'receta_id' => $receta->id,
                'medicamentos' => $medicamentos, // Aquí enviamos los medicamentos en el formato esperado
            ]);


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cita_id, $receta_id)
    {
        try {
            $receta = Receta::findOrFail($receta_id);
            $receta->descripcion = $request->descripcion;

            if ($receta->update() > 0) {
                // Actualizar medicamentos asociados
                $receta->medicamentos()->detach(); // Limpiar los anteriores
                foreach ($request->medicamentos as $index => $medicamento_id) {
                    $receta->medicamentos()->attach($medicamento_id, [
                        'cantidad' => $request->cantidades[$index]
                    ]);
                }

                return response()->json(["status" => 'Accepted', "data" => $receta, 'message' => 'Receta actualizada...!'], 202);
            } else {
                return response()->json(["status" => 'fail', "data" => null, 'message' => 'Error al actualizar la receta...!'], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cita_id, $receta_id)
    {
        try {
            $receta = Receta::findOrFail($receta_id);

            if ($receta->delete() > 0) {
                return response()->json(["status" => 'Delete', "data" => null, 'message' => 'Receta eliminada...!'], 205);
            } else {
                return response()->json(["status" => 'Conflict', "data" => null, 'message' => 'No se puede eliminar la receta...!'], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

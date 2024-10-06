<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $medicamentos = Medicamento::all();
            return response()->json($medicamentos);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $medicamento = new Medicamento();
            $medicamento->nombre = $request->nombre;
            $medicamento->descripcion = $request->descripcion;
            $medicamento->dosis = $request->dosis;

            $result = $medicamento->save();

            if ($result > 0) {
                return response()->json(["status" => 'Created', "data" => $medicamento, 'message' => 'Medicamento creado con éxito.'], 201);
            } else {
                return response()->json(["status" => 'fail', "data" => null, 'message' => 'Error al crear el medicamento...!'], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $medicamento = Medicamento::findOrFail($id);
            return response()->json($medicamento);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $medicamento = Medicamento::findOrFail($id);
            $medicamento->nombre = $request->nombre;
            $medicamento->descripcion = $request->descripcion;
            $medicamento->dosis = $request->dosis;

            if ($medicamento->update() > 0) {
                return response()->json(["status" => 'Accepted', "data" => $medicamento, 'message' => 'Medicamento actualizado...!'], 202);
            } else {
                return response()->json(["status" => 'fail', "data" => null, 'message' => 'Error al actualizar el medicamento...!'], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $medicamento = Medicamento::findOrFail($id);

            if ($medicamento->delete() > 0) {
                return response()->json(["status" => 'Delete', "data" => null, 'message' => 'Medicamento eliminado...!'], 205);
            } else {
                return response()->json(["status" => 'Conflict', "data" => null, 'message' => 'No se puede eliminar el medicamento...!'], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

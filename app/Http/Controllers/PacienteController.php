<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pacientes = Paciente::all();
            //convertimos a un array
            $response = $pacientes->toArray();
            $i = 0;

            foreach ($pacientes as $paciente) {
                $response[$i]["distrito"] = $paciente->distrito->toArray();
                $i++;
            }

            return response()->json($pacientes);
        } catch (\Exception $e) {
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
         try {
             // Validación de los datos
             $validatedData = $request->validate([
                 'nombre' => 'required|string|max:255|unique:pacientes,nombre',
                 'apellido' => 'required|string|max:255',
                 'dui' => 'nullable|string|max:10',
                 'telefono' => 'nullable|string|max:15',
                 'fecha_nacimiento' => 'required|date',
                 'sexo' => 'required|string|max:10',
                 'estado_civil' => 'nullable|string|max:20',
                 'distrito_id' => 'required|exists:distritos,id',
                 'imagenes' => 'nullable|array',
                 'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
             ]);
     
             $paciente = new Paciente();
             $paciente->nombre = $validatedData['nombre'];
             $paciente->apellido = $validatedData['apellido'];
             $paciente->dui = $validatedData['dui'];
             $paciente->telefono = $validatedData['telefono'];
             $paciente->fecha_nacimiento = $validatedData['fecha_nacimiento'];
             $paciente->sexo = $validatedData['sexo'];
             $paciente->estado_civil = $validatedData['estado_civil'];
             $paciente->distrito_id = $validatedData['distrito_id'];
             
             $result = $paciente->save();
     
             if ($request->hasFile('imagenes')) {
                 foreach ($request->file('imagenes') as $imagen) {
                     $imageName = time() . '_' . $imagen->getClientOriginalName();
                     $imagen->move(public_path('images/pacientes'), $imageName);
                     // Guardar la imagen en la tabla de imágenes
                     $img = new Imagen();
                     $img->nombre = $imageName;
                     $img->paciente_id = $paciente->id;
                     $img->save();
                 }
             }
     
             if ($result) {
                 $newPa = $this->show($paciente->id);
                 return response()->json([
                     'status' => 'Created',
                     'data' => $newPa,
                     'message' => 'Paciente registrado...!'
                 ], 201);
             } else {
                 return response()->json([
                     'status' => 'Not Acceptable',
                     'data' => null,
                     'message' => 'Error al insertar el registro de paciente'
                 ], 406);
             }
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
     


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
    
            // Convertir el paciente a un array
            $response = $paciente->toArray();
    
            // Obtener las imágenes y agregarlas a la respuesta
            $imagenes = $paciente->imagenes()->get()->toArray();
            $response["imagenes"] = $imagenes;
    
            // Retornar la respuesta completa con las imágenes
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
        try {

            $paciente = Paciente::findOrfail($paciente->id);
            $paciente->nombre = $request->nombre;
            $paciente->apellido = $request->apellido;
            $paciente->dui = $request->dui;
            $paciente->telefono = $request->telefono;
            $paciente->fecha_nacimiento = $request->fecha_nacimiento;
            $paciente->sexo = $request->sexo;
            $paciente->estado_civil = $request->estado_civil;
            $paciente->distrito_id = $request->distrito_id;

            if ($paciente->update() > 0) {
                return response()->json(['status' => 'Accepted', 'data' => $paciente, 'message' => 'Datos de pacientes actualizados'], 202);
            } else {
                return response()->json(['status' => 'Not Accetable', 'data' => null, 'message' => 'Error al actualizar el registro del paciente'], 406);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente) {}
}

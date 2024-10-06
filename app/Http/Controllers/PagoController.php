<?php

namespace App\Http\Controllers;
use App\Models\Pago;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Cargar los pagos junto con las relaciones de paciente y tratamiento
         $pagos = Pago::with(['paciente', 'tratamiento'])->get();
        
         return response()->json($pagos);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         //devolver una vista
         return view("agenda.pago");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            
                $pago = new Pago();
                $pago->paciente_id = $request->paciente_id;
                $pago->tratamiento_id = $request->tratamiento_id;
                $pago->tipo_pago = $request->tipo_pago;
                $pago->banco = $request->banco;
                $pago->fecha_pago=$request->fecha_pago;
                $pago->precio = $request->input('precio');

                $result = $pago->save();

                if($result > 0){
                    return response()->json(["status"=> 'Created',"data"=> $pago,'message'=>'Pago Registrado...!'],201);
                }else{
                    return response()->json(["status"=> 'fail',"data"=> null,'message'=>'Error...!'],409);
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
            $pago = pago::findOrFail($id);
            return response()->json($pago);

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
    // Validar los datos de entrada
    $validatedData = $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'tratamiento_id' => 'required|exists:tratamientos,id',
        'tipo_pago' => 'required|in:Tarjeta,Efectivo,OtroTipoDePago', // Agrega otros tipos de pago que tengas
        'fecha_pago' => 'required|date',
        'precio' => 'required|numeric|min:0',
        // 'banco' es requerido solo si el tipo de pago NO es 'Efectivo' ni 'Tarjeta'
        'banco' => 'nullable|required_unless:tipo_pago,Efectivo,Tarjeta',
    ]);

    try {
        // Encontrar el pago existente por ID
        $pago = Pago::findOrFail($id);

        // Actualizar los campos
        $pago->paciente_id = $validatedData['paciente_id'];
        $pago->tratamiento_id = $validatedData['tratamiento_id'];
        $pago->tipo_pago = $validatedData['tipo_pago'];
        $pago->fecha_pago = $validatedData['fecha_pago'];
        $pago->precio = $validatedData['precio'];

        // Si el tipo de pago no es 'Efectivo' ni 'Tarjeta', actualizar el banco
        if ($validatedData['tipo_pago'] !== 'Efectivo' && $validatedData['tipo_pago'] !== 'Tarjeta') {
            $pago->banco = $validatedData['banco'];
        } else {
            // Si es 'Efectivo' o 'Tarjeta', asegurarse de que 'banco' sea NULL
            $pago->banco = null;
        }

        // Guardar los cambios en la base de datos
        $pago->save();

        // Respuesta exitosa
        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'pago' => $pago
        ], 200);

    } catch (\Exception $e) {
        // Manejar posibles errores
        return response()->json([
            'message' => 'Error al actualizar el pago',
            'error' => $e->getMessage()
        ], 500);
    }


}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Receta;
use App\Models\Cita;
use App\Models\CitaPublica;


class PDFController extends Controller
{
    public function getPacientes()
    {
        $pacientes = Paciente::join('distritos', 'pacientes.distrito_id', '=', 'distritos.id')
            ->select(
                'pacientes.nombre',
                'pacientes.apellido',
                'pacientes.dui',
                'pacientes.telefono',
                'pacientes.fecha_nacimiento',
                'pacientes.sexo',
                'pacientes.estado_civil',
                'distritos.nombre as distrito_nombre',

            )
            ->orderBy('pacientes.id', 'ASC')->get();
        $pdf = \PDF::loadView('admin.listadoPacientesPDF', compact('pacientes'));
        return $pdf->stream('listado_pacientes.pdf');
    }
    public function getPagos(Request $request) {
        // Validar las fechas
        $request->validate([
            'fechaInicio' => 'required|date',
            'fechaFinal' => 'required|date|after_or_equal:fechaInicio',
        ]);
    
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;
    
        // Obtener pagos
        $pagos = Pago::join('pacientes', 'pagos.paciente_id', '=', 'pacientes.id')
            ->select(
                
                'pacientes.nombre as paciente', // Asegúrate de que este campo existe
                'pagos.fecha_pago',
                'pagos.precio'
            )
            ->whereBetween('pagos.fecha_pago', [$fecha1, $fecha2])
            ->orderBy('pagos.id', 'DESC')
            ->get();
    
        
        // Generar PDF
        $pdf = \PDF::loadView('admin.pagosPDF', compact('pagos', 'fecha1', 'fecha2'));
        return $pdf->stream('reporte_pagos.pdf');
    }
    
    //reporte de citas
    public function getCitas(Request $request) {
        // Validar las fechas
        $request->validate([
            'fechaInicio' => 'required|date',
            'fechaFinal' => 'required|date|after_or_equal:fechaInicio',
        ]);
    
        $fecha1 = $request->fechaInicio;
        $fecha2 = $request->fechaFinal;
    
        // Obtener citas
        $publicas = Citapublica::select(
            'publicas.nombre as publicas', // usuario
            'publicas.fecha'
        )
        ->whereBetween('publicas.fecha', [$fecha1, $fecha2])
        ->orderBy('publicas.id', 'DESC')
        ->get();

    
        
        // Generar PDF
        $pdf = \PDF::loadView('admin.citasPDF', compact('publicas', 'fecha1', 'fecha2'));
        return $pdf->stream('reporte_citas.pdf');
    }
    
    // Llamar reporte
    public function viewPagos()
    {
        return view('admin.reportePagos');
    }

    //citas
    public function viewCitas()
    {
        return view('admin.reporteCitas');
    }

    public function generarRecetaPDF($id)
    {
    // Obtener la cita relacionada y los datos del paciente
    $cita = Cita::with('recetas.medicamentos','paciente')->findOrFail($id);

    // Pasar los datos a la vista
    $pdf = \PDF::loadView('admin.receta', compact('cita'));
    
    // Devolver el PDF para visualizar en el navegador
    return $pdf->stream('receta_'.$cita->paciente->nombre.'.pdf');
}
}

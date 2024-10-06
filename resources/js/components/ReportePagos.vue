<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Generar Reporte de Pagos por Periodos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="">Desde: &nbsp;</label>
                                <input type="date" v-model="fechaInicio" />
                            </div>
                            <div class="col-4">
                                <label for="">Hasta: &nbsp;</label>
                                <input type="date" v-model="fechaFinal" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <button @click="generarReporte" class="btn btn-primary btn-sm">Generar Reporte</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            fechaInicio: null,
            fechaFinal: null,
        };
    },
    methods: {
        generarReporte() {
            if (!this.fechaInicio || !this.fechaFinal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Por favor seleccione ambas fechas',
                    text: 'Es necesario seleccionar la fecha de inicio y la fecha final para crear el reporte.',
                });
                return;
            }

            // Si ambas fechas están seleccionadas, redirige al reporte
            const url = `/reportes/pagos/rango?fechaInicio=${this.fechaInicio}&fechaFinal=${this.fechaFinal}`;
            window.open(url, '_blank');
        }
    }
}
</script>

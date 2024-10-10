<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Generar Reporte de Citas por Periodos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="fechaInicio">Desde: &nbsp;</label>
                                <input type="date" v-model="fechaInicio" id="fechaInicio" class="form-control" />
                            </div>
                            <div class="col-4">
                                <label for="fechaFinal">Hasta: &nbsp;</label>
                                <input type="date" v-model="fechaFinal" id="fechaFinal" class="form-control" />
                            </div>
                        </div>
                        <div class="row mt-3">
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

        // Redirigir al reporte
        const url = `/reportes/citas/rango?fechaInicio=${this.fechaInicio}&fechaFinal=${this.fechaFinal}`;
        window.open(url, '_blank');
    }
}

}
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>

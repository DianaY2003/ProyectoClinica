<template>
  <div class="mt-4">
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Información del Paciente</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>Nombre:</strong> {{ paciente.nombre }}</p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>Apellido:</strong> {{ paciente.apellido }}</p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>DUI:</strong> {{ paciente.dui }}</p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>Teléfono:</strong> {{ paciente.telefono }}</p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>Fecha de Nacimiento:</strong> {{ paciente.fecha_nacimiento }}</p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="mb-1"><strong>Sexo:</strong> {{ paciente.sexo }}</p>
              </div>
              <div class="col-md-12 mb-2">
                <p class="mb-0"><strong>Estado Civil:</strong> {{ paciente.estado_civil }}</p>
              </div>
              <div class="col-md-12 text-end" style="text-align: end;">
                <button @click="irAOdontograma" class="btn btn-primary">Odontograma</button>

             <button class="btn btn-success" @click="irATrabajo(paciente.id)">Trabajos</button>
              </div>


            </div>
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">
            <h4 class="mb-0">Historial de Citas</h4>
          </div>
          <div class="card-body">
            <div v-if="paciente.citas && paciente.citas.length > 0">
              <div v-for="cita in paciente.citas" :key="cita.id" class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Fecha:</strong> {{ cita.fecha }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Hora:</strong> {{ cita.hora }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Historia Medica:</strong> {{ cita.motivo }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Estado:</strong> {{ cita.estado }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Historia Odontologica:</strong> {{ cita.observaciones }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Examen Radiografico:</strong> {{ cita.adiagnosticos }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Examen Radiografico:</strong> {{ cita.adiagnosticos }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                      <p class="mb-1"><strong>Plan de Tratamiento:</strong> {{ cita.pla_tratamiento }}</p>
                    </div>

                  </div>
                  <div class="row mt-3">
                    <div class="col-md-2" v-if="cita.estado !== 'Agendada'">
                      <button class="btn btn-info btn-block" @click="verRecetas(cita.id)">Ver Receta</button>
                    </div>
                    <div class="col-md-2" v-if="cita.estado === 'Agendada'">
                      <button class="btn btn-success btn-block" @click="atenderCita(cita.id)">Atender Cita</button>
                    </div>
                    <div class="col-md-2">
                      <button class="btn btn-success btn-block" @click="verReceta(cita.id)">Ver Receta</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="text-center mt-3">
              <p class="mb-0">No hay citas registradas para este paciente.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  props: {
    pacienteId: Number
  },
  data() {
    return {
      paciente: {}
    };
  },
  created() {
    this.fetchPaciente();
  },
  methods: {
    async fetchPaciente() {
      try {
        const response = await fetch(`/api/citas/expediente/${this.pacienteId}`);
        if (!response.ok) {
          throw new Error('No se pudo obtener el paciente');
        }
        this.paciente = await response.json();
      } catch (error) {
        console.error('Error al obtener el paciente:', error.message);
      }
    },
    verRecetas(citaId) {
      // Lógica para ver recetas
      console.log(`Ver recetas para la cita ${citaId}`);
    },
    irAOdontograma() {
      // Redirigir a la ruta del odontograma
      window.location.href = `/odontograma/${this.pacienteId}`;
    },
    irATrabajo(citaId) {
      // Lógica para ir a trabajo
      console.log(`Ir a trabajo para la cita ${citaId}`);
    },
   
    atenderCita(citaId) {
      // Lógica para atender cita
      location.href = "/consulta/" + citaId;
    },
    verReceta(citaId) {
      // Lógica para ver cita
      location.href = "/recetas/" + citaId + "/pdf";
    }
  }
};
</script>

<style scoped>
.container {
  padding-top: 20px;
}
.card {
  transition: box-shadow 0.3s;
}
.card:hover {
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
</style>

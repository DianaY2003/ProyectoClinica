<template>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">{{ isEditMode ? 'Consulta' : 'Consulta' }}</div>
            <div class="card-body">
              <form @submit.prevent="submitForm">
                <div class="form-group row">
                  <label for="fecha" class="col-md-4 col-form-label">Fecha</label>
                  <div class="col-md-8">
                    <input type="date" v-model="cita.fecha" class="form-control" id="fecha">
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="hora" class="col-md-4 col-form-label">Hora</label>
                  <div class="col-md-8">
                    <input type="time" v-model="cita.hora" class="form-control" id="hora">
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="motivo" class="col-md-4 col-form-label">Motivo</label>
                  <div class="col-md-8">
                    <textarea v-model="cita.motivo" class="form-control" id="motivo" rows="3"></textarea>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="estado" class="col-md-4 col-form-label">Estado</label>
                  <div class="col-md-8">
                    <input type="text" v-model="cita.estado" class="form-control" id="estado">
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="paciente_id" class="col-md-4 col-form-label">Paciente</label>
                  <div class="col-md-8">
                    <select v-model="cita.paciente_id" :disabled="isEditMode" class="form-control" id="paciente_id">
                      <option value="" disabled>Selecciona un paciente</option>
                      <option v-for="paciente in pacientes" :key="paciente.id" :value="paciente.id">{{ paciente.nombre }}</option>
                    </select>
                    <span v-if="isEditMode">{{ pacienteSeleccionado }}</span>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="user_id" class="col-md-4 col-form-label">Dentista</label>
                  <div class="col-md-8">
                    <select v-model="cita.doctor_id" class="form-control" id="doctor_id">
                      <option value="" disabled>Selecciona un dentista</option>
                      <option v-for=" doctor in doctores" :key="doctor.id" :value="doctor.id">{{ doctor.nombre }}</option>
                    </select>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="observaciones" class="col-md-4 col-form-label">Observaciones</label>
                  <div class="col-md-8">
                    <textarea v-model="cita.observaciones" class="form-control" id="observaciones" rows="3"></textarea>
                  </div>
                </div>
  
                <div class="form-group row">
                  <label for="adiagnosticos" class="col-md-4 col-form-label">Diagnósticos Adicionales</label>
                  <div class="col-md-8">
                    <textarea v-model="cita.adiagnosticos" class="form-control" id="adiagnosticos" rows="3"></textarea>
                  </div>
                </div>
  
                <div class="form-group row">
                  <div class="col-md-4 offset-md-2">
                    <button type="submit" class="btn btn-success">{{ isEditMode ? 'Actualizar' : 'Guardar' }}</button>
                  </div>
                  <div class="col-md-4 offset-md-2" v-if="isEditMode" >
                    <button type="button" class="btn btn-warning" @click="abrirModalReceta">Crear Receta</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

 <!-- Modal para la creación de recetas -->
 <div class="modal fade" id="modalReceta" tabindex="-1" role="dialog" aria-labelledby="modalRecetaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRecetaLabel">Crear Receta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form @submit.prevent="submitRecetaForm">
          <!-- <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea v-model="nuevaReceta.descripcion" class="form-control" id="descripcion"></textarea>
          </div> -->
          <div class="form-group">
            <label for="medicamento">Medicamentos</label>
            <div v-for="(medicamento, index) in nuevaReceta.medicamentos" :key="index" class="input-group mb-3">
              <select v-model="medicamento.id" class="form-control">
                <option value="">Selecciona un medicamento</option>
                <option v-for="med in listaMedicamentos" :key="med.id" :value="med.id">
                  {{ med.nombre }}
                </option>
              </select>
              <input type="number" v-model="medicamento.cantidad" placeholder="Cantidad" class="form-control" min="1">
              <input type="text" v-model="medicamento.dosis" placeholder="Dosis" class="form-control">
            </div>
            <button type="button" class="btn btn-secondary" @click="agregarMedicamento">Agregar Medicamento</button>
          </div>
          <button type="submit" class="btn btn-primary">Guardar Receta</button>
        </form>
      </div>
    </div>
  </div>
</div>

  </template>
  
 


  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  export default {
    props: {
      citaId: {
        type: Number,
        required: true
      }
    },
    setup(props) {

      /***Seccion de recetas***/
      const nuevaReceta = ref({
        medicamentos: [{ id: null, cantidad: 1, dosis: null }]
      });

      const listaMedicamentos = ref([]);

      const fetchMedicamentos = async () => {
        try {
          const response = await axios.get('/api/medicamentos');
          listaMedicamentos.value = response.data;
        } catch (error) {
          console.error('Error fetching medicamentos:', error);
        }
      };

      const agregarMedicamento = () => {
        nuevaReceta.value.medicamentos.push({ id: null, cantidad: 1, dosis: null });
      };

      const submitRecetaForm = async () => {
        try {
        // Crea un objeto con los datos que deseas enviar
        const recetaData = {
            medicamentos: nuevaReceta.value.medicamentos, // Array de IDs de medicamentos seleccionados
        };

        const response = await axios.post(`/api/recetas/${props.citaId}`, recetaData);
        console.log('Receta creada:', response.data);

        // Cerrar modal después de crear receta
        $('#modalReceta').modal('hide');

        // Opcional: Puedes agregar lógica para actualizar el estado de tu aplicación o mostrar un mensaje de éxito
        } catch (error) {
            console.error('Error creando receta:', error);
            // Opcional: Puedes manejar el error de una forma más amigable para el usuario
        }
      };

      const cargarReceta = async () => {
            try {
                const response = await axios.get(`/api/recetas/show/${props.citaId}`);

                if(response.data.medicamentos.length > 0){
                  nuevaReceta.value.medicamentos = response.data.medicamentos;
                }
                
            } catch (error) {
                console.error('Error cargando la receta:', error);
            }
        };

      const abrirModalReceta = () => {
        $('#modalReceta').modal('show');
      };
      /**Fin de seccion de recetas**/

      const cita = ref({
        fecha: '',
        hora: '',
        motivo: '',
        estado: '',
        paciente_id: null,
        doctor_id: null,
        observaciones: '',
        adiagnosticos: ''
      });
      const isEditMode = ref(false);
      const pacientes = ref([]);
      const doctores = ref([]);
  
      const fetchCita = async () => {
        if (props.citaId) {
          try {
            const response = await axios.get(`/api/citas/consulta/${props.citaId}`);
            cita.value = response.data;
            isEditMode.value = true;
          } catch (error) {
            console.error('Error fetching cita:', error);
          }
        }
      };
  
      const fetchPacientes = async () => {
        try {
          const response = await axios.get('/api/pacientes');
          pacientes.value = response.data;
        } catch (error) {
          console.error('Error fetching pacientes:', error);
        }
      };
  
      const fetchDoctores = async () => {
        try {
          const response = await axios.get('/api/doctores');
          doctores.value = response.data;
        } catch (error) {
          console.error('Error fetching doctores:', error);
        }
      };
  
      const submitForm = async () => {
        try {
          if (isEditMode.value) {
            await updateCita();
          } else {
            await createCita();
          }
        } catch (error) {
          console.error('Error submitting form:', error);
        }
      };
  
      const createCita = async () => {
        try {
          const response = await axios.post('/api/citas', cita.value);
          verificarAccion(response.data, response.status, 'add', response.data.message);
        } catch (error) {
          console.error('Error creating cita:', error);
        }
      };
  
      const updateCita = async () => {
        try {
          const response = await axios.put(`/api/citas/${props.citaId}`, cita.value);
          verificarAccion(response.data, response.status, 'upd', response.data.message);
        } catch (error) {
          console.error('Error updating cita:', error);
        }
      };
  
      const verificarAccion = (cita, statusCode, accion, message) => {
        // Aquí puedes implementar la lógica para mostrar mensajes o realizar acciones adicionales después de guardar o actualizar la cita
        console.log('Acción verificada:', cita, statusCode, accion, message);
      };
  
      onMounted(() => {
        fetchCita();
        fetchPacientes();
        fetchDoctores();
        fetchMedicamentos();
        cargarReceta();
      });
  
      const pacienteSeleccionado = ref('');
  
      // Cargar el nombre del paciente seleccionado si estamos en modo edición
      onMounted(() => {
        if (isEditMode.value && cita.value.paciente_id) {
          const paciente = pacientes.value.find(p => p.id === cita.value.paciente_id);
          if (paciente) {
            pacienteSeleccionado.value = paciente.nombre;
          }
        }
      });
  
      return {
        nuevaReceta,
        listaMedicamentos,
        abrirModalReceta,
        agregarMedicamento,
        submitRecetaForm,
        cita,
        isEditMode,
        pacientes,
        doctores,
        submitForm,
        pacienteSeleccionado
      };
    }
  };
  </script>
  
  <style scoped>
  .card {
    margin-top: 2rem;
  }
  
  .btn-success {
    width: 100%;
  }
  </style>
  
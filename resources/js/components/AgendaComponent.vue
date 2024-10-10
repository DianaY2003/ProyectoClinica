<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import esLocale from "@fullcalendar/core/locales/es";
import Swal from 'sweetalert2';

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data() {
    return {
      cita: {
        id:null,
        fecha:"",
        hora:"",
        motivo:"",
        estado:"",
        paciente_id:null,
        doctor_id:null,
      },
      pacientes: [],
      doctores: [],
      opcionesEstado: [
                    { label: 'Agendada', value: 'Agendada' },
                    { label: 'Pendiente de aprobar', value: 'Pendiente de aprobar' },
                    { label: 'Reagendada', value: 'Reagendada' }
                    ],
      calendarOptions: {
        plugins: [ dayGridPlugin, timeGridPlugin, interactionPlugin , listPlugin],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,list,customButton'
        },
        customButtons: {
            customButton: {
            text: 'Crear Cita',
            click: this.handleDateSelect
            }
        },
        initialView: 'dayGridMonth',
        locale: esLocale,
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents
         /* you can update a remote database when these fire:
        eventAdd:
        eventChange:
        eventRemove:
        */
      },
      currentEvents: [],
      newEventTitle: '',
      newEventDate: ''
    }
  },
  computed:{
            formTitle(){
               return  this.cita.id == null ? "Agendar nueva cita" : "Actualizar cita";
            },
            btnTitle(){
               return this.cita.id == null ? "Guardar" : "Actualizar";
            }
        },
  methods: {
    async fetchCitas() {
      axios.get('/api/citas/')
        .then(response => {
          const events = response.data.map(event => ({
            title: event.motivo,
            start: event.fecha + "T" + event.hora,
            end: event.fecha,
            id : event.id,
            fecha : event.fecha,
            hora: event.hora,
            motivo: event.motivo,
            estado : event.estado,
            paciente_id : event.paciente_id,
            doctor_id : event.doctor_id,
            allDay: false
          }));
          let calendarApi = this.$refs.fullCalendar.getApi();
          calendarApi.removeAllEvents(); // Eliminar todos los eventos actuales
          calendarApi.addEventSource(events); // Añadir los eventos obtenidos de la API
        })
        .catch(error => {
          console.error("Error fetching events: ", error);
        });
    },
    async fetchPacientes(){
        await this.axios.get(`/api/pacientes`)
        .then(response => {
            this.pacientes = response.data;
        })
        .catch(error => {
            console.log(error);
        })
    },
    async fetchDoctores(){
        await this.axios.get(`/api/doctores`)
        .then(response => {
            this.doctores = response.data;
        })
        .catch(error => {
            console.log(error);
        })
    },
    handleWeekendsToggle() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
    },
    handleDateSelect(selectInfo) {
      this.newEventDate = selectInfo.startStr; // Guardar la fecha seleccionada
      this.newEventTitle = ''; // Limpiar el título del evento
      $('#eventModal').modal('show');
    },
    handleEventClick(evento) {
      this.cita.id = evento.event.id;
      this.cita.fecha = evento.event.extendedProps.fecha;
      this.cita.hora = evento.event.extendedProps.hora;
      this.cita.motivo = evento.event.extendedProps.motivo;
      this.cita.estado = evento.event.extendedProps.estado;
      this.cita.paciente_id = evento.event.extendedProps.paciente_id;
      this.cita.doctor_id = evento.event.extendedProps.doctor_id;
      $('#eventModal').modal('show');
    },
    handleEvents(events) {
      this.currentEvents = events
    },
    resetCita(){
      $('#eventModal').modal('hide');
      this.cita = {}
    },
    async atenderCita(){
        let me = this;
        location.href = "consulta/" + this.cita.id ;
    },
    async eliminarCita(){
            let me = this;
            this.$swal.fire({
                title: 'Seguro/a de eliminar esta cita?',
                text: "No podras revertir la accion",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SI',
                cancelButtonText: 'NO',
            }).then((result) =>{
                if(result.value){
                    this.axios.delete(`/api/citas/${this.cita.id}`)
                    .then(response => {
                        me.verificarAccion(null,response.status,"del",response.data.message);
                        $('#eventModal').modal('hide');
                        this.cita = {}
                    }).catch(errors =>{
                        console.log(errors)
                    })
                }
            })
        },
    createFormData(){
        let formData = new FormData();
        
        formData.append("fecha",this.cita.fecha);
        formData.append("hora",this.cita.hora);
        formData.append("motivo",this.cita.motivo);
        formData.append("estado",this.cita.estado);
        formData.append("paciente_id",this.cita.paciente_id);
        formData.append("doctor_id",this.cita.doctor_id);

        return formData;
      },
      async saveOrUpdate(){
            let me = this;
            me.submitted = true;
            if(me.cita.motivo.trim()){
                let accion = me.cita.id == null ? "add" : "upd";
                const headers = {
                    headers:{
                        'Content-Type':'multipart/form-data'
                    }
                }
                if (accion == "add"){
                    //insertar una cita
                    await this.axios.post(`/api/citas`,this.createFormData(), headers)
                    .then(response => {
                        if (response.status == 201){
                            me.verificarAccion(response.data, response.status,accion,response.data.message);
                        }
                    }).catch(errors => {
                        console.log(errors);
                        if (errors.response.status == 409){
                            this.$swal.fire({
                                title: "precaucion...",
                                'text': errors.response.data.message,
                                icon: 'warning'
                            })
                        }
                    })
                }else{
                    await this.axios.put(`/api/citas/${me.cita.id}`,this.cita)
                    .then(response => {
                        if(response.status == 202){
                            me.verificarAccion(response.data.data,response.status,accion,response.data.message);
                        }
                    }).catch(errors => {
                        console.log(errors);
                        if(errors.response.status == 409){
                            this.$swal.fire({
                                title: "Precaucion...}",
                                text: errors.response.data.message,
                                icon: "warning"
                            });
                        }
                    })

                    
                }
                me.citaDialog = false;
                me.cita = {};
            }
            $('#eventModal').modal('hide');
        },        
        verificarAccion(cita,statusCode,accion,message){
            let me = this;
            const Toast = this.$swal.mixin({
                Swal: true,
                position:'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
            switch(accion){
                case "add":
                    Swal.fire({
                        icon: 'success',
                        'title':message
                    });
                    break;
                    case "upd":
                        Swal.fire({
                            icon:'success',
                            'title':message
                        });
                        break;
                     case "del":
                        if (statusCode == 205){
                            Toast.fire({
                                icon: 'success',
                                'title': 'Cita Eliminada...!'
                            });
                        }else{
                            this.$swal.fire({
                                icon: 'error',
                                text: 'No se puede eliminar esta cita'
                            });
                        } 
                       break;
                }  
                this.fetchCitas();    
                me.cita = {}  
            }
  },
  mounted() {
    this.fetchCitas(); // Llamar a la función para obtener eventos cuando el componente se monte
    this.fetchPacientes();
    this.fetchDoctores();
  }
}
</script>
<template>
  <FullCalendar ref="fullCalendar" :options="calendarOptions" />

  <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="eventModalLabel">{{ formTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="saveOrUpdate">
                    <div class="form-group">
                        <label for="citaFecha">Fecha de la cita</label>
                        <input type="date" class="form-control" id="citaFecha" v-model="cita.fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="citaHora">Hora de la cita</label>
                        <input type="time" class="form-control" id="citaHora" v-model="cita.hora" required>
                    </div>
                    <div class="form-group">
                        <label for="citaMotivo">Motivo de la cita</label>
                        <input type="text" class="form-control" id="citaMotivo" v-model="cita.motivo" required>
                    </div>
                    <div class="form-group">
                        <label for="citaEstado">Estado de la cita</label>
                        <select class="form-control" v-model="cita.estado" required>
                            <option value="" disabled selected>Seleccione estado</option>
                            <option v-for="estado in opcionesEstado" :value="estado.value">{{ estado.label }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="citaPacienteId">Paciente</label>
                        <select class="form-control" v-model="cita.paciente_id" required>
                            <option value="" disabled selected>Seleccione paciente</option>
                            <option v-for="paciente in pacientes" :value="paciente.id">{{ paciente.nombre }} {{ paciente.apellido }}</option>
                        </select>
                        <!-- <input type="number" class="form-control" id="citaPacienteId" v-model="cita.paciente_id" required> -->
                    </div>
                    <div class="form-group">
                        <label for="citaUserId">Dentista</label>
                        <!-- <input type="number" class="form-control" id="citaUserId" v-model="cita.user_id" required> -->
                        <select class="form-control" v-model="cita.doctor_id" required>
                            <option value="" disabled selected>Seleccione dentista</option>
                            <option v-for="doctor in doctores" :value="doctor.id">{{ doctor.nombre}}</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="resetCita">Cerrar</button>
                        <button type="submit" class="btn btn-primary">{{btnTitle}}</button>
                        <button type="button" class="btn btn-danger" @click="eliminarCita">Elminar Cita</button>
                        <button type="button" class="btn btn-info" @click="atenderCita">Atender Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</template>
<template>
    <div>
        <h1 style="text-align: center; font-weight: bold; font-size: 2rem">
            Citas Reservadas
        </h1>
        <DataTable ref="dt" :value="publicas" v-model="search" datakey="id" :paginator="true" :rows="10"
            :filters="filters"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Mostrar {first} de {last} de {totalRecords} publicas" size="small"
            tableStyle="min-width: 50rem">
            <Column field="fecha" header="Fecha"></Column>
            <Column field="hora" header="Hora"></Column>
            <Column field="telefono" header="Telefono"></Column>
            <Column field="nombre" header="Nombre"></Column>
            <Column field="motivo" header="Motivo"></Column>
            <Column :exportable="false">
                <template #body="slotProps">
                    <Button icon="pi pi-trash" outlined rounded class="mr-2"
                        @click="deletePublica(slotProps.data)"></Button>
                    <Button icon="pi pi-file" outlined rounded class="mr-2"
                        @click="verExpediente(slotProps.data)"></Button>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useToast } from "primevue/usetoast";
import axios from "axios"; // Asegúrate de importar axios

export default {
    data() {
        return {
            publicas: [],
            publica: {
                id: null,
                fecha: null,
                hora: null,
                user: "",
                motivo: "",
            },
            search: "",
            submitted: false,
            publicaDialog: false,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            },
        };
    },
    computed: {
        formTitle() {
            return this.publica.id == null ? "Cancelar Cita" : "Editar Cita";
        },
        btnTitle() {
            return this.publica.id == null ? "Cancelar" : "Actualizar";
        },
    },
    methods: {
        verificarAccion(status, action, message) {
            console.log(`Acción: ${action}, Estado: ${status}, Mensaje: ${message}`);
        },
        async fetchPublicas() {
            try {
                const response = await axios.get(`/api/publicas/mostrar`);
                this.publicas = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        openNew() {
            this.publica = {};
            this.submitted = false;
            this.publicaDialog = true;
        },
        hideDialog() {
            this.publicaDialog = false;
            this.submitted = false;
        },
        eliminarCita(publica) {
            this.publica = { ...publica };
            this.publicaDialog = true;
        },
        verExpediente(publica) {
            window.location.href = `/expediente/${publica.id}`;
        },
        async deletePublica(publica) {
            try {
                const confirmed = await this.$swal.fire({
                    title: '¿Deseas cancelar esta cita?',
                    text: "No podrás revertir la acción",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SI',
                    cancelButtonText: 'NO',
                });

                if (confirmed.isConfirmed) {
                    if (!publica.id) {
                        throw new Error('ID de la cita no disponible');
                    }

                    const response = await axios.delete(`/api/publicas/${publica.id}`);
                    this.verificarAccion(null, response.status, 'del', response.data.message);

                    // Mensaje de éxito
                    this.$swal.fire({
                        title: 'Éxito',
                        text: 'La cita ha sido cancelada con éxito.',
                        icon: 'success',
                    });

                    // Refresca la lista de citas
                    await this.fetchPublicas();
                }
            } catch (error) {
                console.error('Error cancelando la cita:', error);
                this.$swal.fire({
                    title: 'Error',
                    text: 'No se pudo cancelar la cita. Intenta de nuevo más tarde.',
                    icon: 'error',
                });
            }
        }
    },


    mounted() {
        this.fetchPublicas();
    },
};
</script>

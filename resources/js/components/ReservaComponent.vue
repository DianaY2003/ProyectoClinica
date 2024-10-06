<template>
    <div>
        <h1 style="text-align: center; font-weight: bold; font-size: 2rem;">Reservas</h1>
        <DataTable
            ref="dt"
            :value="publicas"
            v-model="search"
            datakey="id"
            :paginator="true"
            :rows="10"
            :filters="filters"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25]"
            currentPageReportTemplate="Mostrar {first} de {last} de {totalRecords} publicas"
            size="small"
            tableStyle="min-width: 50rem"
        >
            <Column field="fecha" header="Fecha"></Column>
            <Column field="hora" header="Hora"></Column>
            <Column field="nombre" header="Nombre"></Column>
            <Column field="motivo" header="Motivo"></Column>
            <Column :exportable="false">
                <template #body="slotProps">
                    <Button
                        icon="pi pi-trash"
                        outlined
                        rounded
                        class="mr-2"
                        @click="deletePublica(slotProps.data)"
                    />
                    <Button
                        icon="pi pi-file"
                        outlined
                        rounded
                        class="mr-2"
                        @click="verExpediente(slotProps.data)"
                    />
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
        async deletePublica(doctor) {
            try {
                const confirmed = await this.$swal.fire({
                    title: 'Seguro/a de eliminar esta cita?',
                    text: "No podras revertir la accion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SI',
                    cancelButtonText: 'NO',
                });
                if (confirmed.isConfirmed) {
                    const response = await axios.delete(`/api/publicas/${publica.id}`);
                    this.verificarAccion(null, response.status, 'del', response.data.message);
                }
            } catch (error) {
                console.error('Error deleting reservation:', error);
            }
        },
    },
    mounted() {
        this.fetchPublicas();
    },
};
</script>

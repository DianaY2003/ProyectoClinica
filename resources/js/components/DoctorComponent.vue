<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Nuevo" icon="pi pi-plus" severity="constrats" class="mr-2" @click="openNew" />
                </template>
                <template #end>
                    <IconField iconPosition="left">
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Buscar..." />
                    </IconField>
                </template>
            </Toolbar>

            <DataTable ref="dt" :value="doctores" v-model="search" datakey="id"
                :paginator="true" :rows="10" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="Mostrar {first} de {last} of {totalRecords} doctores" size="small" tableStyle="min-with: 50rem">
                <Column field="nombre" header="Nombre" sortable></Column>
                <Column field="especialidad" header="Especialidad" sortable></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editDoctor(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="deleteDoctor(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- Modal para guardar o actualizar un doctor -->
        <Dialog v-model:visible="doctorDialog" :style="{ width: '550px' }" :header="formTitle" :modal="true" class="p-fluid">
            <div class="formgrid grid row">
                <div class="field col">
                    <label for="nombre">Nombre</label>
                    <InputText id="nombre" v-model="doctor.nombre" required autofocus :class="{'p-invalid': submitted && !doctor.nombre}" />
                    <small class="p-error" v-if="submitted && !doctor.nombre">Nombre es requerido.</small>
                </div>
                <div class="field col">
                    <label for="especialidad">Especialidad</label>
                    <InputText id="especialidad" v-model="doctor.especialidad" required autofocus :class="{'p-invalid': submitted && !doctor.especialidad}" />
                    <small class="p-error" v-if="submitted && !doctor.especialidad">Especialidad es requerido.</small>
                    
                </div>
            </div>

            <template #footer>
                <Button label="Cancelar" icon="pi pi-times" text @click="hideDialog" />
                <Button :label="btnTitle" icon="pi pi-check" text @click="saveOrUpdate" />
            </template>
        </Dialog>
    </div>
</template>

<script>
     import {ref, onMounted} from 'vue';
     import {FilterMatchMode} from 'primevue/api';
     import {useToast} from 'primevue/usetoast';
     import Swal from 'sweetalert2';

export default {
    data() {
        return {
            doctores: [],
            doctor: {
                id: null,
                nombre: "",
                especialidad: ""
            },
            search: '',
            submitted: false,
            doctorDialog: false,
            editedDoctor: -1,
            filters: ref({
                'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
            })
        }
    },
    computed: {
        formTitle() {
            return this.doctor.id == null ? "Agregar Doctor" : "Actualizar Doctor";
        },
        btnTitle() {
            return this.doctor.id == null ? "Guardar" : "Actualizar";
        }
    },
    methods: {
        async fetchDoctores() {
            try {
                const response = await axios.get('/api/doctores');
                this.doctores = response.data;
            } catch (error) {
                console.error('Error fetching doctores:', error);
            }
        },
        async saveOrUpdate() {
    this.submitted = true;
    if (this.doctor.nombre.trim() && this.doctor.especialidad) {
        try {
            let response;
            if (this.doctor.id == null) {
                // Crear nuevo doctor
                response = await axios.post('/api/doctores', this.doctor);
                if (response.status === 201) {
                    this.doctores.unshift(response.data); // Agrega el nuevo doctor
                    this.verificarAccion(response.data, response.status, 'add', response.data.message);
                }
            } else {
                // Actualizar doctor existente
                response = await axios.put(`/api/doctores/${this.doctor.id}`, this.doctor);
                if (response.status === 200) {
                    const index = this.doctores.findIndex(d => d.id === this.doctor.id);
                    if (index !== -1) {
                        this.doctores.splice(index, 1, response.data); // Actualiza el doctor en la lista
                    }
                    this.verificarAccion(response.data, response.status, 'upd', response.data.message);
                }
            }
            this.doctorDialog = false;
            this.doctor = { id: null, nombre: "", especialidad: "" }; // Resetear el formulario
        } catch (error) {
            console.error('Error saving or updating doctor:', error);
            this.$swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar la información del doctor.' });
        }
    }
},

        
 

        async deleteDoctor(doctor) {
            try {
                const confirmed = await this.$swal.fire({
                    title: 'Seguro/a de eliminar este doctor?',
                    text: "No podras revertir la accion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SI',
                    cancelButtonText: 'NO',
                });
                if (confirmed.isConfirmed) {
                    const response = await axios.delete(`/api/doctores/${doctor.id}`);
                    this.verificarAccion(null, response.status, 'del', response.data.message);
                }
            } catch (error) {
                console.error('Error deleting doctor:', error);
            }
        },
        openNew() {
            this.doctor = {};
            this.submitted = false;
            this.doctorDialog = true;
        },
        hideDialog() {
            this.doctorDialog = false;
            this.submitted = false;
        },
        editDoctor(doctor) {
            this.doctor = { ...doctor };
            this.doctorDialog = true;
            this.editedDoctor = this.doctores.indexOf(doctor);
        },
        verificarAccion(doctor, statusCode, accion, message) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position:'top-right',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
            switch (accion) {
                case 'add':
                    this.doctores.unshift(doctor);
                    Swal.fire({
                        icon: 'success',
                        'title':message
                    });
                    break;
                case 'upd':
                    Object.assign(me.doctores[me.editedDoctor],doctor);
                    Swal.fire({
                            icon:'success',
                            'title':message
                        });
                    break;
                case 'del':
                    if (statusCode === 205) {
                        this.doctores.splice(this.editedDoctor, 1);
                        Swal.fire({
                                icon: 'success',
                                'title': 'doctor Eliminado...!'
                            });
                    } else {
                        this.$swal.fire({
                            icon: 'error',
                            text: message
                        });
                    }
                    break;
                default:
                    break;
            }
            this.fetchDoctores();
        }
    },
    async mounted() {
        await this.fetchDoctores();
    }
}
</script>


<script setup>

/*

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import { ProductService } from '@/service/ProductService';

onMounted(() => {
    ProductService.getProducts().then((data) => (products.value = data));
});

const toast = useToast();
const dt = ref();
const products = ref();
const productDialog = ref(false);
const deleteProductDialog = ref(false);
const deleteProductsDialog = ref(false);
const product = ref({});
const selectedProducts = ref();
const filters = ref({
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
});
const submitted = ref(false);
const statuses = ref([
    {label: 'INSTOCK', value: 'instock'},
    {label: 'LOWSTOCK', value: 'lowstock'},
    {label: 'OUTOFSTOCK', value: 'outofstock'}
]);

const formatCurrency = (value) => {
    if(value)
        return value.toLocaleString('en-US', {style: 'currency', currency: 'USD'});
    return;
};
const openNew = () => {
    product.value = {};
    submitted.value = false;
    productDialog.value = true;
};
const hideDialog = () => {
    productDialog.value = false;
    submitted.value = false;
};
const saveProduct = () => {
    submitted.value = true;

    if (product.value.name.trim()) {
        if (product.value.id) {
            product.value.inventoryStatus = product.value.inventoryStatus.value ? product.value.inventoryStatus.value : product.value.inventoryStatus;
            products.value[findIndexById(product.value.id)] = product.value;
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Updated', life: 3000});
        }
        else {
            product.value.id = createId();
            product.value.code = createId();
            product.value.image = 'product-placeholder.svg';
            product.value.inventoryStatus = product.value.inventoryStatus ? product.value.inventoryStatus.value : 'INSTOCK';
            products.value.push(product.value);
            toast.add({severity:'success', summary: 'Successful', detail: 'Product Created', life: 3000});
        }

        productDialog.value = false;
        product.value = {};
    }
};
const editProduct = (prod) => {
    product.value = {...prod};
    productDialog.value = true;
};
const confirmDeleteProduct = (prod) => {
    product.value = prod;
    deleteProductDialog.value = true;
};
const deleteProduct = () => {
    products.value = products.value.filter(val => val.id !== product.value.id);
    deleteProductDialog.value = false;
    product.value = {};
    toast.add({severity:'success', summary: 'Successful', detail: 'Product Deleted', life: 3000});
};
const findIndexById = (id) => {
    let index = -1;
    for (let i = 0; i < products.value.length; i++) {
        if (products.value[i].id === id) {
            index = i;
            break;
        }
    }

    return index;
};
const createId = () => {
    let id = '';
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for ( var i = 0; i < 5; i++ ) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return id;
}
const exportCSV = () => {
    dt.value.exportCSV();
};
const confirmDeleteSelected = () => {
    deleteProductsDialog.value = true;
};
const deleteSelectedProducts = () => {
    products.value = products.value.filter(val => !selectedProducts.value.includes(val));
    deleteProductsDialog.value = false;
    selectedProducts.value = null;
    toast.add({severity:'success', summary: 'Successful', detail: 'Products Deleted', life: 3000});
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'INSTOCK':
            return 'success';

        case 'LOWSTOCK':
            return 'warning';

        case 'OUTOFSTOCK':
            return 'danger';

        default:
            return null;
    }
};

*/

</script>
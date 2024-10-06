<template>
    <div>
        <div class="card">
            <Toolbar class="mb-4">
                <template #start>
                    <Button label="Nuevo" icon="pi pi-plus" class="mr-2" @click="openNew" />
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

            <DataTable ref="dt" :value="usuarios" v-model="search" datakey="id"
                :paginator="true" :rows="10" :filters="filters"
                paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown" :rowsPerPageOptions="[5,10,25]"
                currentPageReportTemplate="Mostrar {first} de {last} of {totalRecords} usuarios" size="small" tableStyle="min-with: 50rem">
                <Column field="name" header="Nombre" sortable></Column>
                <Column field="email" header="Email"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" outlined rounded class="mr-2" @click="editUsuario(slotProps.data)" />
                        <Button icon="pi pi-trash" outlined rounded severity="danger" @click="deleteUsuario(slotProps.data)" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="usuarioDialog" :style="{width: '550px'}" :header="formTitle" :modal="true" class="p-fluid">
            <div class="formgrid grid">
                <div class="field col">
                    <label for="name">Nombre</label>
                    <InputText id="name" v-model="usuario.name" required :class="{'p-invalid': submitted && !usuario.name}" />
                    <small class="p-error" v-if="submitted && !usuario.name">Nombre es requerido.</small>
                </div>
                <div class="field col">
                    <label for="email">Email</label>
                    <InputText id="email" v-model="usuario.email" required :class="{'p-invalid': submitted && !usuario.email}" />
                    <small class="p-error" v-if="submitted && !usuario.email">Email es requerido.</small>
                </div>
                <div class="field col">
                    <label for="password">Contraseña</label>
                    <div class="p-inputgroup">
                        <InputText id="password" v-model="usuario.password" :type="showPassword ? 'text' : 'password'" :class="{'p-invalid': submitted && !usuario.password}" />
                        <Button icon="pi" :icon="showPassword ? 'pi pi-eye-slash' : 'pi pi-eye'" @click="toggleShowPassword" />
                    </div>
                    <small class="p-error" v-if="submitted && !usuario.password">Contraseña es requerida.</small>
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
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';

export default {
    data() {
        return {
            usuarios: [],
            usuario: {
                id: null,
                name: '',
                email: '',
                password: ''
            },
            search: '',
            submitted: false,
            usuarioDialog: ref(false),
            showPassword: false
        };
    },
    computed: {
        formTitle() {
            return this.usuario.id == null ? "Agregar Usuario" : "Actualizar Usuario";
        },
        btnTitle() {
            return this.usuario.id == null ? "Guardar" : "Actualizar";
        }
    },
    methods: {
        async fetchUsuarios() {
            try {
                const response = await axios.get(`/api/usuarios`);
                this.usuarios = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        openNew() {
            this.usuario = {
                id: null,
                name: '',
                email: '',
                password: ''
            };
            this.submitted = false;
            this.usuarioDialog = true;
        },
        hideDialog() {
            this.usuarioDialog = false;
            this.submitted = false;
        },
        editUsuario(usuario) {
            this.usuario = { ...usuario, password: '' };
            this.usuarioDialog = true;
        },
        async saveOrUpdate() {
            this.submitted = true;

            if (!this.usuario.name || !this.usuario.email || !this.usuario.password) {
                return;
            }

            const action = this.usuario.id == null ? "add" : "upd";

            try {
                if (action == "add") {
                    const response = await axios.post(`/api/usuarios`, this.usuario);
                    if (response.status === 201) {
                        this.verificarAccion(response.data, response.status, action, 'Usuario creado exitosamente');
                    }
                } else {
                    const response = await axios.put(`/api/usuarios/${this.usuario.id}`, this.usuario);
                    if (response.status === 200) {
                        this.verificarAccion(response.data, response.status, action, 'Usuario actualizado exitosamente');
                    }
                }
                this.usuarioDialog = false;
                this.usuario = {};
                this.submitted = false;
            } catch (error) {
                console.error(error);
            }
        },
        async deleteUsuario(usuario) {
            let me = this;
            this.$swal.fire({
                title: 'Seguro/a de eliminar este registro?',
                text: "No podras revertir la accion",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'SI',
                cancelButtonText: 'NO',
            }).then((result) =>{
                if(result.value){
                    me.editedUsuario = me.usuarios.indexOf(usuario);
                    this.axios.delete(`/api/usuarios/${usuario.id}`)
                    .then(response => {
                        me.verificarAccion(null,response.status,"del",response.data.message);
                    }).catch(errors =>{
                        console.log(errors)
                    })
                }
            })
        },
        toggleShowPassword() {
            this.showPassword = !this.showPassword;
        },
        verificarAccion(usuario, statusCode, accion, message) {
            let me = this;
            switch (accion) {
                case "add":
                    me.usuarios.unshift(usuario);
                    this.$swal.fire({
                        icon: 'success',
                        title: message
                    });
                    break;
                case "upd":
                    const index = me.usuarios.findIndex(u => u.id === usuario.id);
                    if (index !== -1) {
                        me.usuarios[index] = usuario;
                    }
                    this.$swal.fire({
                        icon: 'success',
                        title: message
                    });
                    break;
                case "del":
                    if (statusCode == 200) {
                        me.usuarios.splice(me.editedUsuario, 1);
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Usuario eliminado exitosamente'
                        });
                    } else {
                        this.$swal.fire({
                            icon: 'error',
                            text: 'No se puede eliminar este usuario'
                        });
                    }
                    break;
            }
            this.fetchUsuarios();
        }
    },
    mounted() {
        this.fetchUsuarios();
    }
};

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS }
});
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
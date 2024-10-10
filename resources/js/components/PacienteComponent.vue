<template>
  <div>
    <div class="card">
      <Toolbar class="mb-4">
        <template #start>
          <Button
            label="Nuevo"
            icon="pi pi-plus"
            severity="constrats"
            class="mr-2"
            @click="OpenNew"
          />
          <a href="/reportes/pacientes" target="_blank">
            <Button label="Generar Reporte" class="mr-2" />
          </a>
        </template>
        <template #end>
          <IconField iconPosition="left">
            <InputIcon>
              <i class="pi pi-search" />
            </InputIcon>
            <InputText
              v-model="filters['global'].value"
              placeholder="Buscar..."
            />
          </IconField>
        </template>
      </Toolbar>

      <DataTable
        ref="dt"
        :value="pacientes"
        v-model="search"
        datakey="id"
        :paginator="true"
        :rows="10"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Mostrar {first} de {last} of {totalRecords} pacientes"
        size="small"
        tableStyle="min-with: 50rem"
      >
        <Column field="nombre" header="Nombre" sortable></Column>
        <Column field="apellido" header="Apellido">
          <!--
                       <template #body="slotProps">
                       {{formatCurrency(slotProps.data.precio)}}
                    </template>-->
        </Column>
        <Column field="dui" header="Dui"></Column>
        <Column field="telefono" header="Telefono"></Column>
        <Column field="fecha_nacimiento" header="Fecha Nacimiento"></Column>
        <Column field="sexo" header="Genero"></Column>
        <Column field="estado_civil" header="Estado Civil"></Column>
        <Column field="distrito.nombre" header="Distrito"></Column>
        <Column :exportable="false">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editPaciente(slotProps.data)"
            />
            <Button
              icon="pi pi-file"
              outlined
              rounded
              class="mr-2"
              @click="verExpediente(slotProps.data)"
            />
            <!--imagenes-->
            <Button
              icon="pi pi-images"
              outlined
              rounded
              class="mr-2"
              severity="info"
              @click="viewImages(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>

    <!-- Formulario modal para guardar o actualizar un paciente-->

    <Dialog
      v-model:visible="pacienteDialog"
      :style="{ width: '550px' }"
      :header="formTitle"
      :modal="true"
      class="p-fluid"
    >
      <div class="formgrid grid row">
        <div class="field col">
          <label for="nombre">Nombre</label>
          <InputText
            id="nombre"
            v-model="paciente.nombre"
            required="true"
            autofocus
            :class="{ 'p-invalid': submitted && !paciente.nombre }"
          />
          <small class="p-error" v-if="submitted && !paciente.nombre"
            >Nombre es requerido.</small
          >
        </div>
        <div class="field col">
          <label for="apellido">Apellido</label>
          <InputText
            id="apellido"
            v-model="paciente.apellido"
            required="true"
            :class="{ 'p-invalid': submitted && !paciente.apellido }"
          />
          <small class="p-error" v-if="submitted && !paciente.apellido"
            >Apellido es requerido.</small
          >
        </div>
      </div>

      <div class="formgrid grid row">
        <div class="field col">
          <label for="dui">DUI</label>
          <!-- <InputText id="dui" v-model="paciente.dui" required="true" autofocus :class="{'p-invalid': submitted && !paciente.dui}" /> -->
          <InputText
            id="dui"
            v-model="paciente.dui"
            :class="{ 'p-invalid': submitted && !paciente.dui }"
            required
            maxlength="9"
            minlength="9"
            autofocus
          />
          <small class="p-error" v-if="submitted && !paciente.dui"
            >DUI es requerido.</small
          >
        </div>
        <div class="field col">
          <label for="telefono">Telefono</label>
          <!-- <InputNumber id="telefono" v-model.trim="paciente.telefono"  integeronly :class="{'p-invalid': submitted && !paciente.telefono}"/> -->
          <InputText
            id="telefono"
            v-model="paciente.telefono"
            :class="{ 'p-invalid': submitted && !paciente.telefono }"
            required
            maxlength="8"
            minlength="8"
            autofocus
          />
          <small class="p-error" v-if="submitted && !paciente.telefono"
            >Telefono es requerido.</small
          >
        </div>
      </div>
      <div class="formgrid grid row">
        <div class="field col">
          <label for="fecha_nacimiento">Fecha Nacimiento</label>
          <Calendar
            id="fecha_nacimiento"
            v-model="paciente.fecha_nacimiento"
            :readonly-input="true"
            showIcon
          />
        </div>
        <div class="field col">
          <label for="sexo">Genero</label>
          <Dropdown
            v-model="paciente.sexo"
            :options="opcionesGenero"
            optionLabel="label"
            optionValue="value"
            placeholder="Seleccionar Genero"
          />
        </div>
      </div>
      <div class="formgrif grid row">
        <div class="field col">
          <label for="estado_civil">Estado Civil</label>
        
          <Dropdown
            v-model="paciente.estado_civil"
            :options="opcionesEstadoCivil"
            optionLabel="label"
            optionValue="value"
            placeholder="Seleccionar estado civil"
          />
        </div>
        <div class="field col">
          <label for="categoria">Distrito</label>
          <Dropdown
            v-model="paciente.distrito_id"
            :options="distritos"
            optionLabel="nombre"
            optionValue="id"
            placeholder="Seleccione distrito"
            class="w-full md:w-14rem"
          >
          </Dropdown>
          <small class="p-error" v-if="submitted && !paciente.distrito_id"
            >Seleccione un distrito.</small
          >
        </div>
        <div class="field">
          <label for="imagenes">Imagenes</label>
          <input
            type="file"
            class="form-control"
            multiple
            accept="image/*"
            @change="getImages"
          />
        </div>
      </div>

      <template #footer>
        <Button label="Cancelar" icon="pi pi-items" text @click="hideDialog" />
        <Button
          :label="btnTitle"
          icon="pi pi-check"
          text
          @click="saveOrUpdate"
        />
      </template>
    </Dialog>
    <!-- Dialog para mostrar imágenes -->
    <Dialog
      v-model:visible="mostrarImagesDialog"
      :style="{ width: '550px' }"
      header="Imágenes del Paciente"
      :modal="true"
      class="p-fluid"
    >
     <Carousel
            :value="imagenes"
            :numVisible="1"
            :numScroll="1"
            orientation="vertical"
            verticalViewPortHeight="330px"
            containerClass="flex items-center"
        >
            <template #item="slotProps">
                <div class="relative mx-auto">
                    <img
                        :src="'/images/pacientes/' + slotProps.data.nombre"
                        :alt="slotProps.data.nombre"
                        class="w-full rounded"
                    />
                </div>
            </template>
        </Carousel>
    </Dialog>
  </div>
</template>
<script>

import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useToast } from "primevue/usetoast";
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      pacientes: [],
      distritos: [],
      opcionesEstadoCivil: [
        { label: "Soltero/a", value: "S" },
        { label: "Casado/a", value: "C" },
        { label: "Divorciado/a", value: "D" },
        { label: "Viudo/a", value: "V" },
        { label: "Unión libre", value: "U" },
      ],
      opcionesGenero: [
        { label: "Masculino", value: "M" },
        { label: "Femenino", value: "F" },
      ],
      paciente: {
        id: null,
        nombre: "",
        apellido: "",
        dui: "",
        telefono: "",
        fecha_nacimiento: "",
        sexo: "",
        estado_civil: "",
        distrito_id: null,
      },
      editedPaciente: -1, //almacenar un indice de una categoria en un arreglo
      search: "",
      submitted: false,
      pacienteDialog: ref(false),
      mostrarImagesDialog: ref(false),
       imagenes: [],
        
    };
  },
  computed: {
    formTitle() {
      return this.paciente.id == null
        ? "Agregar Paciente"
        : "Actualizar Paciente";
    },
    btnTitle() {
      return this.paciente.id == null ? "Guardar" : "Actualizar";
    },
  },
  methods: {
    async fetchpacientes() {
      await this.axios
        .get(`/api/pacientes`)
        .then((response) => {
          this.pacientes = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async fetchDistritos() {
      await this.axios
        .get(`/api/distritos`)
        .then((response) => {
          this.distritos = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    OpenNew() {
      this.paciente = {};
      this.submitted = false;
      this.pacienteDialog = true;
    },
    hideDialog() {
      this.pacienteDialog = false;
      this.submitted = false;
    },
    //metodo para carar el dialog con paciente a editar
    editPaciente(paciente) {
      this.paciente = { ...paciente };
      this.pacienteDialog = true;
      this.editedPaciente = this.pacientes.indexOf(paciente);
    },
    verExpediente(paciente) {
      window.location.href = `/expediente/${paciente.id}`;
    },
    createFormData() {
      let formData = new FormData();
      formData.append("nombre", this.paciente.nombre);
      formData.append("apellido", this.paciente.apellido);
      formData.append("dui", this.paciente.dui);
      formData.append("telefono", this.paciente.telefono);

      const fechaNacimiento = new Date(this.paciente.fecha_nacimiento);
      const fechaFormateada = fechaNacimiento.toISOString().split("T")[0];
      formData.append("fecha_nacimiento", fechaFormateada);

      formData.append("sexo", this.paciente.sexo);
      formData.append("estado_civil", this.paciente.estado_civil);
      formData.append("distrito_id", this.paciente.distrito_id);
      // Agregar imágenes al formData
      if (this.imagenes != null) {
        for (let i = 0; i < this.imagenes.length; i++) {
          formData.append("imagenes[]", this.imagenes[i]);
        }
      }
      // Log para depurar
      for (let pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
      }
      return formData;
    },
    getImages(event) {
      let files =  event.target.files;
      this.imagenes = files;
    },
    
    viewImages(paciente) {
            this.imagenes = paciente.imagenes; // Asigna las imágenes del paciente
            this.mostrarImagesDialog = true; // Abre el diálogo
        },

   async saveOrUpdate() {
    this.submitted = true;

    if (this.paciente.nombre.trim()) {
        let accion = this.paciente.id == null ? "add" : "upd";
        const headers = {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        };

        try {
            let response;
            if (accion === "add") {
                response = await this.axios.post(`/api/pacientes`, this.createFormData(), headers);
                if (response.status === 201) {
                    this.verificarAccion(response.data.data, response.status, accion, response.data.message);
                }
            } else {
                response = await this.axios.put(`/api/pacientes/${this.paciente.id}`, this.paciente);
                if (response.status === 202) {
                    this.verificarAccion(response.data.data, response.status, accion, response.data.message);
                }
            }
            this.pacienteDialog = false;
            this.paciente = {};
        } catch (error) {
            console.error(error);
            if (error.response) {
                console.log(error.response.data);
                this.$swal.fire({
                    title: "Error",
                    text: error.response.data.message || "Ocurrió un error al guardar los datos.",
                    icon: "error",
                });
            } else {
                this.$swal.fire({
                    title: "Error de conexión",
                    text: "No se puede conectar al servidor.",
                    icon: "error",
                });
            }
        }
    }
},


    verificarAccion(paciente, statusCode, accion, message) {
      let me = this;
      const Toast = this.$swal.mixin({
        Swal: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      });
      switch (accion) {
        case "add":
          //agregamos al principio del arreglo pacientes
          me.pacientes.unshift(paciente.original);
          Swal.fire({
            icon: "success",
            title: message,
          });
          break;
        case "upd":
          Object.assign(me.pacientes[me.editedPaciente], paciente);
          Swal.fire({
            icon: "success",
            title: message,
          });
          break;
      }
      this.fetchpacientes();
    },
  },
  mounted() {
    this.fetchpacientes();
    this.fetchDistritos();
  },
};
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
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
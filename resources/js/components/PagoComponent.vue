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
        :value="pagos"
        v-model="search"
        datakey="id"
        :paginator="true"
        :rows="10"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Mostrar {first} de {last} of {totalRecords} registros"
        size="small"
        tableStyle="min-with: 50rem"
      >
        <!--llaves foraneas-->
        <Column field="paciente.nombre" header="Paciente"></Column>
        <!--Relacion con tratamientos momentanea-->
        <Column field="tratamiento.nombre" header="Tratamiento"></Column>
        <Column field="tipo_pago" header="Tipo de pago"></Column>
        <Column field="banco" header="Banco"></Column>
        <Column field="fecha_pago" header="Fecha De Pago"></Column>
        <Column field="precio" header="Precio" sortable></Column>
        <Column :exportable="false">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              outlined
              rounded
              class="mr-2"
              @click="editPago(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>
    <!-- Formulario modal para guardar o actualizar pago-->

    <Dialog
      v-model:visible="pagoDialog"
      :style="{ width: '550px' }"
      :header="formTitle"
      :modal="true"
      class="p-fluid"
    >
      <div class="formgrif grid row">
        <div class="field col">
          <label for="categoria">Paciente</label>
          <Dropdown
            v-model="pago.paciente_id"
            :options="pacientes"
            optionLabel="nombre"
            optionValue="id"
            placeholder="Seleccione paciente"
            class="w-full md:w-14rem"
          >
          </Dropdown>
          <small class="p-error" v-if="submitted && !pago.paciente_id"
            >Seleccione un paciente.</small
          >
        </div>
        <div class="field col">
          <label for="categoria">Tratamiento</label>
          <Dropdown
            v-model="pago.tratamiento_id"
            :options="tratamientos"
            optionLabel="nombre"
            optionValue="id"
            placeholder="Seleccione tratamiento"
            class="w-full md:w-14rem"
          >
          </Dropdown>
          <small class="p-error" v-if="submitted && !pago.tratamiento_id"
            >Tratamiento requerido.</small
          >
        </div>
      </div>
      <div class="field col">
        <label for="tipo_pago">Tipo de Pago</label>
        <Dropdown
          v-model="pago.tipo_pago"
          :options="opcionesTipoPagos"
          optionLabel="label"
          optionValue="value"
          placeholder="Seleccionar un tipo de pago"
        />
      </div>
      <!--esconder campo-->
      <div class="field col" v-if="!(isEfectivo || isTarjeta)">
        <label for="banco">Banco</label>
        <Dropdown
          v-model="pago.banco"
          :options="opcionesBanco"
          optionLabel="label"
          optionValue="value"
          placeholder="Seleccionar un Banco"
        />
        <small class="p-error" v-if="submitted && !pago.banco"
          >Banco es requerido.</small
        >
      </div>

      <div class="field col">
        <label for="fecha_pago">Fecha de pago</label>
        <Calendar
          id="fecha_pago"
          v-model="pago.fecha_pago"
          :readonly-input="true"
          showIcon
        />
      </div>

      <div class="field col">
        <label for="precio">Precio</label>
        <InputNumber
          id="precio"
          v-model="pago.precio"
          :class="{ 'p-invalid': submitted && !pago.precio }"
          mode="currency"
          currency="USD"
          locale="en-US"
          required
        />
        <small class="p-error" v-if="submitted && !pago.precio"
          >Precio es requerido.</small
        >
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
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useToast } from "primevue/usetoast";
import Swal from 'sweetalert2';


export default {
  data() {
    return {
      pagos: [],
      pacientes: [],
      tratamientos: [],
      opcionesTipoPagos: [
        { label: "Efectivo", value: "Efectivo" },
        { label: "Transferencia", value: "Transferencia" },
        { label: "Tarjeta", value: "Tarjeta" },
      ],
      opcionesBanco: [
        { label: "Banco Agricola", value: "Banco Agricola" },
        { label: "BAC", value: "BAC" },
      ],
      pago: {
        id: null,
        paciente_id: null,
        tratamiento_id: null,
        tipo_pago: "",
        banco: "",
        fecha_pago: "",
        precio: null,
      },
      editedPaciente: -1, //almacenar un indice de una categoria en un arreglo
      search: "",
      submitted: false,
      pagoDialog: ref(false),
    };
  },
  computed: {
    formTitle() {
      return this.pago.id == null ? "Agregar Pago" : "Actualizar Pago";
    },
    btnTitle() {
      return this.pago.id == null ? "Guardar" : "Actualizar";
    },
    isEfectivo() {
      return this.pago.tipo_pago === "Efectivo"; //  propiedad para ocultar opcion de banco
    },
    isTarjeta() {
      return this.pago.tipo_pago === "Tarjeta";
    },
  },
  methods: {
    async fetchpagos() {
      await this.axios
        .get('/api/pagos')
        .then((response) => {
          this.pagos = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async fetchPacientes() {
      await this.axios
        .get('/api/pacientes')
        .then((response) => {
          this.pacientes = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async fetchTratamientos() {
      await this.axios
        .get('/api/tratamientos')
        .then((response) => {
          this.tratamientos = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    OpenNew() {
      this.pago = {};
      this.submitted = false;
      this.pagoDialog = true;
    },
    hideDialog() {
      this.pagoDialog = false;
      this.submitted = false;
    },
    //metodo para carar el dialog con el pago a editar
    editPago(pago) {
      this.pago = { ...pago };
      this.pagoDialog = true;
      this.editedPago = this.pagos.indexOf(pago);
    },
    createFormData() {
      let formData = new FormData();
      formData.append("paciente_id", this.pago.paciente_id);
      formData.append("tratamiento_id", this.pago.tratamiento_id);
      formData.append("tipo_pago", this.pago.tipo_pago);
      formData.append("banco", this.pago.banco);

      const fechaPago = new Date(this.pago.fecha_pago);
      const fechaFormateada = fechaPago.toISOString().split("T")[0];
      formData.append("fecha_pago", fechaFormateada);
      formData.append("precio", this.pago.precio);

      return formData;
    },
    async saveOrUpdate() {
      this.submitted = true;

      // Validación
      const isBancoRequired =
        this.pago.tipo_pago !== "Efectivo" && this.pago.tipo_pago !== "Tarjeta";
      const valid =
        this.pago.paciente_id &&
        this.pago.tratamiento_id &&
        this.pago.tipo_pago &&
        (!isBancoRequired || this.pago.banco) &&
        this.pago.precio;

      if (!valid) {
        console.error("Todos los campos deben estar definidos.");
        return;
      }

      try {
        let response;
        const headers = { "Content-Type": "multipart/form-data" };

        if (!this.pago.id) {
          // Crear nuevo pago
          response = await this.axios.post(
            '/api/pagos',
            this.createFormData(),
            { headers }
          );
        } else {
          // Actualizar pago existente
          const updateData = { ...this.pago };
          if (!isBancoRequired) delete updateData.banco; // Remover banco si no es requerido

          response = await this.axios.put(
           ` /api/pagos/${this.pago.id}`,
            updateData
          );
        }

        if (response.status === 200 || response.status === 201) {
          this.verificarAccion(
            response.data,
            response.status,
            this.pago.id ? "upd" : "add",
            response.data.message
          );
        }

        this.hideDialog();
        this.pago = {}; // Limpiar formulario
      } catch (error) {
        const errorMessage =
          error.response?.data?.message ||
          "Ocurrió un error. Intente nuevamente.";
        this.$swal.fire({ title: "Error", text: errorMessage, icon: "error" });
      }
    },

    verificarAccion(pago, statusCode, accion, message) {
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
          //agregamos al principio del arreglo pagos
          me.pagos.unshift(pago.original);
          Swal.fire({
            icon: "success",
            title: message,
          });
          break;
        case "upd":
          Object.assign(me.pagos[me.editedPago], pago);
          Swal.fire({
            icon: "success",
            title: message,
          });
          break;
      }
      this.fetchpagos();
    },
  },
  mounted() {
    this.fetchpagos();
    this.fetchPacientes();
    this.fetchTratamientos();
  },
};
const filters = ref({
  global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const formatCurrency = (value) => {
  if (value)
    return value.toLocaleString("en-US", {
      style: "currency",
      currency: "USD",
    });
  return;
};
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

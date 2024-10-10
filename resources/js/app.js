/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

//importaciones de sweetalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import PrimeVue from 'primevue/config';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import Button from 'primevue/button';
import AutoComplete from 'primevue/autocomplete';
import Calendar from 'primevue/calendar';
import Checkbox from 'primevue/checkbox';
import ColorPicker from 'primevue/colorpicker';
import Dropdown from 'primevue/dropdown';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Password from 'primevue/password';
import RadioButton  from 'primevue/radiobutton';
import Textarea  from 'primevue/textarea';
import SplitButton  from 'primevue/splitbutton';
import Toolbar  from 'primevue/toolbar';
import DataTable  from 'primevue/datatable';
import Column  from 'primevue/column';
import ColumnGroup  from 'primevue/columngroup';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';

import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';

import FileUpload from 'primevue/fileupload';
import Carousel from 'primevue/carousel';
import Tooltip from 'primevue/tooltip';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions'
import Tag from 'primevue/tag';
import MegaMenu from 'primevue/megamenu';

        
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

//importando componentes
import AgendaComponent from './components/AgendaComponent.vue';
app.component('agenda-component', AgendaComponent);

import PacienteComponent from './components/PacienteComponent.vue';
app.component('paciente-component', PacienteComponent);

import UsuarioComponent from './components/UsuarioComponent.vue';
app.component('usuario-component', UsuarioComponent);

import TratamientosComponent from './components/TratamientoComponent.vue';
app.component('tratamiento-component', TratamientosComponent);

import DoctorComponent from './components/DoctorComponent.vue';
app.component('doctor-component', DoctorComponent);

import PagoComponent from './components/PagoComponent.vue';
app.component('pago-component', PagoComponent);

import ExpedienteComponent from './components/ExpedienteComponent.vue';
app.component('expediente-component', {
    extends: ExpedienteComponent,
    props: {
      pacienteId: Number  // Define las propiedades que espera el componente
    }
  });

import ConsultaComponent from './components/ConsultaComponent.vue';
app.component('consulta-component', ConsultaComponent);

import ReservaComponent from './components/ReservaComponent.vue';
app.component('reserva-component', ReservaComponent);

import ReportePagos from "./components/ReportePagos.vue";
app.component('reporte-pagos', ReportePagos);

import ReporteCitas from "./components/ReporteCitas.vue";
app.component('reporte-citas', ReporteCitas);


//definiendo variables globales
app.config.globalProperties.axios = axios;
app.use(VueSweetalert2);
app.use(PrimeVue);
app.use(ToastService);

 //agregamos los componentes de PrimeVue
 app.component('Button', Button);
 app.component('AutoComplete', AutoComplete);
 app.component('Calendar', Calendar);
 app.component('Checkbox', Checkbox);
 app.component('ColorPicker', ColorPicker);
 app.component('Dropdown', Dropdown);
 app.component('IconField', IconField);
 app.component('InputIcon', InputIcon);
 app.component('InputMask', InputMask);
 app.component('InputNumber', InputNumber);
 app.component('InputSwitch', InputSwitch);
 app.component('InputText', InputText);
 app.component('MultiSelect', MultiSelect);
 app.component('Password', Password);
 app.component('RadioButton', RadioButton);
 app.component('Textarea', Textarea);
 app.component('SplitButton', SplitButton);
 app.component('DataTable', DataTable);
 app.component('Column', Column);
 app.component('ColumnGroup', ColumnGroup);
 app.component('Row', Row);
 app.component('Toolbar', Toolbar);
 app.component('Dialog', Dialog);
 app.component('Toast', Toast);
 app.component('FileUpload',FileUpload);
 app.component('Carousel',Carousel);
 app.component('DataView',DataView);
 app.component('DataViewLayoutOptions',DataViewLayoutOptions);
 app.component('Tag',Tag);
 app.component('MegaMenu',MegaMenu);
app.mount('#app');

import './bootstrap';

import  {createApp} from 'vue/dist/vue.esm-bundler.js';
import router from './router.js';
import App from './components/App.vue';
import Swal from 'sweetalert2';

const app = createApp(App);
app.config.globalProperties.$swal = Swal;
app.use(router,Swal);
app.mount('#app');





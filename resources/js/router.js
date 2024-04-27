import { createMemoryHistory, createRouter } from 'vue-router'

import HomeView from './components/Home.vue'
import RegisterView from "./components/Register.vue";


const routes = [
    { path: '/', component: HomeView },
    { path: '/register', component: RegisterView },
    { path: '/:pathMatch(.*)*' , component: HomeView}
]

const router = createRouter({
history: createMemoryHistory(),
routes,
})

export default router;

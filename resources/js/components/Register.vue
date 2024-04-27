<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
    components: {
        vSelect
    },
    data() {
        return {
            baseURL: 'https://www.datos.gov.co/resource/xdk5-pm3f.json?',
            departments: [],
            selectedDepartment: 'Seleccione...',
            cities: [],
            selectedCity:'Seleccione...'
        }
    },
    mounted() {
         this.getDepartments();
    },
    methods: {
        async urlGet(baseUrl, params) {
            const {data} = await axios.get(`${baseUrl}${params}`);
            return  data;
        },
        async getDepartments() {
            const params = '$select=departamento&$group=departamento';
            const data = await this.urlGet(this.baseURL, params);
            this.departments = data.map(({departamento}) => departamento);
        },
        async getCities(department) {
            const params = `departamento=${department}`;
            const data = await this.urlGet(this.baseURL, params);
            this.cities = data.map(({municipio}) => municipio);
        }

    },
    watch: {
        selectedDepartment(value) {
           if(value) {
               this.selectedCity = 'Seleccione...';
               this.getCities(value);
           }
        }
    }

}
</script>

<template>
    <div class="login-page bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="mb-3"> Registro </h3>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <form action="" class="row g-4">
                                        <div class="col-6">
                                            <label>Nombre <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Enter Username">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Apellido <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Enter Username">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Cédula <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Enter Username">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Genero <span class="text-danger">*</span></label>
                                            <select class="form-control">
                                                <option selected>Seleccione...</option>
                                                <option value="1">Masculino</option>
                                                <option value="2">Femenino</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label>Departamento <span class="text-danger">*</span></label>
                                            <v-select :options=departments  v-model="selectedDepartment"  ></v-select>

                                        </div>

                                        <div class="col-6">
                                            <label>Ciudad <span class="text-danger">*</span></label>
                                            <v-select :options=cities v-model="selectedCity"  ></v-select>
                                        </div>

                                        <div class="col-12">
                                            <label> Correo Electrónico  <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="email" class="form-control" placeholder="Enter Email">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                                <label class="form-check-label" for="inlineFormCheck">Remember me</label>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4 float-end mt-4">login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="form-right h-100 bg-primary text-white text-center pt-5">
                                    <i class="bi bi-bootstrap"></i>
                                    <h2 class="fs-1">Welcome Back!!!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-end text-secondary mt-3">Bootstrap 5 Login Page Design</p>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>
a {
    text-decoration: none;
}
.login-page {
    width: 100%;
    height: 70vh;
    display: flex;
    align-items: center;
}
.form-right i {
    font-size: 100px;
}
</style>

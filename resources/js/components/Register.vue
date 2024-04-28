<script  setup>
import { Avatar } from 'vue3-avataaars';
</script>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import Swal from "sweetalert2";
import {Factory} from "vue3-avataaars";

export default {
    components: {
        vSelect
    },
    data() {
        return {
            baseURL: 'https://www.datos.gov.co/resource/xdk5-pm3f.json?',
            geners: [
                {name: 'Seleccione...', value: null},
                {name: 'Masculino', value: 'M'},
                {name: 'Femenino', value: 'F'}
            ],
            departments: [
                {name: 'Seleccione...', value: null},
            ],
            cities: [
                {name: 'Seleccione...', value: null},
            ],
            selectedDepartment: null,
            form: {
                name: '',
                lastname: '',
                cc: '',
                email:  '',
                gender: null,
                city: null
            },
            checked: false,
            props: Factory(),
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
            this.departments = data.map(({departamento}) => ({name: departamento, value: departamento}));
        },
        async getCities(department) {
            this.cities = [ {name: 'Seleccione...', value: null}];
            this.form.city = null;
            const params = `departamento=${department}`;
            const data = await this.urlGet(this.baseURL, params);
            this.cities = data.map(({municipio}) => ({name: municipio, value: municipio}));
        },
        alertError(text){

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: text,
            })
        },
        restoreForm() {
            this.form = {
                name: '',
                lastname: '',
                cc: '',
                email:  '',
                phone: '',
                gender: null,
                city: null
            }
            this.checked = false;
            this.selectedDepartment = null;
        },
        validateForm() {
            const {name, lastname,city, cc,gender, email,phone } = this.form;
            if(!name || !lastname || !cc || !email ||!gender || this.selectedDepartment==null || city==null || !phone){
              this.alertError('Todos los campos son obligatorios!');
              return false;
            }
            const emailPattern = /\S+@\S+\.\S+/;
            if(!emailPattern.test(email)) {
                this.alertError('Correo electrónico inválido!')
                return false;
            }
            if(!this.checked) {
                this.alertError('Debe aceptar el tratamiento de datos personales!')
                return false;
            }
            return true;
        },
        async save() {
            if( this.validateForm()){
                const {name, lastname, city,cc,gender, email,phone} = this.form;
                const data = {
                    name,
                    lastname,
                    cc,
                    gender,
                    email,
                    department: this.selectedDepartment,
                    city,
                    phone
                }

                try {
                    await axios.post('/api/register', data);
                    this.restoreForm()
                    Swal.fire(
                        'Registro Exitoso!',
                        'Usuario registrado correctamente!',
                        'success'
                    )
                } catch (error) {
                    this.alertError(error.response.data.message)
                }

            }
        }

    },
    watch: {
        selectedDepartment(value) {
           if( value!= null) return this.getCities(value)
            this.cities = [ {name: 'Seleccione...', value: null}];
            this.form.city = null;
        },
        checked(value) {
            if(value) {
                Swal.fire({
                    title: 'Habeas Data',
                    text: 'Acepta el tratamiento de tus datos personales?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    result.isConfirmed ? this.checked = true : this.checked = false;
                })
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
                    <h3 class="mb-3"> Registro  Usuarios</h3>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <form action="" class="row g-4">
                                        <div class="col-6">
                                            <label>Nombre <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text"
                                                       class="form-control"
                                                       placeholder="Nombre"
                                                       v-model="form.name">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Apellido <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input v-model="form.lastname"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="Apellido">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Cédula <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input  v-model="form.cc"
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="Nro de Cédula ">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label>Genero <span class="text-danger">*</span></label>
                                            <v-select :options=geners
                                                      :reduce="option => option.value"
                                                      label="name"
                                                      v-model="form.gender"  >
                                            </v-select>
                                        </div>
                                        <div class="col-6">
                                            <label>Departamento <span class="text-danger">*</span></label>
                                            <v-select :options=departments
                                                      :reduce="option => option.value"
                                                      label="name"
                                                      v-model="selectedDepartment"

                                            >
                                            </v-select>

                                        </div>

                                        <div class="col-6">
                                            <label>Ciudad <span class="text-danger">*</span></label>
                                            <v-select :options=cities
                                                      :reduce="option => option.value"
                                                      label="name"
                                                      v-model="form.city"
                                            >
                                            </v-select>
                                        </div>

                                        <div class="col-6">
                                            <label> Correo Electrónico  <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input v-model="form.email"
                                                       type="email"
                                                       class="form-control"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label> Celular  <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input v-model="form.phone"
                                                       type="number"
                                                       class="form-control"
                                                       placeholder="Celular ">
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       v-model="checked"
                                                >
                                                <label class="form-check-label" for="inlineFormCheck"> Habeas Data </label>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <button  @click.prevent="save()"
                                                     type="submit"
                                                     class="btn btn-primary px-4 float-end mt-4"
                                                    > Registrar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="form-right h-100 bg-primary text-white text-center pt-5">
                                    <Avatar v-bind="props"></Avatar>
                                </div>
                            </div>
                        </div>
                    </div>
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


<script>
export default {
    methods: {
         downloadExcel() {
             axios.get('/api/download', { responseType: 'blob' })
                 .then(response => {
                     const url = window.URL.createObjectURL(new Blob([response.data]));
                     const link = document.createElement('a');
                     link.href = url;
                     link.setAttribute('download', 'users.xlsx');
                     document.body.appendChild(link);
                     link.click();
                 })
                 .catch(error => {
                     console.error('Error al exportar usuarios', error);
                 });
        }
    }
}
</script>


<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">

                        <RouterLink to="/"
                                    class="nav-link"
                                    exactActiveClass="nav-link active" >
                                    <i class="bi bi-house-door"></i>
                                    Inicio
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link download"

                           @click="downloadExcel()">
                            <i class="bi bi-arrow-down-circle-fill"></i>
                            Descargar
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <RouterLink to="/register"
                              class="nav-link"
                              exactActiveClass="nav-link active">
                              <i class="bi bi-person-add"></i>
                                Registro
                  </RouterLink>
                </ul>
            </div>

        </div>
    </nav>

    <main>
        <RouterView />
    </main>
</template>
<style>
    .download {
        cursor: pointer;
    }
</style>


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
                                    Home
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-arrow-down-circle-fill"></i>
                            Download
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
                                Register
                  </RouterLink>
                </ul>
            </div>

        </div>
    </nav>

    <main>
        <RouterView />
    </main>
</template>
<script setup>
</script>

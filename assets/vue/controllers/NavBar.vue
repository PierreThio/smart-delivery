<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <!-- Logo à gauche -->
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="/">
                <img src="../../../public/images/logo.png" alt="Logo">
            </a>
            <!-- Boutons de connexion et d'inscription à droite -->
            <ul class="navbar-nav ml-auto" v-if="user == null">
                <li class="nav-item">
                    <a class="nav-link" href="/points-relais">Points Relais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/connexion">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/inscription">Inscription</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto d-flex justify-content-center align-items-center" v-if="user">
                <li class="nav-item">
                    <a class="nav-link" href="/colis">Colis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/points-relais">Points Relais</a>
                </li>
                <li class="nav-item" v-if="isAdmin">
                    <a class="nav-link" href="/dashboard">Tableau de bord</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" height="36" viewBox="0 -960 960 960" width="36"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/profil">Mon profil</a></li>
                        <li><a class="dropdown-item" href="/profil/commandes">Mes commandes</a></li>
                        <li><a class="dropdown-item" href="/logout">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    data(){
        return{
            user: {},
            isAdmin: false
        }
    },
    mounted(){
        this.fetchData();
        setInterval(() => {
            this.fetchData();
        }, 60000);
    },
    methods:{
        async fetchData(){
            try{
                const response = await fetch('/api/userIsLoggedIn');
                const data = await response.json();
                this.user = data;
                const isAdminResponse = await fetch('/api/userIsAdmin');
                const isAdminData = await isAdminResponse.json();
                this.isAdmin = isAdminData;
            }
            catch(error){
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
    }
}
</script>
<style>
    img{
        width: 36px;
    }
</style>
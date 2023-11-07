<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
            <ul class="navbar-nav ml-auto" v-if="user">
                <li class="nav-item">
                    <a class="nav-link" href="/points-relais">Points Relais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Tableau de bord</a>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
export default {
    data(){
        return{
            user: {}
        }
    },
    mounted(){
        // fetch('/api/userIsLoggedIn')
        //     .then(response => response.json())
        //     .then(data => {
        //         this.user = data;
        //     })
        this.fetchData();
    },
    methods:{
        async fetchData(){
            try{
                const response = await fetch('/api/userIsLoggedIn');
                const data = await response.json();
                this.user = data;
            }
            catch{
                console.error("Erreur lors de la récupération des données: ", err);
            }
        }
    }
}
</script>
<style>
    img{
        width: 36px;
    }
</style>
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
                    <a v-if="userHaveUnreadNotification() == false" class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" height="36" viewBox="0 -960 960 960" width="36"><path d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z"/></svg>
                    </a>
                    <a v-if="userHaveUnreadNotification()" class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" height="36" viewBox="0 -960 960 960" width="36"><path d="M480-80q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80Zm0-420ZM160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v13q-11 22-16 45t-4 47q-10-2-19.5-3.5T480-720q-66 0-113 47t-47 113v280h320v-257q18 8 38.5 12.5T720-520v240h80v80H160Zm560-400q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Z"/></svg>
                    </a>

                    <ul class="dropdown-menu" v-for="notification in user.notifications">
                        <li class="dropdown-item">
                            {{ notification.notificationContent.content}}
                            <br>
                            {{ notification.timestamp }}
                        </li>
                        <button class="btn" v-if="notification.checked == false" @click="checkNotification(notification)"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></button>
                        <hr v-if="this.count(user.notifications) > 1">
                    </ul>
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
        userHaveUnreadNotification(){
            for (let index = 0; index < this.count(this.user.notifications); index++) {
                if(this.user.notifications[index].checked == false){
                    return true;
                }
            }
            return false;
        },  
        async checkNotification(notification){
            try {
                const response = await fetch(`/profil/notification/${notification.id}/check`);                
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
        count(array){
            var count = 0;
            for (var a in array) count++;
            return count;
        },
    }
}
</script>
<style>
    img{
        width: 36px;
    }
</style>
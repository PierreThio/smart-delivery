<script>
export default {
    data(){
        return{
            user: {}
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
            }
            catch(error){
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
    }
}
</script>
<template>
    <div class="container mt-5">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Prénom</th>
            <th>Nom de famille</th>
            <th>Email</th>
            <th>Ville</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Numéro de téléphone</th>
            <th>Centre relais par défaut</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ user.firstname }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.city }}</td>
            <td>{{ user.address }}</td>
            <td>{{ user.postalCode }}</td>
            <td>0{{ user.phoneNumber }}</td>
            <td v-if="user.relayCenter">{{ user.relayCenter.city }} {{ user.relayCenter.address }} {{ user.relayCenter.postalCode }}</td>
            <td v-if="!user.relayCenter">Vous n'avez pas encore de point relais par défaut</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
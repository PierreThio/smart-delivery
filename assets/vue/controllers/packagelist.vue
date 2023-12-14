<template>
    <div class="container mt-5">
      <h1 class="text-center mb-4">Liste des colis</h1>
  
      <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
        <table class="table table-bordered col-9">
          <thead>
            <tr>
              <th>Numéro de suivi</th>
              <th>Volume</th>
              <th>Poids</th>
              <th>Destination</th>
              <th>Acheteur</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="p in packages" :key="p.trackingNumber">
              <td>{{ p.trackingNumber }}</td>
              <td>{{ p.volume }}m²</td>
              <td>{{ p.weight }}kg</td>
              <td v-if="p.locker == null">{{ p.user.city }} {{ p.user.address }} {{ p.user.postalCode }}</td>
              <td v-if="p.locker">{{ p.locker.relayCenter.city }} {{ p.locker.relayCenter.address }} {{ p.locker.relayCenter.postalCode }}</td>
              <td><a class="text-decoration-underline" @click="userInformation(p.user)">{{ p.user.name }} {{ p.user.firstname }}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
<script>
export default {
    data(){
        return{
            packages: {}
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
            try {
                const response = await fetch('/api/package');
                const data = await response.json();
                this.packages = data;                
            } catch (error) {
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
        async userInformation(user){
            try {
                const reponse = await fetch(`/dashboard/user/${user.id}`);
                const route = `/dashboard/user/${user.id}`;
                window.location.href = route;
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
    }
}
</script>
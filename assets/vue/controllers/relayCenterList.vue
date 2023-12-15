<template>
    <div class="container mt-5">
      <h1 class="text-center mb-4">Liste des points relais</h1>
  
      <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Identifiant</th>
              <th>Ville</th>
              <th>Adresse</th>
              <th>Code postal</th>
              <th>Nombre de casier</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="relayCenter in relayCenters" :key="relayCenter.id">
              <td><a class="text-decoration-underline cursor-pointer" @click="checkLockers(relayCenter)">{{ relayCenter.id }}</a></td>
              <td>{{ relayCenter.city }}</td>
              <td>{{ relayCenter.address }}</td>
              <td>{{ relayCenter.postalCode }}</td>
              <td>{{ count(relayCenter.lockers) }}</td>
              <td>
                <div class="btn-group" role="group">
                  <button @click="deleteRelayCenter(relayCenter)" type="button" class="btn btn-danger">Supprimer</button>
                  <button @click="updateRelayCenter(relayCenter)" type="button" class="btn btn-warning">Modifier</button>
                  <button @click="addLocker(relayCenter)" type="button" class="btn btn-primary">Ajouter casier</button>
                </div>
              </td>
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
            relayCenters: {},
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
                const response = await fetch('/api/relay-center');
                const data = await response.json();
                this.relayCenters = data;                
            }
            catch(error){
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
        async deleteRelayCenter(relayCenter){
            try {
                const reponse = await fetch(`/points-relais/${relayCenter.id}/delete`);                
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
        async updateRelayCenter(relayCenter){
            try {
                const route = `/points-relais/${relayCenter.id}/update`;
                window.location.href = route;
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
        async addLocker(relayCenter){
            try {
                const route = `/points-relais/${relayCenter.id}/add/locker`;
                window.location.href = route;
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
        async checkLockers(relayCenter){
            try {
                const route = `/points-relais/${relayCenter.id}`;
                window.location.href = route;
            } catch (error) {
                console.error("Erreur lors du chargement de la page: ", error);
            }
            this.fetchData();
        },
        count(array){
            var count = 0;
            for (var a in array) count++;
            return count;
        }
    }
}

</script>
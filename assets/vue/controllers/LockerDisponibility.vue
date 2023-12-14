<template>
    <div class="container mt-5">
      <h1 class="text-center mb-4">Disponibilité des casiers</h1>
  
      <div v-for="relayCenter in relayCenters" :key="relayCenter.id">
        <h2>{{ relayCenter.city }} {{ relayCenter.address }} {{ relayCenter.postalCode }}</h2>
        
        <p v-if="count(relayCenter.lockers) === 0" class="mb-4">Aucun casier disponible pour ce point relais</p>
  
        <table v-if="count(relayCenter.lockers) > 0" class="table table-bordered col-12">
          <thead>
            <tr>
              <th>Numéro du casier</th>
              <th>Disponibilité</th>
              <th>Volume disponible</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="locker in relayCenter.lockers" :key="locker.lockerNumber">
              <td>{{ locker.lockerNumber }}</td>
              <td class="d-flex justify-content-between">
                <span v-if="locker.status === 'Available'" class="badge bg-success">Disponible</span>
                <button v-if="user && locker.status === 'Available'" @click="updateLocker(locker)" type="button" class="btn btn-primary">Réservé</button>
                <span v-if="locker.status === 'Unavailable'" class="badge bg-danger">Indisponible</span>
              </td>
              <td>{{ locker.status === 'Available' ? locker.availableVolume : 0 }}</td>
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
            user:{},
            locker:{
                getAvailableVolume:'',
            }
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
                const response = await fetch('/api/relay-center');
                const data = await response.json();
                this.relayCenters = data;
                const userResponse = await fetch('/api/userIsLoggedIn');
                const userData = await userResponse.json();
                this.user = userData;
            } catch (error) {
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
        count(array){
            var count = 0;
            for (var a in array) count++;
            return count;
        },
        async updateLocker(locker){
            try {
                const response = await fetch(`/points-relais/locker/${locker.id}/update`);                
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        },
        async getAvailableVolume(locker){
            try {
                const response = await fetch(`/api/locker/${locker.id}/available-volume`);
                const data = await response.json();
                locker = (locker, 'availableVolume', data);
            } catch (error) {
                console.error("Erreur lors de la récupération des données: ", error);
            }
        }
    }
}
</script>
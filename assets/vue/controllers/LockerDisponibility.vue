<template>
    <div class="d-flex justify-content-center flex-column">
        <h1 class="text-center">Disponibilité des casiers</h1>
        <div class="" v-for="relayCenter in relayCenters">
            <h2>{{ relayCenter.city }} {{ relayCenter.address }} {{ relayCenter.postalCode   }}</h2>
            <table class="table-bordered col-12">
                    <tr v-if="count(relayCenter.lockers) == 0"><p>Aucun casier pour ce point relais</p></tr>
                    <tr v-for="locker in relayCenter.lockers">
                        <td>{{ locker.lockerNumber }}</td>
                        <td class="d-flex justify-content-between" v-if="locker.status == 'Available'"><span class="badge bg-success">Disponible</span><button v-if="user" @click="updateLocker(locker)" type="button" class="btn btn-primary">Réservé</button></td>
                        <td v-if="locker.status == 'Unavailable'"><span class="badge bg-danger">Indisponible</span></td>
                    </tr>
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
                const reponse = await fetch(`/points-relais/locker/${locker.id}/update`);                
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
            }
            this.fetchData();
        }
    }
}
</script>
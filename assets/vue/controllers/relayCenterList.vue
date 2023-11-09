<template>
    <div class="d-flex justify-content-center flex-column align-items-center">
        <h1 class="text-center">Liste des points relais</h1>
        <table class="table-bordered col-9">
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Adresse</th>
                    <th>Code postal</th>
                    <th>Nombre de casier</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="relayCenter in relayCenters">
                    <th>{{ relayCenter.city }}</th>
                    <th>{{ relayCenter.address }}</th>
                    <th>{{ relayCenter.postalCode }}</th>
                    <th>{{ count(relayCenter.lockers) }}</th>
                    <th class="d-flex justify-content-around"><button @click="deleteRelayCenter(relayCenter)" type="button" class="btn btn-danger">Supprimer</button><a href="{{ path('app_relay_center_update', {'relayCenter': relayCenter.id})|escape('js') }}" @click="updateRelayCenter(relayCenter)" type="button" class="btn btn-warning">Modifier</a></th>
                </tr>
            </tbody>
        </table>
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
                const reponse = await fetch(`/points-relais/${relayCenter.id}/update`);                
            } catch (error) {
                console.error("Erreur lors de la mise à jour des données: ", error);
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
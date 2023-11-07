<template>
    <div class="d-flex justify-content-center flex-column align-items-center mt-4">
        <h1 class="text-center">Liste des points relay</h1>
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
                    <th>{{ relayCenter.city }}m²</th>
                    <th>{{ relayCenter.address }}kg</th>
                    <th>{{ relayCenter.postalCode }}</th>
                    <th>{{ count(relayCenter.lockers) }}</th>
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
    },
    methods:{
        async fetchData(){
            const response = await fetch('/api/relay-center');
            const data = await response.json();
            this.relayCenters = data;
        },
        count(array){
            var count = 0;
            for (var a in array) count++;
            return count;
        }
    }
}

</script>
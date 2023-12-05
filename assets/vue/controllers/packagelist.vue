<template>
    <div class="d-flex justify-content-center flex-column align-items-center">
        <h1 class="text-center">Liste des colis</h1>
        <div class="overflow-auto d-flex w-100 justify-content-center" style="height: 250px;">
            <table class="table-bordered col-9">
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
                    <tr v-for="p in packages">
                        <th>{{ p.trackingNumber }}</th>
                        <th>{{ p.volume }}m²</th>
                        <th>{{ p.weight }}kg</th>
                        <th v-if="p.locker == null">{{ p.user.city }} {{ p.user.address }} {{ p.user.postalCode }}</th>
                        <th v-if="p.locker">{{ p.locker.relayCenter.city }} {{ p.locker.relayCenter.address }} {{ p.locker.relayCenter.postalCode }}</th>
                        <th><a class="text-decoration-underline" @click="userInformation(p.user)">{{ p.user.name }} {{ p.user.firstname }}</a></th>
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
<template>
    <div class="d-flex justify-content-center flex-column align-items-center mt-4">
        <h1 class="text-center">Liste des colis</h1>
        <table class="table-bordered col-9">
            <thead>
                <tr>
                    <th>Volume</th>
                    <th>Poids</th>
                    <th>Départ</th>
                    <th>Acheteur</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in packages">
                    <th>{{ p.volume }}m²</th>
                    <th>{{ p.weight }}kg</th>
                    <th>{{ p.city }} {{ p.address }} {{ p.postalCode }}</th>
                    <th>{{ p.user.name }} {{ p.user.firstname }}</th>
                </tr>
            </tbody>
        </table>
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
    },
    methods:{
        async fetchData(){
            const response = await fetch('/api/package');
            const data = await response.json();
            this.packages = data;
        }
    }
}
</script>
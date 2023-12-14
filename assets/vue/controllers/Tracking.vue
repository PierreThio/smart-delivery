<script>
export default {
    data(){
        return{
            package: {},
            localisation:{}
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
                const response = await fetch(`/api/tracking/${this.trackingNumber}`);
                const data = await response.json();
                this.package = data;     
                
                await Promise.all(
                    this.package.localisations.map(async (loc) => {
                        loc.localisation = await this.getLocalisation(loc);
                    })
                );
            } catch (error) {
                console.error("Erreur lors de la récupération des données: ", error);
            }
        },
        async getLocalisation(localisation) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${localisation.latitude}&lon=${localisation.longitude}&zoom=10`);
                const data = await response.json();
                return data; // Retourner directement les données de localisation
            } catch (error) {
                console.error(
                "Erreur lors de la récupération des données de localisation: ",
                error
                );
                return null; // Gérer les erreurs de manière appropriée
            }
        },
        count(array){
            var count = 0;
            for (var a in array) count++;
            return count;
        }
    }
}
</script>
<template>
    <div class="container mt-2 mb-5 text-center">
        <h2 class="display-5">{{ package.trackingNumber }}</h2>

        <div v-for="localisation in package.localisations" class="mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><strong>{{ localisation.step.wording }}</strong></h5>
                    <p class="card-text">{{ localisation.timestamp }}</p>
                    <p class="card-text">
                        {{ localisation.localisation['address']['country'] }}
                        {{ localisation.localisation['address']['state'] }}
                        {{ localisation.localisation['address']['city'] }}
                        {{ localisation.localisation['address']['town'] }}
                        {{ localisation.localisation['address']['village'] }}
                    </p>
                </div>
            </div>
        </div>

        <div v-if="count(package.localisations) === 0" class="mt-4">
            <div class="alert alert-info" role="alert">
                <p>Il n'y a pas encore d'information sur ce colis.</p>
            </div>
        </div>
    </div>
</template>




<script setup>
    defineProps({
        trackingNumber: String
    });
</script>
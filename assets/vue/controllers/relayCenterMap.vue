<template>
    <div id="map"></div>
</template>
<script>
export default {
    data(){
        return{
            relayCenters: {},
        }
    },
    mounted(){
        this.fetchData().then(() => {
            this.createMap();
        });
        setInterval(() => {
                this.fetchData().then(() => {
                this.updateMap();
            });
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
        async createMap(){
            try{
                var map = L.map('map').setView([48.858844, 2.294351], 6);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                var markers = []
                this.relayCenters.forEach(element => {
                    markers.push({ lat: element.latitude, lng: element.longitude, label: element.city+'\n'+element.address+'\n'+element.postalCode})
                });

                markers.forEach(function(marker) {
                    L.marker([marker.lat, marker.lng]).addTo(map).bindPopup(marker.label);
                });
            }
            catch(error){
                console.error("Erreur lors de l'initialisation de la carte: ", error);
            }
            
        },
        updateMap(){
            try{
                var markers = []
                this.relayCenters.forEach(element => {
                    markers.push({ lat: element.latitude, lng: element.longitude, label: element.city+'\n'+element.address+'\n'+element.postalCode})
                });

                markers.forEach(function(marker) {
                    L.marker([marker.lat, marker.lng]).addTo(map).bindPopup(marker.label);
                });
            }
            catch(error){
                console.error("Erreur lors de la mise à jour de la carte: ", error);
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
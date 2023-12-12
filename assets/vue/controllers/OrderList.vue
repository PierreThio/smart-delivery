    <template>
        <div class="d-flex justify-content-center flex-column align-items-center">
            <div class="overflow-auto d-flex w-100 justify-content-center" style="height: 250px;">
                <table class="table-bordered col-9">
                    <thead>
                        <tr>
                            <th>Numéro de suivi</th>
                            <th>Volume</th>
                            <th>Poids</th>
                            <th>Destination</th>
                            <th>État</th>
                            <th>Numéro de casier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in packages">
                            <th><a class="text-decoration-underline cursor-pointer" @click="trackingNumber(p.trackingNumber)">{{ p.trackingNumber }}</a></th>
                            <th>{{ p.volume }}m²</th>
                            <th>{{ p.weight }}kg</th>
                            <th v-if="p.locker == null">{{ p.user.city }} {{ p.user.address }} {{ p.user.postalCode }}</th>
                            <th v-if="p.locker">{{ p.locker.relayCenter.city }} {{ p.locker.relayCenter.address }} {{ p.locker.relayCenter.postalCode }}</th>
                            <th v-if="p.packageStatus">{{ p.packageStatus }}</th>
                            <th v-if="!p.packageStatus"></th>
                            <th v-if="p.locker">{{ p.locker.lockerNumber }}</th>
                            <th v-if="!p.locker">Livré à domicile</th>
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
                packages: {},
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
                    const response = await fetch('/api/user/package');
                    const data = await response.json();
                    this.packages = data;
                    this.packages.forEach(p => this.getStep(p));
                }
                catch(error){
                    console.error("Erreur lors de la récupération des données: ", error);
                }
            },
            async trackingNumber(trackingNumber){
                try {
                    const route = `/tracking/${trackingNumber}`;
                    window.location.href = route;
                } catch (error) {
                    console.error("Erreur lors de la mise à jour des données: ", error);
                }
                this.fetchData();
            },
            async getStep(p){
                try{
                    const response = await fetch(`/api/package/${p.id}/status`);
                    const data = await response.json();
                    p.packageStatus = data;
                }
                catch(error){
                    console.error("Erreur lors de la récupération des données: ", error);
                }
            },
        }
    }

    </script>
    <style>
    .cursor-pointer{
        cursor: pointer;
    }
    </style>
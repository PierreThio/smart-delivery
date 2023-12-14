<template>
    <div class="container mt-5">
      <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
        <table class="table table-bordered col-9">
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
            <tr v-for="p in packages" :key="p.trackingNumber">
              <td><a class="text-decoration-underline cursor-pointer" @click="trackingNumber(p.trackingNumber)">{{ p.trackingNumber }}</a></td>
              <td>{{ p.volume }}m²</td>
              <td>{{ p.weight }}kg</td>
              <td v-if="p.locker == null">{{ p.user.city }} {{ p.user.address }} {{ p.user.postalCode }}</td>
              <td v-if="p.locker">{{ p.locker.relayCenter.city }} {{ p.locker.relayCenter.address }} {{ p.locker.relayCenter.postalCode }}</td>
              <td v-if="p.packageStatus">{{ p.packageStatus }}</td>
              <td v-if="!p.packageStatus"></td>
              <td v-if="p.locker">{{ p.locker.lockerNumber }}</td>
              <td v-if="!p.locker">Livré à domicile</td>
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
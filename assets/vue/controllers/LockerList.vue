<script setup>
defineProps({
    relayCenter: String,
});
</script>
<template>
    <div class="container mt-5">
      <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
        <table class="table table-bordered col-9">
          <thead>
            <tr>
              <th>Numéro de casier</th>
              <th>Status</th>
              <th>Volume</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="locker in lockers" :key="locker.id">
              <td>{{ locker.lockerNumber }}</td>
              <td>{{ locker.status }}</td>
              <td>{{ locker.volume }}</td>
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
                lockers: {},
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
                    console.log(this.relayCenter);
                    const response = await fetch(`/api/centre-relais/${this.relayCenter}/lockers`);
                    const data = await response.json();
                    this.lockers = data;
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


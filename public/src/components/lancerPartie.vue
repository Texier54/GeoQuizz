<template>

  <div>

    <nav-bar></nav-bar>

    <section class="section coop-accueil">

      <nav class="panel">

        <p class="panel-heading is-size-4 has-text-weight-semibold has-text-info">
          Bienvenue sur GeoQuizz !!!
        </p>

        <div class="panel-block">
          <p class="control has-icons-left is-size-5">
            Un jeu amusant où tu dois positionner une photo sur la carte de ta ville sans te tromper et plus vite que les autres !
            Il est possible de choisir son niveau pour avoir plus de photos ou devoir être plus précis dans les réponses.
          </p>
        </div>

        <div class="has-text-centered is-marginless">
          <button class="button is-primary is-large is-capitalized has-text-weight-bold" @click="lancerPartie"><i class="marker fas fa-gamepad"></i>Lancer partie</button>
        </div>

      </nav>

      <tableauScore></tableauScore>

    </section>

    <div class="modal" v-bind:class="{ 'is-active': lancer }">
      <div class="modal-background" @click="fermer"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Lancer une partie</p>
          <button class="delete" @click="fermer" aria-label="close"></button>
        </header>

        <section class="modal-card-body">
          <label class="label" id="pseudo">Pseudo</label>
          <input v-model="pseudo" type="text" class="input" id="pseudo" name="pseudo" placeholder="Pseudo" required>
          <label class="label" for="ville">Ville :</label>
          <div class="select">
            <select id="ville">
              <choix-serie v-for="serie in series" :serie="serie"></choix-serie>
            </select>
          </div>
        </section>

        <footer class="modal-card-foot">
          <router-link class="button is-success" :to="{ name:'partie', params : { pseudo : pseudo, serie : serie } }">Lancer</router-link>
          <button class="button" @click="fermer">Cancel</button>
        </footer>

      </div>
    </div>

  </div>

</template>

<script>

import NavBar from './navBar.vue'
import choixSerie from './choix-serie.vue'

export default {
  name: 'lancerPartie',
  components: {NavBar, choixSerie},
  
  data () {
    return {
      lancer: false,
      pseudo: '',
      series: '',
      serie: '',
    }
  },
  methods : {
    lancerPartie() {
      this.lancer = true;
    },
    fermer() {
      this.lancer = false;
    }
  },
  mounted() {

    window.axios.get('series').then((response) => {
      this.series = response.data;
      this.serie = this.series[0]['id'];
    }).catch((error) => {

      console.log(error);

    });

    window.bus.$on('choixSerie',(id) => {

      this.serie = id;
      
    });


  }
}
</script>

<style scoped>

.button{
  margin: 10px;
  -webkit-transition-property: color;
  -webkit-transition-duration: 0.5s;
  -moz-transition-property: color;
  -moz-transition-duration: 0.5s;
  transition-property: color;
  transition-duration: 0.5s;
}

.button:hover{
  color: #363636;
}

.columns{
  border-radius: 5px;
  margin-top: 20px;
}

.titre{
  background-color: #DBDBDB;
}

.first{
  border-radius: 5px 0px 0px 5px;
}

.last{
  border-radius: 0px 5px 5px 0px;
}

.data{
  border-bottom: 1px solid black;
}

.marker{
  margin-right: 10px;
}


</style>
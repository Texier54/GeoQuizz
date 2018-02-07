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
          <router-link v-show="this.$store.state.partie.save" class="button is-primary is-large is-capitalized has-text-weight-bold" :to="{ name:'partie', params : { partie : this.$store.state.partie } }"><i class="marker fas fa-gamepad"></i>Reprendre partie</router-link>
          <p v-show="this.$store.state.partie">Recommencer une partie supprimera la sauvegarde</p>
        </div>

      </nav>

      <!--<tableauScore></tableauScore>-->

    </section>

    <startgame :lancer="lancer"></startgame>

  </div>

</template>

<script>

import NavBar from './navBar.vue'
import startgame from './startgame.vue'

export default {
  name: 'lancerPartie',
  components: {NavBar, startgame},
  
  data () {
    return {
      lancer: false,
    }
  },
  methods : {
    lancerPartie() {
      this.lancer = true;
    },
  },
  mounted() {

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
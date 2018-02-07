<template>

  <div>

    <nav-bar></nav-bar>

    <section class="section coop-accueil">

      <nav class="panel">

        <p class="panel-heading">
          Bienvenue sur GeoQuizz !!!!
        </p>

        <div class="panel-block">
          <p class="control has-icons-left">
            Pour lancer une partie, cliquez sur le bouton "Lancer partie" #con
          </p>
        </div>

          <div class="navbar-item">
            <button class="button is-primary" @click="lancerPartie">Lancer partie</button>
          </div>

      </nav>
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


</style>
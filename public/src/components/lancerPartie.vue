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
        </section>

        <footer class="modal-card-foot">
          <router-link class="button is-success" :to="{ name:'partie', params : { pseudo : pseudo } }">Lancer</router-link>
          <button class="button" @click="fermer">Cancel</button>
        </footer>

      </div>
    </div>

  </div>

</template>

<script>

import NavBar from './navBar.vue'

export default {
  name: 'lancerPartie',
  components: {NavBar},
  data () {
    return {
      lancer: false,
      pseudo: '',
    }
  },
  methods : {
    lancerPartie() {
      this.lancer = true;
    },
    fermer() {
      this.lancer = false;
    }
  }
}
</script>

<style scoped>


</style>
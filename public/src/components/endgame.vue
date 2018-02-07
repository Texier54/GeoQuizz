<template>
    <div class="modal" v-bind:class="{ 'is-active': end }">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Sauvegarder partie</p>
        </header>

        <section class="modal-card-body">
          <b>Vous avez terminé</b><br>
          Ville : {{ partie.ville }}<br>
          Votre score : {{ partie.score }}
        </section>

        <footer class="modal-card-foot">
          <router-link class="button is-success" :to="{ name:'lancerPartie' }">Oui</router-link>
          <router-link class="button is-success" :to="{ name:'lancerPartie' }">Non</router-link>
        </footer>

      </div>
    </div>
</template>

<script>

export default {
  props : ['end', 'partie'],
  name: 'endgame',
  components: {},
  data () {
    return {
    }
  },
  methods : {
  }
}
</script>
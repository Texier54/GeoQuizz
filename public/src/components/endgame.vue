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
          Pseudo : {{ partie.pseudo }}<br>
          Votre score : {{ partie.score }}
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="Save">Oui</button>
          <router-link class="button is-danger" :to="{ name:'lancerPartie' }">Non</router-link>     
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
    Save() {
      window.axios.put('partie/'+this.partie.token,{

        score : this.partie.score,
        etat: 2

      }).then((response) => {
        this.$router.push({ path: 'lancerPartie'});
      }).catch((error) => {
        console.log(error);
      });
  }
  }
}
</script>
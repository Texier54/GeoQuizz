<template>
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
          <label class="label ville" for="ville">Ville :</label>
          <div class="select">
            <select id="ville">
              <choix-serie v-for="serie in series" :serie="serie"></choix-serie>
            </select>
          </div>
          <label class="label" for="difficulte">Difficulté :</label>
          <choix-difficulte></choix-difficulte>
        </section>

        <footer class="modal-card-foot">
          <button class="button is-success" @click="start">Lancer</button>
          <button class="button" @click="fermer">Cancel</button>
        </footer>

      </div>
    </div>
</template>

<script>

import choixSerie from './choix-serie.vue'
import choixDifficulte from './choix-difficulte.vue'

export default {
  props : ['lancer'],
  name: 'startgame',
  components: {choixSerie, choixDifficulte},

  data () {
    return {
      pseudo: '',
      series: '',
      serie: '',
      difficulte: 1,
    }
  },

  methods : {
    fermer() {
      this.lancer = false;
    },
    start() {

      if(this.pseudo != '')
        this.$router.push({ name: 'partie', params : { pseudo : this.pseudo, serie : this.serie, difficulte : this.difficulte } });
    },
  },

  mounted() {

    window.bus.$on('choixSerie',(id) => {
      this.serie = id;
    });

    window.bus.$on('choixDifficulte',(nb) => {
      this.difficulte = nb;
    });

    if(typeof this.$store.state.partie !== 'undefined' && this.$store.state.partie.save !== true)
      this.$store.commit('setPartie', false);

    window.axios.get('series').then((response) => {
      this.series = response.data;
      this.serie = this.series[0]['id'];
    }).catch((error) => {

      console.log(error);

    });

  }
}
</script>

<style scoped>

.ville{
  margin-top: 10px;
}
</style>
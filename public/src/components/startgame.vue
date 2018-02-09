<template>
    <div class="modal is-active">
      <div class="modal-background" @click="fermer"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Lancer une partie</p>
          <button class="delete" @click="fermer" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <label class="label" for="pseudo">Pseudo</label>
          <input v-model="pseudo" type="text" class="input" id="pseudo" name="pseudo" placeholder="Pseudo" required>
          <div class="columns">
            <div class="column">
              <label class="label options" for="ville">Ville :</label>
              <div class="select">
                <select class="is-capitalized" id="ville">
                  <choix-serie v-for="serie in series" :serie="serie"></choix-serie>
                </select>
              </div>
            </div>
            <div class="column">
              <label class="label options" for="difficulte">Difficulté :</label>
              <choix-difficulte></choix-difficulte>
            </div>
          </div>
          <label class="label" for="nombre">Nombre d'images 5-20 :</label>
          <input class="input" id="nombre" type="number" v-model="nombre">
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
      nombre: 10,
    }
  },

  methods : {
    fermer() {
      window.bus.$emit('fermerStartGame');
    },
    start() {
      if(this.pseudo != '' && this.nombre >= 5 && this.nombre <= 20)
        this.$router.push({ name: 'partie', params : { pseudo : this.pseudo, serie : this.serie, difficulte : this.difficulte, nb_photos : this.nombre } });
    },
  },

  mounted() {

    //Recois le choix de la serie
    window.bus.$on('choixSerie',(id) => {
      this.serie = id;
    });

    //Recois le choix de la difficulte
    window.bus.$on('choixDifficulte',(nb) => {
      this.difficulte = nb;
    });

    //Vide le storage si ce n'est pas une vraie save
    if(typeof this.$store.state.partie !== 'undefined' && this.$store.state.partie.save !== true)
      this.$store.commit('setPartie', false);

    //Recois le choix de la difficulte
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

.options{
  margin-top: 10px;
}
</style>
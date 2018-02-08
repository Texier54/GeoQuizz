<template>

      <div class="columns is-multiline end">

        <!-- DATA -->
        <div class="column is-one-quarter is-size-5 is-capitalized has-text-centered data">
          {{ tableau.joueur }}
        </div>
        <div class="column is-one-quarter is-size-5 is-uppercase has-text-centered data">
          {{ serie.ville }}
        </div>
        <div class="column is-one-quarter is-size-5 has-text-centered data">
          {{ tableau.score }}
        </div>
        <div class="column is-one-quarter is-size-5 has-text-centered data">
          {{ tableau.nb_photos }}
        </div>
        <!-- FIN DATA -->
      </div>

</template>

<script>

export default {
  name: 'tableauScore',
  props : ['tableau'],
  data () {
    return {
      serie: '',
    }
  },
  mounted() {
    window.axios.get('series/'+this.tableau.id_serie,{
    }).then((response) => {
      this.serie = response.data;
    }).catch((error) => {
      console.log(error);
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

.marker{
  margin-right: 10px;
}

.end{
  border-bottom: 1px solid black;
}

</style>
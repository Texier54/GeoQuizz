<template>

  <div style="height: 100%; width: 100%">

    <div style="height: 100%; width: 80%; display:inline-block;">
      <v-map :zoom=16 :center="[48.69, 6.18]">
        <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
        <v-marker :lat-lng="[48.69, 6.18]"></v-marker>
      </v-map>
    </div>

    <img src="http://www.lorrainemag.com/wp-content/uploads/2015/12/Place_Stanislas_crepuscule_ville-de-Nancy-Copie-520x348.jpg" style="width: 19%; display:inline-block;">

  </div>


</template>

<script>



export default {
  name: 'partie',
  components: {},
  data () {
    return {

    }
  },
}
</script>

<style>
html, body, #app {
  height: 100%;
  margin: 0;
}
</style>
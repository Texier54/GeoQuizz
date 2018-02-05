<template>

  <div style="height: 100%; width: 100%">

    <div id="map" style="height: 100%; width: 80%; display:inline-block;">
      <v-map :minZoom="16" :maxZoom="16" :noMoveStart="true" :zoom=16 :center="[48.692054, 6.184417]">
        <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
        <v-marker :lat-lng="[48.692054, 6.184417]"></v-marker>
      </v-map>
    </div>

    <img src="http://www.lorrainemag.com/wp-content/uploads/2015/12/Place_Stanislas_crepuscule_ville-de-Nancy-Copie-520x348.jpg" style="width: 19%; display:inline-block;">
    {{ test }}
    {{ val }}
  </div>


</template>

<script>



export default {
  name: 'partie',
  components: {},
  data () {
    return {
      test: 'qzfqzfqzf',
      val: '',
    }
  },

  mounted() {


    function deg2rad(x){
      return Math.PI*x/180;
    }
 
    function get_distance_m($lat1, $lng1, $lat2, $lng2) {
      var $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
      var $rlo1 = deg2rad($lng1);    // CONVERSION
      var $rla1 = deg2rad($lat1);
      var $rlo2 = deg2rad($lng2);
      var $rla2 = deg2rad($lat2);
      var $dlo = ($rlo2 - $rlo1) / 2;
      var $dla = ($rla2 - $rla1) / 2;
      var $a = (Math.sin($dla) * Math.sin($dla)) + Math.cos($rla1) * Math.cos($rla2) * (Math.sin($dlo) * Math.sin($dlo
    ));
      var  $d = 2 * Math.atan2(Math.sqrt($a), Math.sqrt(1 - $a));
      return ($earth_radius * $d);
    }


    var test;

    window.bus.$on('updateCoord',() => {
      console.log(test);
      this.test = get_distance_m(test.lat, test.lng ,48.692054, 6.184417);
    });


    

    var map = L.map('map', {
      center: [48.69, 6.18],
      zoom: 13,
      zoomControl: false
    });

    map.on('click', function(ev) {
      alert(ev.latlng);
      test = ev.latlng;
      window.bus.$emit('updateCoord');
    });


  }
}
</script>

<style>
html, body, #app {
  height: 100%;
  margin: 0;
}
</style>
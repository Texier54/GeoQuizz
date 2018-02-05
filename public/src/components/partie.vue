<template>

  <div style="height: 100%; width: 100%">



    <div id="map" style="height: 100%; width: 80%; display:inline-block;">
    </div>

    <button style="display:inline-block;" @click="suivant">Suivant</button>

    {{ val }}
    <img :src="img" style="width: 19%; display:inline-block;">

    
    
  </div>


</template>

<script>



export default {
  name: 'partie',
  components: {},
  data () {
    return {
      liste: '',
      val: '',
      img: '',
      nombre: 0,
    }
  },

  methods : {
    suivant() {
      this.nombre = this.nombre+1;
      this.img = this.liste['image'][this.nombre]['url'];
    }
  },

  mounted() {


    window.axios.post('partie',{

      pseudo : 'zf'

    }).then((response) => {

      this.liste = response.data;
      //console.log(this.liste['image'][0]);
      this.img = this.liste['image'][0]['url'];

    }).catch((error) => {

      console.log(error);

    });



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


    var temp;

    function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}

    window.bus.$on('updateCoord',() => {
      this.val = precisionRound(get_distance_m(temp.lat, temp.lng ,this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']), 1)*0.001+'km';
    });


    

    var map = L.map('map', {
        center: [48.692054, 6.184417],
        zoom: 16,

    });

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        minZoom: 1,
        maxZoom: 16
    }).addTo(map);


    map.on('click', function(ev) {
      temp = ev.latlng;
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
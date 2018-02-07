<template>

  <div>

    <nav-bar></nav-bar>

    <section class="container">

      <div class="columns">

        <div class="column is-7">
          <div id="map">
          </div>
        </div>


        <div class="column is-5">
          <img class="img" :src="img" v-show="photo">

          <div class="is-size-3 has-text-centered has-text-weight-bold">
            <p class="is-">{{ ville }}</p>
          </div>

          <button class="btn button is-success" v-show="btn_val" @click="valider">VALIDER</button>
          <button class="btn button is-info" v-show="btn_suiv" @click="suivant">SUIVANT</button>

          <div class="points is-size-4 has-text-weight-semibold">
            <p class="score">Score : {{ score }}</p>
            <p class="ptsgagne">+{{ newscore }}</p>
          </div>

          {{ progress }}s
          <progress class="progress is-success" :value="progress" max="60">{{ progress }}</progress>

        </div>

      </div>

    </section>

  </div>


</template>

<script>

import NavBar from './navBar.vue'

export default {
  name: 'partie',
  components: {NavBar},
  data () {
    return {
      liste: '',
      val: '',
      img: '',
      nombre: 0,
      btn_suiv: false,
      btn_val:false,
      score: 0,
      newscore: 0,
      token: '',
      marker: '',
      markerResult: '',
      photo: true,
      progress: 60,
      ville: '',
    }
  },

  methods : {

    valider() {
      this.btn_val = false;
      this.btn_suiv = true;
      window.bus.$emit('addMarkerResult');

      let addscore = 0;
      let bonus = 1;

      if(this.progress >= 55)
        bonus = 4;
      else if(this.progress >= 50)
        bonus = 2;
      else if(this.progress <= 0)
        bonus = 0;

      if(this.val<= 20) 
      {
        addscore = 5*bonus;
      }
      else if (this.val<= 30)
      {
        addscore = 4*bonus;
      }
      else if (this.val<= 40)
      {
        addscore = 2*bonus;
      }
      else if (this.val<= 50)
      {
        addscore = 1*bonus;
      }

      this.score = this.score+addscore;
      this.newscore = addscore;

    },

    suivant() {
      window.bus.$emit('removeMarker');      
      this.nombre = this.nombre+1;
      this.newscore = 0;
      this.progress = 60;
      if(this.nombre > this.liste['image'].length-1)
      {
        this.photo = false;
        this.btn_suiv = false;
        window.axios.put('partie',{

          token : this.token,
          score : this.score

        }).then((response) => {

        }).catch((error) => {

          console.log(error);

        });
      }
      else
      {
        this.img = this.liste['image'][this.nombre]['url'];
        this.btn_suiv = false;
      }

    }
  },

  mounted() {

    var map = '';
    var intervalProgress = '';
    
    window.axios.post('partie',{

      pseudo : this.$route.params.pseudo

    }).then((response) => {

      this.liste = response.data;
      this.ville = this.liste['serie']['ville'];
      this.img = this.liste['image'][0]['url'];
      this.token = this.liste['token'];
      let lat = this.liste['serie']['latitude'];
      let lng = this.liste['serie']['longitude'];

          map = L.map('map', {
          center: [lat, lng],
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

      intervalProgress = setInterval(function(){ window.bus.$emit('updateProgress'); }, 1000);

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

      if(this.btn_suiv == false)
      {
        if(this.marker != '')
          map.removeLayer(this.marker);

        this.val = precisionRound(get_distance_m(temp.lat, temp.lng ,this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']), 1);
        this.btn_val = true;
        this.marker = L.marker([temp.lat, temp.lng]).addTo(map);
      }
    });



    window.bus.$on('updateProgress',() => {
      this.progress = this.progress-1;
      console.log(this.progress);
      if(this.progress <= 0)
        clearInterval(intervalProgress);
    });


    window.bus.$on('removeMarker',() => {
      map.removeLayer(this.marker);
      map.removeLayer(this.markerResult);
    });
  
    var greenIcon = new L.Icon({
      iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

    window.bus.$on('addMarkerResult',() => {
      if(this.val<=20)
      {
        map.removeLayer(this.marker);
        this.marker = L.marker([temp.lat, temp.lng], {icon: greenIcon}).addTo(map);
      }
      else
        this.markerResult = L.marker([this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']], {icon: greenIcon}).addTo(map);
    });

  }
}
</script>

<style scoped>

#map{
  min-height: 600px; 
  width: 100%;
}

.container {
  padding-top: 10px;
}

body {
  background-color: #F2F6FA;
  margin: 0px;
  padding: 0px;
  outline: 0px;
  height: 100%;
  width: 100%;
  position: absolute;
}

.btn{
  font-weight: bold;
  -webkit-transition-property: color;
  -webkit-transition-duration: 0.5s;
  -moz-transition-property: color;
  -moz-transition-duration: 0.5s;
  transition-property: color;
  transition-duration: 0.5s;
}

.btn:hover{
  color: #363636;

}

.img{
  border-radius: 5px;
}

.points{
  margin-top: 20px;
}

.score{
  border: solid #363636 2px;
  border-radius: 10px;
  padding-left: 5px;
}



</style>
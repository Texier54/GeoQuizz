<template>
  <div>
    <nav-bar></nav-bar>
    <section class="container">
      <div class="columns">
        <div class="column is-7">
          <div v-show="!end" id="map">
          </div>
        </div>
        <div class="column is-5">
          <img class="img" :src="img" v-show="photo">
          <div class="is-size-3 has-text-centered has-text-weight-bold">
            <p class="is-">{{ ville }}</p>
          </div>
          <button class="btn button is-success" v-show="btn_val" @click="valider"><i class="marker fas fa-check-circle"></i>VALIDER</button>
          <button class="btn button is-info" v-show="btn_suiv" @click="suivant"><i class="marker fas fa-angle-double-right"></i>SUIVANT</button>
          <div class="points is-size-4 has-text-weight-semibold">
            <p class="score">Score : {{ score }}  ( +{{ newscore }} ! )</p>
          </div>
          <p class="is-size-4 has-text-weight-semibold"><i class="marker fas fa-hourglass-half"></i>{{ progress }}s</p>
          <progress class="progress is-success" :value="progress" :max="tempsMax">{{ progress }}</progress>
        </div>
      </div>
    </section>
    <endgame :partie="partie" :end="end"></endgame>
  </div>
</template>

<script>

import NavBar from './navBar.vue'
import endgame from './endgame.vue'


export default {
  name: 'partie',
  components: {NavBar, endgame},
  data () {
    return {
      liste: '',
      val: '',
      img: '',
      nombre: 0,
      btn_suiv: false, //afficher bouton suivant
      btn_val:false, //afficher bouton validé
      score: 0,
      newscore: 0,
      token: '',
      marker: '',
      markerResult: '',
      photo: true,
      progress: 0,
      ville: '',
      intervalProgress: '',
      tempsMax: 0,
      end: false, //modal endgame
      partie: '',
      pseudo: '',
      difficulte: 0,
      map: '',
      temp: '',
    }
  },

  methods : {


    /********************************
    *         Functions             *
    ********************************/

    deg2rad(x){
      return Math.PI*x/180;
    },


    precisionRound(number, precision) {
      var factor = Math.pow(10, precision);
      return Math.round(number * factor) / factor;
    },


    get_distance_m($lat1, $lng1, $lat2, $lng2) {
      var $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
      var $rlo1 = this.deg2rad($lng1);    // CONVERSION
      var $rla1 = this.deg2rad($lat1);
      var $rlo2 = this.deg2rad($lng2);
      var $rla2 = this.deg2rad($lat2);
      var $dlo = ($rlo2 - $rlo1) / 2;
      var $dla = ($rla2 - $rla1) / 2;
      var $a = (Math.sin($dla) * Math.sin($dla)) + Math.cos($rla1) * Math.cos($rla2) * (Math.sin($dlo) * Math.sin($dlo
    ));
      var  $d = 2 * Math.atan2(Math.sqrt($a), Math.sqrt(1 - $a));
      return ($earth_radius * $d);
    },


    valider() {
      this.btn_val = false;
      this.btn_suiv = true;

      let greenIcon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      });

      if(this.val<= this.liste['serie']['distance']*this.difficulte)
      {
        this.map.removeLayer(this.marker);
        this.marker = L.marker([this.temp.lat, this.temp.lng], {icon: greenIcon}).addTo(this.map);
      }
      else
        this.markerResult = L.marker([this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']], {icon: greenIcon}).addTo(this.map);



      let addscore = 0;
      let bonus = 1;

      if(this.progress >= this.tempsMax-5)
        bonus = 4;
      else if(this.progress >= this.tempsMax-10)
        bonus = 2;
      else if(this.progress <= 0)
        bonus = 0;

      if(this.val<= this.liste['serie']['distance']*this.difficulte) 
      {
        addscore = 5*bonus;
      }
      else if (this.val<= this.liste['serie']['distance']*2*this.difficulte)
      {
        addscore = 4*bonus;
      }
      else if (this.val<= this.liste['serie']['distance']*3*this.difficulte)
      {
        addscore = 2*bonus;
      }
      else
      {
        addscore = 0;
      }

      this.score = this.score+addscore;
      this.newscore = addscore;
      clearInterval(this.intervalProgress);
      this.tempsMax = Math.round(this.liste['serie']['temps']*this.difficulte);
      this.progress = Math.round(this.liste['serie']['temps']*this.difficulte);

      let imageNombre = this.nombre;
      if(this.btn_suiv == true)
        imageNombre = this.nombre+1;

      this.$store.commit('setPartie', {'save' : true, 'token' : this.liste['token'], 'score' : this.score, 'serie' : this.liste['serie'], 'image' : this.liste['image'], 'imageNombre' : imageNombre, 'progress' : this.progress, 'pseudo' : this.pseudo, difficulte : this.difficulte });

    },

    suivant() {
      window.bus.$emit('removeMarker');
      this.newscore = 0;
      if(this.nombre+1 > this.liste['image'].length-1)
      {
        this.end = true;
        this.partie = {'ville' : this.liste['serie']['ville'], 'score' : this.score, token : this.token, pseudo : this.pseudo};
        this.$store.commit('setPartie', false);
        clearInterval(this.intervalProgress);
        this.photo = false;
        this.btn_suiv = false;

        window.axios.put('partie/'+this.token,{

          score : this.score,
          etat: 2

        }).then((response) => {

        }).catch((error) => {

          console.log(error);

        });
      }
      else
      {
        this.progress = this.liste['serie']['temps'];
        this.intervalProgress = setInterval(function(){ window.bus.$emit('updateProgress'); }, 1000);
        this.nombre = this.nombre+1;
        this.img = this.liste['image'][this.nombre]['url'];
        this.btn_suiv = false;
      }

    },

    createMap() {

      this.token = this.liste['token'];
      this.pseudo = this.liste['pseudo'];
      this.tempsMax = Math.round(this.liste['serie']['temps']*this.difficulte);

      this.map = L.map('map', {
      center: [this.liste['serie']['latitude'], this.liste['serie']['longitude']],
      zoom: this.liste['serie']['zoom'],
      });

      L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
          minZoom: 1,
          maxZoom: 16
      }).addTo(this.map);

      this.map.on('click', (ev) => {
        this.temp = ev.latlng;
        if(this.btn_suiv == false)
        {
          if(this.marker != '')
            this.map.removeLayer(this.marker);

          this.val = this.precisionRound(this.get_distance_m(this.temp.lat, this.temp.lng ,this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']), 1);
          this.btn_val = true;
          this.marker = L.marker([this.temp.lat, this.temp.lng]).addTo(this.map);
        }
      });

      this.intervalProgress = setInterval(() => { window.bus.$emit('updateProgress'); }, 1000);

    }
  },

  mounted() {

    if(this.$store.state.partie !== false && typeof this.$route.params.pseudo === 'undefined')
    {
      this.liste = this.$store.state.partie;
      this.nombre = this.liste['imageNombre'];
      this.score = this.liste['score'];
      this.progress = Math.round(this.liste['progress']);
      this.img = this.liste['image'][this.nombre]['url'];
      this.difficulte = this.liste['difficulte'];
      this.createMap();
    }
    else
    {
      window.axios.post('partie',{

        serie_id : this.$route.params.serie,
        pseudo : this.$route.params.pseudo,
        difficulte: this.$route.params.difficulte,
        nb_photos: this.$route.params.nb_photos

      }).then((response) => {

        this.liste = response.data;
        this.difficulte = this.$route.params.difficulte;
        this.progress = Math.round(this.liste['serie']['temps']*this.difficulte);
        this.img = this.liste['image'][0]['url'];
        this.createMap();

      }).catch((error) => {

        console.log(error);

      });
    }

    /********************************
    *            Emits              *
    ********************************/

    //Appelé à chaque secondes du timer (intervalProgress)
    window.bus.$on('updateProgress',() => {
      this.progress = this.progress-1;
      console.log(this.progress);
      if(this.progress <= 0)
      {
        clearInterval(this.intervalProgress);
        this.btn_suiv = true;
      }
      let imageNombre = this.nombre;
      if(this.btn_suiv == true)
        imageNombre = this.nombre+1;

      this.$store.commit('setPartie', {'token' : this.liste['token'], 'score' : this.score, 'serie' : this.liste['serie'], 'image' : this.liste['image'], 'imageNombre' : imageNombre, 'progress' : this.progress, 'pseudo' : this.pseudo, difficulte : this.difficulte });
    });

    //Appelé pour supprimer les markers de la map
    window.bus.$on('removeMarker',() => {
      this.map.removeLayer(this.marker);
      this.map.removeLayer(this.markerResult);
    });
  
    //Appelé pour ajouter le marker qui montre le bon emplacement de la photo
    window.bus.$on('addMarkerResult',() => {


    });

    //Appelé pour supprimer la partie et quitter
    window.bus.$on('quitterPartie',() => {

      window.axios.put('partie/'+this.token,{

        score : 1,
        etat: 3

      }).then((response) => {

        clearInterval(this.intervalProgress);
        this.$store.commit('setPartie', false);
        this.$router.push({ path: 'lancerPartie'});

      }).catch((error) => {

        console.log(error);

      });
    });

    //Appelé pour save la partie et quitter
    window.bus.$on('suspendrePartie',() => {
      clearInterval(this.intervalProgress);
      let imageNombre = this.nombre;
      if(this.btn_suiv == true)
        imageNombre = this.nombre+1;

      this.$store.commit('setPartie', {'save' : true, 'token' : this.liste['token'], 'score' : this.score, 'serie' : this.liste['serie'], 'image' : this.liste['image'], 'imageNombre' : imageNombre, 'progress' : this.progress, 'pseudo' : this.pseudo, difficulte : this.difficulte });
      this.$router.push({ path: 'lancerPartie'});

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
  margin-bottom: 32px;
}

.marker{
  margin-right: 10px;
}

</style>
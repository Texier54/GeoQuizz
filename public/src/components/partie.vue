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
          <div>
            <p class="is-size-5 has-text-weight-semibold has-text-centered">{{ aide }}</p>
          </div>
          <div class="is-size-3 has-text-centered has-text-weight-bold">
            <p class="is-uppercase">{{ ville }}</p>
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
      liste: '', //stock toutes les infos pour le jeu
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
      map: '', //stock la map
      temp: '', //stock les coords d'un marker
      aide: '',
    }
  },

  methods : {


    /********************************
    *         Functions             *
    ********************************/

    updateProgress() {
      this.progress = this.progress-1;
      if(this.progress <= 0)
      {
        clearInterval(this.intervalProgress);
        this.btn_suiv = true;
      }
      else if (this.progress <= 5)
        this.aide = this.liste['image'][this.nombre]['nom'];
      let imageNombre = this.nombre;
      if(this.btn_suiv == true)
        imageNombre = this.nombre+1;

      //Save dans localStorage pour résoudre problème F5
      this.$store.commit('setPartie', {'token' : this.liste['token'], 'score' : this.score, 'serie' : this.liste['serie'], 'image' : this.liste['image'], 'imageNombre' : imageNombre, 'progress' : this.progress, 'pseudo' : this.pseudo, difficulte : this.difficulte });
    },

    valider() {
      this.btn_val = false;
      this.btn_suiv = true;
      this.aide = this.liste['image'][this.nombre]['nom'];
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

      //Calcul bonus
      if(this.progress >= this.tempsMax-5)
        bonus = 4;
      else if(this.progress >= this.tempsMax-10)
        bonus = 2;
      else if(this.progress <= 0)
        bonus = 0;

      //Calcul points
      if(this.val<= this.liste['serie']['distance']*this.difficulte) 
        addscore = 5*bonus;
      else if (this.val<= this.liste['serie']['distance']*2*this.difficulte)
        addscore = 4*bonus;
      else if (this.val<= this.liste['serie']['distance']*3*this.difficulte)
        addscore = 2*bonus;
      else
        addscore = 0;

      this.score = this.score+addscore;
      this.newscore = addscore;
      clearInterval(this.intervalProgress);
      this.tempsMax = Math.round(this.liste['serie']['temps']*this.difficulte);
      this.progress = Math.round(this.liste['serie']['temps']*this.difficulte);

      let imageNombre = this.nombre;
      if(this.btn_suiv == true)
        imageNombre = this.nombre+1;

      //Save dans localStorage pour résoudre problème F5
      this.$store.commit('setPartie', {'save' : true, 'token' : this.liste['token'], 'score' : this.score, 'serie' : this.liste['serie'], 'image' : this.liste['image'], 'imageNombre' : imageNombre, 'progress' : this.progress, 'pseudo' : this.pseudo, difficulte : this.difficulte });

    },

    suivant() {
      this.aide = '';
      this.map.removeLayer(this.marker);
      if(this.markerResult !== '')
        this.map.removeLayer(this.markerResult);
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
        }).catch((error) => {
          console.log(error);
        });
      }
      else
      {
        this.progress = this.liste['serie']['temps'];
        //Relancement timer
        this.intervalProgress = setInterval(() => { this.updateProgress() }, 1000);
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
          attribution: 'GeoQuizz',
          minZoom: 1,
          maxZoom: 16
      }).addTo(this.map);

      this.map.on('click', (ev) => {
        this.temp = ev.latlng;
        if(this.btn_suiv == false)
        {
          if(this.marker != '')
            this.map.removeLayer(this.marker);

          //Calcul distance
          this.val = Math.round(L.latLng([this.temp.lat, this.temp.lng]).distanceTo([this.liste['image'][this.nombre]['latitude'], this.liste['image'][this.nombre]['longitude']]));
          this.btn_val = true;
          this.marker = L.marker([this.temp.lat, this.temp.lng]).addTo(this.map);
        }
      });

      //Lancement timer
      this.intervalProgress = setInterval(() => { this.updateProgress() }, 1000);

    }
  },

  mounted() {


    /********************************
    *       Lancement partie        *
    ********************************/

    //Verifie si une partie est save
    if(this.$store.state.partie !== false && typeof this.$route.params.pseudo === 'undefined')
    {
      this.liste = this.$store.state.partie;
      this.nombre = this.liste['imageNombre'];
      this.score = this.liste['score'];
      this.difficulte = this.liste['difficulte'];
      if(this.liste['progress'] <= 0)
        this.progress = Math.round(this.liste['serie']['temps']*this.difficulte);
      else
        this.progress = Math.round(this.liste['progress']);
      this.img = this.liste['image'][this.nombre]['url'];
      this.ville = this.liste['serie']['ville'];
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
        this.ville = this.liste['serie']['ville'];
        this.createMap();

      }).catch((error) => {

        console.log(error);

      });
    }

    /********************************
    *            Emits              *
    ********************************/

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

      //Save dans localStorage pour reprendre la partie
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
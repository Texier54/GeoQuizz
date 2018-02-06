<template>
    
  <nav class="navbar is-dark level">

    <div class="navbar-brand"><a href="/" class="navbar-item">
      <b>GeoQuizz</b>
      </a>
      
    </div>

    <button class="level-right btn button is-danger">Quitter la partie</button>

  </nav>

</template>

<script>

export default {
  name: 'navBar',

  data () {
    return {
    }
  },

  methods : {
    logOut() {
      window.bus.$emit('logout');
    }
  }

}
</script>

<style scoped>
.router-link-exact-active {
  background-color:#fff;
  color: #1abc9c;
}

.navbar-item{
  font-size: 30px;
}

.btn{
  margin-top: 11px;
  margin-right: 10px;
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
</style>
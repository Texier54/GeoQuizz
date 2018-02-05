<template>


  <nav class="navbar is-white ">

  <div class="navbar-brand"><a href="/" class="navbar-item">
    <b>GeoQuizz</b>
    </a>
  </div>

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

<style>
.router-link-exact-active {
  background-color:#fff;
  color: #1abc9c;
}
</style>
<template>

  <div class="columns">
    
    <nav class="navbar is-dark column is-12">

    <div class="navbar-brand"><a href="/" class="navbar-item">
      <b>GeoQuizz</b>
      </a>
    </div>

    </nav>
    
  </div>


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
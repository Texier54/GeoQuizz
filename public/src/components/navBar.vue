<template>
    
  <nav class="navbar is-dark">

    <div class="navbar-brand">
      <a href="/" class="navbar-item">
        <b>GeoQuizz</b>
      </a>
      <button class="button navbar-burger btnreduc" data-target="navMenu">
        <span></span>
      </button>   
    </div>

    <div class="navbar-menu" id="navMenu">
      <button class="navbar-end nav btn button is-danger">Quitter la partie</button>
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
  mounted(){
    // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach(function ($el) {
      $el.addEventListener('click', function () {

        // Get the target from the "data-target" attribute
        var target = $el.dataset.target;
        var $target = document.getElementById(target);

        // Toggle the class on both the "navbar-burger" and the "navbar-menu"
        $el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
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

.btnreduc{
  color:#000000;
  border: none;
  margin-top: 5px;
  margin-right: 5px;
  background-color: #dbdbdb;
}

.btnreduc:hover{
  color:#FFFFFF;
}

#navMenu{
  background-color: #363636;
}
</style>
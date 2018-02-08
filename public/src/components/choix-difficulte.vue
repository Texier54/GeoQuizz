<template>
  <div class="select">
    <select id="difficulte">
      <option @click="standard">Standard</option>
      <option @click="medium">Medium</option>
      <option @click="hard">Hard</option>
    </select>
  </div>
</template>

<script>

export default {
  name: 'choix-difficulte',
  components: {},
  data () {
    return {
    }
  },
  methods : {
    standard() {
      window.bus.$emit('choixDifficulte', 1);
    },
    medium() {
      window.bus.$emit('choixDifficulte', 0.8);
    },
    hard() {
      window.bus.$emit('choixDifficulte', 0.6);
    }
  }
}
</script>
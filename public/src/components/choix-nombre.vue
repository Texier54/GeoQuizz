<template>
  <option @click="standard">Standard</option>
</template>

<script>

export default {
  name: 'choix-nombre',
  components: {},
  data () {
    return {
    }
  },
  methods : {
    standard() {
      window.bus.$emit('choixDifficulte', 1);
    },
  }
}
</script>
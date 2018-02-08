<template>
  <option @click="nombreImages">{{ nb }}</option>
</template>

<script>

export default {
  props : ['nb'],
  name: 'choix-nombre',
  data () {
    return {
    }
  },
  methods : {
    nombreImages() {
      window.bus.$emit('nombreImage', nb);
    },
  }
}
</script>
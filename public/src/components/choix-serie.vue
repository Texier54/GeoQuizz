<template>
  <option @click="choix">{{ serie.ville }}</option>
</template>

<script>

export default {
  props : ['serie'],
  name: 'choix-serie',
  components: {},
  data () {
    return {
    }
  },
  methods : {
    choix() {
      window.bus.$emit('choixSerie', this.serie.id);
    }
  }
}
</script>
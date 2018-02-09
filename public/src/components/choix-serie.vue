<template>
  <option @click="choix"><p class="is-capitalized">{{ serie.ville }}</p></option>
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
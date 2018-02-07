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
      choix() {

      }
    }
  },
  methods : {
  }
}
</script>
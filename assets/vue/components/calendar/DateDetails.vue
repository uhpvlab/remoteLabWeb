<template>
  <p class="h4" id="currentDate">{{ date }}</p>
</template>

<script>
export default {
  name: "DateDetails",
  props: ['date'],
  data() {
    return {
      // title: this.date + ' details'
    }
  },
  fetchEvents(){

  }
}
</script>

<style scoped>

</style>
<template>
<div class="col-md-12">
  <p class="h4">{{ date }} details</p>
</div>
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
<template>
<div class="col-md-12">
  <p>{{ event }}</p>
</div>
</template>

<script>
export default {
  name: "EventDetails",
  props: ['event'],
  data() {
    return {
      // title: this.date + ' details'
    }
  }
}
</script>

<style scoped>

</style>
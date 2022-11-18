<script>
import CalendarView from "../components/calendar/CalendarView";

export default {
  components: {
    CalendarView
  },

  props: ['name', 'eventsSource', 'selectedDate', 'selectedEvent'],
  methods: {
    dateClickHandler(dateStr) {
      this.currentDate = dateStr
      alert('date-click' + dateStr)
    },
    eventClickHandler(event) {
      this.currentEvent = event
      alert('event-title' + event.title)
    }
  },
  data() {
    return {
      currentDate: this.selectedDate,
    }
  }
}
</script>
<template>
  <div class="row">
    <div class="col-md-8">
      <CalendarView :eventsSource="eventsSource" @date-click="dateClickHandler"  @event-click="eventClickHandler"/>
    </div>
    <div class="col-md-4">
      Hello {{ name }}! {{ currentDate }}
    </div>
  </div>
</template>
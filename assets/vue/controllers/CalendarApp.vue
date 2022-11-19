<script>
import CalendarView from "../components/calendar/CalendarView";
import DateDetails from "../components/calendar/DateDetails";
import EventDetails from "../components/calendar/EventDetails";

export default {
  components: {
    EventDetails,
    CalendarView, DateDetails
  },

  props: ['name', 'eventsSource', 'selectedDate', 'selectedEvent'],
  methods: {
    dateClickHandler(info) {
      // console.log(info)
      this.currentDate = info.dateStr
      // console.log(info)
      // alert('date-click' + dateStr)
    },
    eventClickHandler(info) {
      this.currentEvent = info.event
      this.currentDate = info.event.startStr.split('T')[0]
      // console.log(info)
      // alert('event-title' + event.title)
    },
    toggleLoadingStatus(isLoading) {
      this.isLoading = isLoading
    }
  },
  data() {
    return {
      currentDate: this.selectedDate ?? (new Date()).toISOString().split('T')[0],
      currentEvent: this.currentEvent,
      isLoading: this.isLoading
    }
  }
}
</script>
<template>
  <div class="row">
    <div class="col-md-8 position-relative">
      <div v-if="isLoading" class="position-absolute background-secondary px-5 py-3 "
           style="top: 8em; left: 2em; z-index: 20"
      >
        <p class="h6">Loading events...</p>
      </div>
      <CalendarView
          :eventsSource="eventsSource"
          @date-click="dateClickHandler"
          @event-click="eventClickHandler"
          @loading-events="toggleLoadingStatus"
      />
    </div>
    <div class="col-md-4">
      <DateDetails :date="currentDate"></DateDetails>
<!--      <EventDetails :event="currentEvent"></EventDetails>-->
    </div>
  </div>
</template>
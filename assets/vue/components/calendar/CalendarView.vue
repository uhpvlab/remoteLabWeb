<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

export default {
  name: "CalendarView",

  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  props: ['eventsSource'],
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'currentWeek,dayGridMonth'
        },
        views: {
          currentWeek: {
            type: 'listWeek',
            duration: {days: 7},
            buttonText: 'Week view',
          }
        },
        dayMaxEvents: true, // allow "more" link when too many events
        editable: true,
        selectable: true,
        events: this.eventsSource,
        dateClick: function (info) {
          // alert('Clicked on: ' + info.dateStr);
          this.$emit('dateClick', info.dateStr)
          // this.fetchDate(info.dateStr)
          // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
          // alert('Current view: ' + info.view.type);
          // change the day's background color just for fun
          // info.dayEl.style.backgroundColor = '#7fe1ff';
        }.bind(this),
        eventClick: function (info) {
          // this.selectEvent(info.event.title)
          this.$emit('eventClick', info.event)
          alert('Event: ' + info.event.title);
          console.log({infoObj: info})
          // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
          // alert('View: ' + info.view.type);

          // change the border color just for fun
          info.el.style.borderColor = 'red';
        }.bind(this),
      }
    }
  }
}

</script>
<template>
  <div>
    <FullCalendar :options="calendarOptions" />
  </div>

</template>


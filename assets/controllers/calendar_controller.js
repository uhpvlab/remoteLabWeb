import { Controller } from '@hotwired/stimulus';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'


// import calendarDayDetailsCard from "../js/components/calendarDayDetailsCard";

// import esLocale from '@fullcalendar/core/locales/es';
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        console.log('❤️');

        // this.calendarDetails = this.element.querySelector('.calendar-date-details');
        // this.calendarEl = this.element.querySelector('.calendar-container');

        // this.appDetails = new Vue({
        //     el: this.calendarDetails,
        //
        //     mounted: function () {
        //         console.log('mounted VUE');
        //     },
        //     component: {'calendar-app': CalendarApp}
        // });
        // this.appDetails.component('calendar-app', CalendarApp)

        // this.calendarDetails = this.element.querySelector('.calendar-date-details');
        // this.calendarEl = this.element.querySelector('.calendar-container');
        // this.eventsSource = this.element.dataset.eventsSource
        //
        // document.addEventListener('DOMContentLoaded', function () {
        //
        //     let calendar = new Calendar(this.calendarEl, {
        //         plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        //         initialView: 'dayGridMonth',
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'currentWeek,dayGridMonth'
        //         },
        //         views: {
        //             currentWeek: {
        //                 type: 'listWeek',
        //                 duration: {days: 7},
        //                 buttonText: 'Week view',
        //
        //
        //             }
        //         },
        //         dayMaxEvents: true, // allow "more" link when too many events
        //         editable: true,
        //         selectable: true,
        //         events: this.element.dataset.eventsSource,
        //         dateClick: function (info) {
        //             // alert('Clicked on: ' + info.dateStr);
        //             this.fetchDate(info.dateStr)
        //             // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //             // alert('Current view: ' + info.view.type);
        //             // change the day's background color just for fun
        //             // info.dayEl.style.backgroundColor = '#7fe1ff';
        //         }.bind(this),
        //         eventClick: function (info) {
        //             this.selectEvent(info.event.title)
        //             alert('Event: ' + info.event.title);
        //             console.log({infoObj: info})
        //             // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //             // alert('View: ' + info.view.type);
        //
        //             // change the border color just for fun
        //             info.el.style.borderColor = 'red';
        //         }.bind(this),
        //         // locale: esLocale
        //
        //     });
        //
        //     calendar.render();
        // }.bind(this));
        // // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/Calendar-controller.js';
        //
        //

        // console.log({appVue: this.appDetails})
    }

    //
    // fetchDate(dateStr) {
    //     console.log(dateStr)
    //     // this.calendarDetails.innerHTML = dateStr
    //
    //     this.appDetails = null;
    //
    //     Vue.component('calendar-day-details-card', {
    //         data: function () {
    //             return {
    //                 count: 0,
    //                 dateStr: dateStr
    //             }
    //         },
    //         template: '<div>' +
    //             '<span>{{dateStr}}</span>' +
    //             '</div>'
    //     })
    //
    //     this.appDetails = new Vue({
    //         el: this.calendarDetails,
    //
    //         mounted: function () {
    //             console.log('mounted VUE');
    //         }
    //     });
    //
    //     // this.appDetails.$data.currentDate = dateStr
    //
    //     // console.log(this.appDetails.$data)
    // }
    //
    // selectEvent(title) {
    //     console.log(title)
    //     this.calendarDetails.innerHTML = title
    // }
}

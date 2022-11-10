import { Controller } from '@hotwired/stimulus';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
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

        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = this.element.querySelector('.calendar-container');

            let calendar = new Calendar(calendarEl, {
                plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'currentWeek,dayGridMonth'
                },
                views: {
                    currentWeek: {
                        type: 'listWeek',
                        duration: { days: 7 },
                        buttonText: 'Week view',


                    }
                },
                dayMaxEvents: true, // allow "more" link when too many events
                events: this.element.dataset.eventsSource,
                // locale: esLocale
            });

            calendar.render();
        }.bind(this));
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/Calendar-controller.js';
    }
}

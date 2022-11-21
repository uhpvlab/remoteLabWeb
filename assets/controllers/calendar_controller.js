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

        this.addForm = this.element.querySelector('form[name="booking_add"]')
        this.formBookingDateInput = this.addForm.querySelector('input[name="booking_add[bookingDate]"]')
        this.formBookingSubmit = this.addForm.querySelector('button[name="booking_add[submit]"]')
        this.currentDate = this.element.querySelector('p#currentDate')
        this.formContainer = this.element.querySelector('div#add_booking_container');
        console.log(this.formBookingDateInput)
        this.formBookingSubmit.addEventListener('click', function (e){
            e.preventDefault();
            // console.log({event: e, context: this, currentDate: window.currentDate.innerText})
            this.formBookingDateInput.value = window.currentDate.innerText
            console.log(this.formBookingDateInput.value)
            this.addForm.submit()

            // this.formContainer.innerHTML = $.ajax({
            //     url: $form.prop('action'),
            // });
        }.bind(this))
    }


}

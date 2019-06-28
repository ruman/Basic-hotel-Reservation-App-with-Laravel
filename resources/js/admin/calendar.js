import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import bootstrapPlugin from '@fullcalendar/bootstrap';

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new Calendar(calendarEl, {
    plugins: [ bootstrapPlugin, dayGridPlugin ],
    themSystem: 'bootstrap',
    header: {
    	left: 'prev today',
    	center: 'title',
    	right: 'dayGridMonth,timeGridWeek next'
    }
  });

  calendar.render();
});
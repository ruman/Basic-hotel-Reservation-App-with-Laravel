import { Calendar } from '@fullcalendar/core';

import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

import bootstrapPlugin from '@fullcalendar/bootstrap';

/*document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  alert('loading...');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'bootstrap' ],
    timeZone: 'UTC',
    themeSystem: 'bootstrap',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    events: 'https://fullcalendar.io/demo-events.json'
  });

  calendar.render();
});*/


document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new Calendar(calendarEl, {
    plugins: [ bootstrapPlugin, dayGridPlugin, timeGridPlugin ],
    themSystem: 'bootstrap',
    header: {
    	left: 'prev today',
    	center: 'title',
    	right: 'dayGridMonth,timeGridWeek next',
		},
    eventLimit: true, // allow "more" link when too many events
    events: 'hotels/getreservations',
    eventClick: function(info){
      info.jsEvent.preventDefault();
      let data = {};
        data.hotel = info.event.hotel;
        data.room = info.event.room;
        data.rate = info.event.rate;
        data.title = info.event.title;
      console.log(info);
    },
    eventColor: '#7AC35F',
    eventTextColor: '#FFF',
    eventTimeFormat: {
      hour: 'numeric',
      minute: '2-digit',
      omitZeroMinute: false,
      meridiem: 'narrow'
    },
  });

  calendar.render();
});



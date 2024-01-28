

@extends('layouts/contentNavbarLayout')

@section('title', 'Calendar - On Leave')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')

<script>

  //TOAST (SCRIPT)-----------------------------------------------------------
  document.addEventListener('DOMContentLoaded', function() {
    // Check for success message
    var successMessage = "{{ session('success') }}";
    if (successMessage) {
      var successToast = document.querySelector('.success-toast');
      var successBootstrapToast = new bootstrap.Toast(successToast);
      successBootstrapToast.show();
    }

    // Check for error message
    var errorMessage = "{{ session('error') }}";
    if (errorMessage) {
      var errorToast = document.querySelector('.error-toast');
      var errorBootstrapToast = new bootstrap.Toast(errorToast);
      errorBootstrapToast.show();
    }
  });
  //TOAST (SCRIPT)--------------------------------------------------------------
</script>

<!-- Success Toast -->
<div class="toast success-toast align-items-center text-white bg-primary border-0 ms-auto" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      {{ session('success') }}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!-- Error Toast -->
<div class="toast error-toast align-items-center text-white bg-danger border-0 ms-auto" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      {{ session('error') }}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!--TOAST (END)-->


<div class="row gy-4">
  <h2 class="mt-4">Calendar - On Leave</h2>
  <div class="col-md-12">
  
  <!-- Map Legend -->
  <div class="legend-box">
      <div class="map-legend">
        Annual Leave <span class="legend-item" style="background-color: blue;"></span>
        Sick / Emergency Leave <span class="legend-item" style="background-color: red;"></span>
        Unpaid Leave <span class="legend-item" style="background-color: black;"></span>
        Public Holiday <span class="legend-item" style="background-color: green;"></span>
      </div>
    </div>
    <style>
  .legend-box {
    background-color: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    display: inline-block; /* Ensure it only takes up the necessary width */
  }

  .map-legend {
    margin-bottom: 10px;
  }

  .legend-item {
    display: inline-block;
    width: 18px;
    height: 4px; /* Set the height to create a horizontal line */
    background-color: #000; /* Color for the line */
    margin-right: 8px;
  }

  .legend-item:nth-child(1) {
    background-color: #16b1ff !important;
  }

  .legend-item:nth-child(2) {
    background-color: red;
  }

  .legend-item:nth-child(3) {
    background-color: black;
  }

  .legend-item:nth-child(4) {
    background-color: green;
  }
</style>
<h3 class="mt-4" id='monthtitle'></h3>
      <div class="card">
          <div class="card-body">
              <div id='calendar'></div>
          </div>
      </div>
  </div>
</div>


<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
  // Malaysian public holidays
  var malaysianHolidays = [
        {
            title: 'New Year\'s Day',
            start: '2024-01-01',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Lunar New Year\'s Day',
            start: '2024-02-10',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Second Day of Lunar New Year',
            start: '2024-02-11',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Lunar New Year',
            start: '2024-02-12',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Good Friday',
            start: '2024-03-29',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Raya Aidilfitri Day 1',
            start: '2024-04-10',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Raya Aidilfitr Day 2',
            start: '2024-04-11',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Labor Day',
            start: '2024-05-01',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Wesak Day',
            start: '2024-05-22',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Gawai',
            start: '2024-06-01',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Gawai Holiday',
            start: '2024-06-02',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Agong\'s Birthday',
            start: '2024-06-03',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Gawai Holiday',
            start: '2024-06-04',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Hari Raya Haji',
            start: '2024-06-17',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Awal Muharram',
            start: '2024-07-07',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Awal Muharram Holiday',
            start: '2024-07-08',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Sarawak Day',
            start: '2024-07-22',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Merdeka Day',
            start: '2024-08-31',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Prophet Muhammad\'s Birthday',
            start: '2024-09-16',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Malaysia Day',
            start: '2024-09-16',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Malaysia Day Holiday',
            start: '2024-09-17',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Sarawak Governor\'s Birthday',
            start: '2024-10-12',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        {
            title: 'Christmas Day',
            start: '2024-12-25',
            allDay: true,
            backgroundColor: 'green', // Set a different color for holidays
            borderColor: 'green', // Set the border color
        },
        // Add more holidays as needed
    ];

  // Convert PHP array to JSON and assign it to a JavaScript variable
  var leaveEvents = @json($json);

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var monthTitleEl = document.getElementById('monthtitle');

    // Get the current date
    var currentDate = new Date();
    
    // Format the current date as 'YYYY-MM-DD'
    var formattedDate = currentDate.toISOString().split('T')[0];

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      initialDate: formattedDate,
      headerToolbar: {
   //   left: 'dayGridMonth,timeGridWeek,timeGridDay',
   //   center: 'title',
   //   left: 'dayGridMonth',
      left: 'dayGridMonth,dayGridWeek,dayGridDay',
      right: 'prev,today,next'
      },
      events: leaveEvents.concat(malaysianHolidays), // Combine leave events and holidays,
      viewDidMount: function(info) {
          // Update the month title
          monthTitleEl.innerText = info.view.title;
      },
      datesSet: function(info) {
          // Update the month title when the user navigates to a different month
          monthTitleEl.innerText = info.view.title;
      },
      eventClick: function(info) {
          // Handle event click - you can customize this part based on your needs
          alert('Description: ' + info.event.title);
      }
    });
    calendar.render();


  });

</script>

<style>

  .fc .fc-button-primary{
    background-color: #804be0 !important;
    border-color: #804be0 !important;
  }
</style>

@endsection

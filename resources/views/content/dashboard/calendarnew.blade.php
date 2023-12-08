

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
      <div class="card">
          <div class="card-body">
              <div id='calendar'></div>
          </div>
      </div>
  </div>
</div>


<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>

  // Convert PHP array to JSON and assign it to a JavaScript variable
  var leaveEvents = @json($json);

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      initialDate: '2023-11-07',
      headerToolbar: {
      left: 'dayGridMonth,timeGridWeek,timeGridDay',
      center: 'title',
      right: 'prev,today,next'
      },
      events: leaveEvents
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

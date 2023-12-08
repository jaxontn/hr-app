@extends('layouts/contentNavbarLayout')

@section('title', 'Apply Claim')

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


<!-- Basic with Icons -->
<div class="col-xxl">
  <div class="card mb-4" style="max-width: 691px;">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Claim Submission</h5> <small id="current-time" class="text-muted float-end"></small>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('submit-claim') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="fullname">Name</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="fullname2" class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
              <input type="text" class="form-control" id="fullname" placeholder={{ Auth::user()->username }} aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" readonly/>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="role">Role</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="role" class="input-group-text"><i class="mdi mdi-account-group"></i></span>
              <input type="text" id="role" class="form-control" placeholder="{{ Auth::user()->therole->name ? Auth::user()->therole->name : 'not assigned' }}" aria-label="ACME Inc." aria-describedby="basic-icon-default-company2" readonly/>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="department">Department</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="department2" class="input-group-text"><i class="mdi mdi-account-group"></i></span>
              <input type="text" id="department" class="form-control" placeholder="{{ Auth::user()->thedept->name ? Auth::user()->thedept->name : 'not assigned' }}" aria-label="ACME Inc." aria-describedby="basic-icon-default-company2" readonly/>
            </div>
          </div>
        </div>

        <!--Amount in MYR-->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="amount">Amount (MYR)</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="amount2" class="input-group-text"><i class="mdi mdi-currency-usd"></i></span>
              <input type="text" id="amount" name="amount" class="form-control" pattern="\d+(\.\d{1,2})?" placeholder="00.00" required/>
            </div>
          </div>
        </div>


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="receipt">Receipt</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <input type="file" id="receipt" name="receipt" class="form-control" required/>
            </div>
          </div>
        </div>


        <!--Calim Type selection-->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="claimType">Claim Type</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <select class="form-select" id="claimType" name="claimType" required>
                <option value="" selected disabled>Choose claim type</option>
                <option value="1">Utilities</option>
                <option value="2">Transport</option>
                <option value="3">Office Supplies</option>
                <option value="4">Miscellaneous</option>
              </select>
            </div>
          </div>
        </div>


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="reason">Reason for Claim</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="reason2" class="input-group-text"><i class="mdi mdi-message-outline"></i></span>
              <input type="text" id="reason" name="reason" class="form-control" placeholder="describe your reason" required/>
            </div>
          </div>
        </div>





        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Submit Claim</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- JavaScript to Update Current Time -->
<script>
  function updateCurrentTime() {
    var currentTimeElement = document.getElementById('current-time');
    if (currentTimeElement) {
      var currentTime = new Date();
      var hours = currentTime.getHours();
      var minutes = currentTime.getMinutes();
      var seconds = currentTime.getSeconds();

      // Add leading zero if needed
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      // Format the time as HH:MM:SS
      var formattedTime = hours + ':' + minutes + ':' + seconds;

      // Update the content
      currentTimeElement.textContent = 'TIME: ' + formattedTime;
    }
  }

  // Call the function initially
  updateCurrentTime();

  // Set an interval to update the time every second
  setInterval(updateCurrentTime, 1000);
</script>
@endsection

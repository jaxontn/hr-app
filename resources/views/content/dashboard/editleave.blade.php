@extends('layouts/contentNavbarLayout')

@section('title', 'Apply Leave')

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

<!-- Congratulations card -->
<div class="col-md-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-1">Hello {{ auth()->user()->username }}! 👋</h4>
        <p class="pb-0">Here's your <b>remaining</b> annual leave</p>
        <h4 class="text-primary mb-1">{{ max(0, auth()->user()->totalLeave - auth()->user()->usedLeave) }} Days in <?php echo date("Y"); ?></h4>
        <p class="mb-2 pb-1">You've used up <b>{{ auth()->user()->usedLeave }}</b> days of your leave</p>
        <a href="/my-leaves" class="btn btn-sm btn-primary">My Leaves</a>
      </div>
      <img src="{{asset('assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background">
      <img src="{{asset('assets/img/illustrations/trophy.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4 pb-2" width="83" alt="view sales">
    </div>
</div>
  <!--/ Congratulations card -->

<br>


<!-- Basic with Icons -->
<div class="col-xxl">
  <div class="card mb-4" style="max-width: 691px;">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">Leave Configuration</h5> <small id="current-time" class="text-muted float-end"></small>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('update-leave-number') }}">
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




        <!--Leave type selection-->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="leaveType">Action</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <select class="form-select"  id="leaveType" name="leaveType" required>
                <option disabled selected>Select action</option>
                <option value="1">Add</option>
                <option value="2">Deduct</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Number of leaves selection -->
        <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="numberOfLeaves">Amount</label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
            <button class="btn btn-outline-secondary" type="button" onclick="adjustLeaves(-1)">-</button>
            <input type="text" class="form-control text-center" id="numberOfLeaves" name="numberOfLeaves" value="1" readonly>
            <button class="btn btn-outline-secondary" type="button" onclick="adjustLeaves(1)">+</button>
            </div>
        </div>
        </div>

        <script>
        // Function to adjust the number of leaves
        function adjustLeaves(amount) {
            var numberOfLeavesInput = document.getElementById("numberOfLeaves");
            var currentLeaves = parseInt(numberOfLeavesInput.value);

            // Ensure the number of leaves is greater than or equal to 1
            if (currentLeaves + amount >= 1) {
            numberOfLeavesInput.value = currentLeaves + amount;
            }
        }
        </script>

        


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="reason">Reason</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="reason2" class="input-group-text"><i class="mdi mdi-message-outline"></i></span>
              <input type="text" id="reason" name="reason" class="form-control" placeholder="describe your reason" required/>
            </div>
          </div>
        </div>





        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Submit Request</button>
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





<!---->
<div class="row gy-4">

  <!-- Data Tables -->
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">


        <div class="card">
          <h5 class="card-header d-flex justify-content-between">
            {{ $heading }}
          </h5>
          <div class="table-responsive text-nowrap">


            <table class="table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">Remind</th>
                  <th class="text-truncate">Staff</th>
                  <th class="text-truncate">Action</th>
                  <th class="text-truncate">Days</th>
                  <th class="text-truncate">Reason</th>
                  <th class="text-truncate">Status</th>
                  <th class="text-truncate">Created</th>

                </tr>
              </thead>
              <tbody>
                @foreach($leave as $l)
                <tr>
                  <td>{{ $l->id }}</td>
                  <td>
                      <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reminder-{{ $l->id }}">Notify</button>
                  </td>
                  <td>{{ $l->staff->username }}</td>
                  <!--action-->
                  <td>
                    @if($l->action == '1')
                        <span class="badge bg-label-success rounded-pill">Add</span>
                    @elseif($l->action == '2')
                        <span class="badge bg-label-danger rounded-pill">Deduct</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge rounded-pill">{{ $l->action }}</span>
                    @endif
                  </td>
                  <td>{{ $l->amount }}</td>
                  <td class="max-width-td">{{ $l->reason }}</td>
                  <td>
                    @if($l->status == '1')
                        <span class="badge bg-label-success rounded-pill">Approved</span>
                    @elseif($l->status == '0')
                        <span class="badge bg-label-danger rounded-pill">Rejected</span>
                    @elseif($l->status == '2')
                        <span class="badge bg-label-warning rounded-pill">Pending</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge rounded-pill">{{ $l->status }}</span>
                    @endif
                  </td>

                  <td>{{ $l->created_date }}</td>
                </tr>


                <div class="modal fade" id="reminder-{{ $l->id }}" tabindex="-1" aria-labelledby="reminderLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStaffLabel">Remind Manager</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit-leave-number-reminder', ['id' => $l->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="manager" class="form-label">Choose Manager</label>
                                        <select class="form-select text-black" style="background-color: white;" id="manager-{{ $l->id }}" name="manager" autocomplete="off" required="">
                                            <option disabled >Select department</option>
                                            @foreach($managers as $m)
                                                <option value="{{ $m->id }}">{{ $m->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Open Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
              </tbody>
            </table>


          </div>
        </div>


      </div>
    </div>
  </div>
  <!--/ Data Tables -->

  <style>
    .max-width-td {
        min-width: 200px; /* Set your desired maximum width */
        max-width: 300px;
        white-space: normal; /* Allow the text to wrap */
    }
  </style>

</div>
@endsection

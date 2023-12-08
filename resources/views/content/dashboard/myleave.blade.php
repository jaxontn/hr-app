@extends('layouts/contentNavbarLayout')

@section('title', 'Leave')

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
                  <th class="text-truncate">Type</th>
                  <th class="text-truncate">Start Date</th>
                  <th class="text-truncate">End Date</th>
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
                  <!--keave type-->
                  <td>
                    @if($l->type == 1)
                        <span class="badge bg-label-primary rounded-pill">Annual Leave</span>
                    @elseif($l->type == 2)
                        <span class="badge bg-label-primary rounded-pill">Sick Leave</span>
                    @elseif($l->type == 3)
                        <span class="badge bg-label-primary rounded-pill">Emergency Leave</span>
                    @elseif($l->type == 4)
                        <span class="badge bg-label-primary rounded-pill">Unpaid Leave</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge bg-label-primary rounded-pill">undefined</span>
                    @endif
                  </td>
                  <td>{{ $l->startDate }}</td>
                  <td>{{ $l->endDate }}</td>
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
                                <form method="POST" action="{{ route('leave-reminder', ['id' => $l->id]) }}">
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
<script src="{{ asset('js/reloadTimer.js') }}"></script>
@endsection

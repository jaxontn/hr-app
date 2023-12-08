@extends('layouts/contentNavbarLayout')

@section('title', 'Claim')

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
                  <th class="text-truncate">Amount</th>
                  <th class="text-truncate">Reason</th>
                  <th class="text-truncate">Attachment</th>
                  <th class="text-truncate">Remarks</th>
                  <th class="text-truncate">Status</th>
                  <th class="text-truncate">Created</th>
                </tr>
              </thead>
              <tbody>
                @foreach($claim as $c)
                <tr>
                  <td>{{ $c->id }}</td>
                  <td>
                      <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reminder-{{ $c->id }}">Notify</button>
                  </td>
                  <td>{{ $c->staff->username }}</td>
                  <!--claim type-->
                  <td>
                    @if($c->type == 1)
                        <span class="badge bg-label-primary rounded-pill">Utilities</span>
                    @elseif($c->type == 2)
                        <span class="badge bg-label-primary rounded-pill">Transport</span>
                    @elseif($c->type == 3)
                        <span class="badge bg-label-primary rounded-pill">Office Supplies</span>
                    @elseif($c->type == 4)
                        <span class="badge bg-label-primary rounded-pill">Miscellaneous</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge bg-label-primary rounded-pill">undefined</span>
                    @endif
                  </td>
                  <td>{{ $c->amount }}</td>
                  <td class="max-width-td">{{ $c->reason }}</td>
                  <td>
                    @if(!empty($c->attachment)) <!-- Check if there's an image for the wallet -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#details-image-modal-{{ $c->id }}">View Image</a>
                    @endif
                  </td>
                  <td>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#details-remark-modal-{{ $c->id }}">View Details</a>
                  </td>
                  <td>
                      @switch($c->status)
                          @case('2')
                              <span class="badge bg-label-warning rounded-pill">Pending</span>
                          @break

                          @case('1')
                              <span class="badge bg-label-success rounded-pill">Forwarded to Finance</span>
                          @break

                          @case('0')
                              <span class="badge bg-label-danger rounded-pill">Rejected by Manager</span>
                          @break

                          @case('3')
                              <span class="badge bg-label-success rounded-pill">Approved by Finance</span>
                          @break

                          @case('4')
                              <span class="badge bg-label-danger rounded-pill">Rejected by Finance</span>
                          @break

                          @case('5')
                              <span class="badge bg-label-success rounded-pill">Reimbursed</span>
                          @break

                          @case('6')
                              <span class="badge bg-label-warning rounded-pill">Escalated to Director</span>
                          @break

                          @case('7')
                              <span class="badge bg-label-success rounded-pill">Approved by Director</span>
                          @break

                          @case('8')
                              <span class="badge bg-label-danger rounded-pill">Rejected by Director</span>
                          @break

                          @default
                              <span class="badge bg-label-primary rounded-pill">Unknown Status</span>
                      @endswitch
                  </td>

                  <td>{{ $c->created_date }}</td>
                </tr>

                <div class="modal fade" id="details-image-modal-{{ $c->id }}" tabindex="-1" aria-labelledby="detailsImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsImageModalLabel">Attachment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <img src="{{ env('APP_URL') . '/'. $c->attachment }}" alt="Details Image" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="details-remark-modal-{{ $c->id }}" tabindex="-1" aria-labelledby="detailsRemarkModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsRemarkModalLabel">Remarks</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            <p><b>Remark by manager:</b> <br>{{ $c->remark_manager}}</p>
                            <p><b>Remark by finance:</b> <br>{{ $c->remark_finance}}</p>
                            <p><b>Remark by director:</b> <br>{{ $c->remark_director}}</p>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="reminder-{{ $c->id }}" tabindex="-1" aria-labelledby="reminderLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStaffLabel">Remind Upper Level</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('claim-reminder', ['id' => $c->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="manager" class="form-label">Choose Manager</label>
                                        <select class="form-select text-black" style="background-color: white;" id="manager-{{ $c->id }}" name="manager" autocomplete="off" required="">
                                            <option disabled >Select department</option>
                                            @foreach($upper as $u)
                                                <option value="{{ $u->id }}">{{ $u->username }}</option>
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

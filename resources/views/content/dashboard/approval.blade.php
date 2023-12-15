@extends('layouts/contentNavbarLayout')

@section('title', 'Workspace')

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

  <h2 class="mt-4">Workspace</h2>

  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager' || optional(Auth::user())->therole->permission == 'master'))
  <!-- Data Tables -->
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">


        <div class="card">
          <h5 class="card-header d-flex justify-content-between">
            Leave Approval - Pending
          </h5>
          <div class="table-responsive text-nowrap">


            <table class="table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">Staff</th>
                  <th class="text-truncate">Type</th>
                  <th class="text-truncate">Start Date</th>
                  <th class="text-truncate">End Date</th>
                  <th class="text-truncate max-width-td">Reason</th>
                  <th class="text-truncate">Status</th>
                  <th class="text-truncate">Created</th>
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager'))
                  <th class="text-truncate">Operator Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($leave as $l)
                <tr>
                  <td>{{ $l->id }}</td>
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
                  <td class="max-width-td">{{ $l->reason}}</td>
                  <td><span class="badge bg-label-warning rounded-pill">Pending</span></td>
                  <td>{{ $l->created_date }}</td>
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager'))
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="/leave-approve/{{$l->id}}" ><i class="mdi mdi-check-decagram me-1"></i> Approve</a>
                        <a class="dropdown-item" href="/leave-reject/{{$l->id}}" ><i class="mdi mdi-minus-circle me-1"></i> Reject</a>
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>


          </div>
        </div>


      </div>
    </div>
  </div>
  <!--/ Data Tables -->
  @endif


  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager' || optional(Auth::user())->therole->permission == 'finance' || optional(Auth::user())->therole->permission == 'director' || optional(Auth::user())->therole->permission == 'master'))
  <!-- Data Tables -->
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">


        <div class="card">
          <h5 class="card-header d-flex justify-content-between">
            Claim Approval - Pending
          </h5>
          <div class="table-responsive text-nowrap">


            <table class="table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">Staff</th>
                  <th class="text-truncate">Type</th>
                  <th class="text-truncate">Amount</th>
                  <th class="text-truncate">Reason</th>
                  <th class="text-truncate">Attachment</th>
                  <th class="text-truncate">Status</th>
                  <th class="text-truncate">Created</th>
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager' || optional(Auth::user())->therole->permission == 'finance' || optional(Auth::user())->therole->permission == 'director'))
                  <th class="text-truncate">Operator Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($claim as $c)
                <tr>
                  <td>{{ $c->id }}</td>
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
                  <td class="max-width-td">{{ $c->reason}}</td>
                  <td>
                    @if(!empty($c->attachment)) <!-- Check if there's an image for the wallet -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#details-image-modal-{{ $c->id }}">View Image</a>
                    @endif
                  </td>
                  {{--<td>N/A</td>--}}
                  <td><span class="badge bg-label-warning rounded-pill">{{ $c->status == 7 ? 'Approved by Director' : 'Pending'}}</span></td>
                  <td>{{ $c->created_date }}</td>
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager' || optional(Auth::user())->therole->permission == 'finance' || optional(Auth::user())->therole->permission == 'director'))
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        {{--<a class="dropdown-item" href="/claim-approve/{{$c->id}}" ><i class="mdi mdi-check-decagram me-1"></i> Approve</a>
                        <a class="dropdown-item" href="/claim-reject/{{$c->id}}" ><i class="mdi mdi-minus-circle me-1"></i> Reject</a>--}}
                        @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager'))
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/1" ><i class="mdi mdi-check-decagram me-1"></i> Approve</a>
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/0" ><i class="mdi mdi-minus-circle me-1"></i> Reject</a>
                        @endif
                        @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'finance'))
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/6" ><i class="mdi mdi-minus-circle me-1"></i> Escalate</a>
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/3" ><i class="mdi mdi-check-decagram me-1"></i> Approve</a>
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/4" ><i class="mdi mdi-minus-circle me-1"></i> Reject</a>
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/5" ><i class="mdi mdi-minus-circle me-1"></i> Reimbursed</a>
                        @endif
                        @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'director'))
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/7" ><i class="mdi mdi-check-decagram me-1"></i> Approve</a>
                        <a class="dropdown-item" href="/update-claim/{{$c->id}}/8" ><i class="mdi mdi-minus-circle me-1"></i> Reject</a>
                        @endif
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>

                <div class="modal fade" id="details-image-modal-{{ $c->id }}" tabindex="-1" aria-labelledby="detailsImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsImageModalLabel">Attachment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <img src="https://loveu77.net/8ik{{ '/'. $c->attachment }}" alt="Details Image" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
  @endif

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

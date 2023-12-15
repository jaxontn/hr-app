@extends('layouts/contentNavbarLayout')

@section('title', 'Claim History')

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
            Claim History
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
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission != 'manager' && optional(Auth::user())->therole->permission != 'director'))
                  <th class="text-truncate">Action</th>
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
                  <td class="max-width-td">{{ $c->reason }}</td>
                  <td>
                    @if(!empty($c->attachment)) <!-- Check if there's an image for the wallet -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#details-image-modal-{{ $c->id }}">View Image</a>
                    @endif
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
                  @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission != 'manager' && optional(Auth::user())->therole->permission != 'director'))
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editClaim-{{ $c->id }}"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                        {{--<a class="dropdown-item" href="javascript:void(0);" ><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>--}}
                      </div>
                    </div>
                  </td>
                  @endif
                </tr>




                <div class="modal fade" id="editClaim-{{ $c->id }}" tabindex="-1" aria-labelledby="editClaimLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editClaimLabel">Edit Role - ID: {{ $c->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit-claim-history', ['id' => $c->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="staff" class="form-label">Staff</label>
                                        <input type="text" name="staff" class="form-control" id="staff-{{ $c->id }}" placeholder="{{ $c->staff->username }}" value="{{ $c->staff->username }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="text" name="amount" class="form-control" id="amount-{{ $c->id }}" placeholder="{{ $c->amount }}" value="{{ $c->amount }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea type="text"  name="reason" class="form-control" id="reason-{{ $c->id }}" placeholder="{{ $c->reason }}" value="{{ $c->staff->reason }}" autocomplete="off" readonly></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="statusHistory" class="form-label">Status - Update Here</label>
                                        <select class="form-select text-black" style="background-color: white;" id="statusHistory" name="statusHistory" required="">
                                            <option selected disabled >Select permission</option>
                                            @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'manager' || optional(Auth::user())->therole->permission == 'master'))
                                            <option value="1" {{ "1" == $c->status ? 'selected' : '' }} >Approved</option>
                                            <option value="0" {{ "0" == $c->status ? 'selected' : '' }} >Rejected</option>
                                            <option value="2" {{ "2" == $c->status ? 'selected' : '' }} >Pending</option>
                                            @endif
                                            @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'finance' || optional(Auth::user())->therole->permission == 'master'))
                                            <option value="3" {{ "3" == $c->status ? 'selected' : '' }} >Approved</option>
                                            <option value="4" {{ "4" == $c->status ? 'selected' : '' }} >Rejected</option>
                                            <option value="5" {{ "5" == $c->status ? 'selected' : '' }} >Reimbursed</option>
                                            <option value="6" {{ "6" == $c->status ? 'selected' : '' }} >Escalated</option>
                                            @endif
                                            @if(optional(Auth::user())->therole->permission && (optional(Auth::user())->therole->permission == 'director' || optional(Auth::user())->therole->permission == 'master'))
                                            <option value="7" {{ "7" == $c->status ? 'selected' : '' }} >Approved</option>
                                            <option value="8" {{ "8" == $c->status ? 'selected' : '' }} >Rejected</option>
                                            @endif
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="details-image-modal-{{ $c->id }}" tabindex="-1" aria-labelledby="detailsImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsImageModalLabel">Attachment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <!--<img src="{{ env('APP_URL') . '/'. $c->attachment }}" alt="Details Image" class="img-fluid">-->
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

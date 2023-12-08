@extends('layouts/contentNavbarLayout')

@section('title', 'Leave History')

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
            Leave History
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
                  <th class="text-truncate">Reason</th>
                  <th class="text-truncate">Status</th>
                  <th class="text-truncate">Created</th>
                  <th class="text-truncate">Action</th>
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
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editLeave-{{ $l->id }}"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                        {{--<a class="dropdown-item" href="javascript:void(0);" ><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>--}}
                      </div>
                    </div>
                  </td>
                </tr>



                <div class="modal fade" id="editLeave-{{ $l->id }}" tabindex="-1" aria-labelledby="editLeaveLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editLeaveLabel">Edit Role - ID: {{ $l->id }} -> {{ $l->staff->username }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit-leave-history', ['id' => $l->id]) }}">
                                    @csrf
                                    {{--<div class="mb-3">
                                        <label for="staff" class="form-label">Staff</label>
                                        <input type="text" name="staff" class="form-control" id="staff-{{ $l->id }}" placeholder="{{ $l->staff->username }}" value="{{ $l->staff->username }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="startdate" class="form-label">Start Date</label>
                                        <input type="text" name="startdate" class="form-control" id="startdate-{{ $l->id }}" placeholder="{{ $l->startDate }}" value="{{ $l->staff->startDate }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="enddate" class="form-label">End Date</label>
                                        <input type="text" name="enddate" class="form-control" id="enddate-{{ $l->id }}" placeholder="{{ $l->endDate }}" value="{{ $l->staff->endDate }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea type="text"  name="reason" class="form-control" id="reason-{{ $l->id }}" placeholder="{{ $l->reason }}" value="{{ $l->staff->reason }}" autocomplete="off" readonly></textarea>
                                    </div>--}}
                                    <div class="mb-3">
                                        <label for="statusHistory" class="form-label">Status - Update Here</label>
                                        <select class="form-select text-black" style="background-color: white;" id="statusHistory" name="statusHistory" required="">
                                            <option selected disabled >Select permission</option>
                                            <option value="1" {{ "1" == $l->status ? 'selected' : '' }} >Approved</option>
                                            <option value="0" {{ "0" == $l->status ? 'selected' : '' }} >Rejected</option>
                                            <option value="2" {{ "2" == $l->status ? 'selected' : '' }} >Pending</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Save changes</button>
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

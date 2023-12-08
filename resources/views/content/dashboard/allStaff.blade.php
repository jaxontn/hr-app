@extends('layouts/contentNavbarLayout')

@section('title', 'All Staff')

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

<!--ADD NEW MODAL (START)-->
<div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="generateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="generateModalLabel">Add New Staff</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('register-staff') }}">
                  @csrf
                  <div class="mb-3">
                      <label for="username" class="form-label">Username</label>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required="">
                  </div>
                  <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" autocomplete="off" required="">
                  </div>
                  <div class="mb-3">
                      <label for="dept" class="form-label">Department</label>
                      <select class="form-select text-black" style="background-color: white;" id="dept" name="dept" required="">
                          <option selected disabled >Select department</option>
                          @foreach($dept as $d)
                              <option value="{{ $d->id }}">{{ $d->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="role" class="form-label">Role</label>
                      <select class="form-select text-black" style="background-color: white;" id="role" name="role" required="">
                          <option selected disabled >Select role</option>
                          @foreach($role as $r)
                              <option value="{{ $r->id }}">{{ $r->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="contact" class="form-label">WhatsApp Number</label>
                      <input type="contact" class="form-control" id="contact" placeholder="+60123456789" name="contact" autocomplete="off" required="">
                  </div>
                  <div class="mb-3">
                      <label for="totalLeave" class="form-label">Set Total Leave</label>
                      <input type="totalLeave" class="form-control" id="totalLeave" placeholder="14" name="totalLeave" autocomplete="off" required="">
                  </div>
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-warning">Save changes</button>
              </form>
          </div>
      </div>
  </div>
</div>
<!--ADD NEW MODAL (END)-->

<div class="row gy-4">


  <!-- Data Tables -->
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">


        <div class="card">
          <h5 class="card-header d-flex justify-content-between">
            All Staff
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateModal"><i class="mdi mdi-plus me-sm-1"></i>Add New Staff</button>
          </h5>
          <div class="table-responsive text-nowrap">


            <table class="table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">User</th>
                  <th class="text-truncate">Role</th>
                  <th class="text-truncate">Department</th>
                  <th class="text-truncate">Contact</th>
                  <th class="text-truncate">Total Allocated Leave</th>
                  <th class="text-truncate">Remaining Leave</th>
                  {{--<th class="text-truncate">Used Leave</th>--}}
                  <th class="text-truncate">Created Date</th>
                  <th class="text-truncate">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($staffs as $staff)
                <tr>
                  <td>
                    {{ $staff->id }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-3">
                        <img src="{{asset('assets/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle">
                      </div>
                      <div>
                        <h6 class="mb-0 text-truncate">{{ $staff->username }}</h6>

                      </div>
                    </div>
                  </td>
                  <td class="text-truncate">
                    @php
                        /*switch($staff->role) {
                            case 'operator':
                                $class = 'mdi-chart-donut text-success';
                                break;
                            case 'master':
                                $class = 'mdi-laptop text-danger';
                                break;
                            case 'finance':
                                $class = 'mdi mdi-currency-usd text-warning';
                                break;
                            case 'leader':
                                $class = 'mdi mdi-account-group text-info';
                                break;
                            case 'staff':
                                $class = 'mdi mdi-account text-primary';
                                break;
                            default:
                                $class = 'default-class';
                        }*/
                    @endphp

                    {{--<i class="{{ $class }} mdi  mdi-24px me-1"></i>--}}
                    {{ $staff->therole->name ?? 'N/A' }}
                </td>

                  <td class="text-truncate">{{ $staff->thedept->name ?? 'N/A' }}</td>
                  <td class="text-truncate">{{ $staff->contact ?? 'N/A' }}</td>
                  <td class="text-truncate">{{ $staff->totalLeave }}</td>
                  <td class="text-truncate">{{ $staff->totalLeave - $staff->usedLeave }}</td>
                  {{--<td class="text-truncate">{{ $staff->usedLeave }}</td>--}}
                  <td class="text-truncate">{{ $staff->created_date }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editStaff-{{ $staff->id }}"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                        {{--<a class="dropdown-item" href="javascript:void(0);" ><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>--}}
                      </div>
                    </div>
                  </td>
                </tr>


                <div class="modal fade" id="editStaff-{{ $staff->id }}" tabindex="-1" aria-labelledby="editStaffLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editStaffLabel">Edit Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit-staff-backend', ['id' => $staff->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username-{{ $staff->id }}" placeholder="{{ $staff->username }}" value="{{ $staff->username }}" autocomplete="off" required="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password-{{ $staff->id }}" placeholder="Enter new password" name="password" autocomplete="current-password" required="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="dept" class="form-label">Change Department</label>
                                        <select class="form-select text-black" style="background-color: white;" id="dept-{{ $staff->id }}" name="dept" autocomplete="off" required="">
                                            <option disabled >Select department</option>
                                            @foreach($dept as $d)
                                                <option value="{{ $d->id }}" {{ $staff->thedept->name == $d->name ? 'selected' : '' }}>{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Change Role</label>
                                        <select class="form-select text-black" style="background-color: white;" id="role-{{ $staff->id }}" name="role" autocomplete="off" required="">
                                            <option disabled >Select role</option>
                                            @foreach($role as $r)
                                                <option value="{{ $r->id }}" {{ $staff->therole->name == $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalLeave" class="form-label">Configure Total Leave</label>
                                        <input type="text" name="totalLeave" class="form-control" id="totalLeave-{{ $staff->id }}" placeholder="{{ $staff->totalLeave }}" value="{{ $staff->totalLeave }}" autocomplete="off" required="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="usedLeave" class="form-label">Configure Used Leave</label>
                                        <input type="text" name="usedLeave" class="form-control" id="usedLeave-{{ $staff->id }}" placeholder="{{ $staff->usedLeave }}" value="{{ $staff->usedLeave }}" autocomplete="off" required="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="whatsapp" class="form-label">Update WhatsApp Number</label>
                                        <input type="text" name="whatsapp" class="form-control" id="whatsapp-{{ $staff->id }}" placeholder="{{ $staff->contact ?? '+60123456789' }}" value="{{ $staff->contact }}" autocomplete="off" required="">
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
</div>
@endsection

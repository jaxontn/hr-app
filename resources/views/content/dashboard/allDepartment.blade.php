@extends('layouts/contentNavbarLayout')

@section('title', 'All Department')

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
              <h5 class="modal-title" id="generateModalLabel">Add New Department</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST" action="{{ route('register-department') }}">
                  @csrf
                  <div class="mb-3">
                      <label for="username" class="form-label">Name</label>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Enter Department Name" required="">
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
            All Department
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateModal"><i class="mdi mdi-plus me-sm-1"></i>Add New Department</button>
          </h5>
          <div class="table-responsive text-nowrap">


            <table class="table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">Department</th>
                  <th class="text-truncate">Created Date</th>
                  <th class="text-truncate">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($department as $d)
                <tr>
                  <td>
                    {{ $d->id }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        <h6 class="mb-0 text-truncate">{{ $d->name }}</h6>

                      </div>
                    </div>
                  </td>

                  <td class="text-truncate">{{ $d->created_date }}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editDepartment-{{ $d->id }}"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                        {{--<a class="dropdown-item" href="javascript:void(0);" ><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>--}}
                      </div>
                    </div>
                  </td>
                </tr>


                <div class="modal fade" id="editDepartment-{{ $d->id }}" tabindex="-1" aria-labelledby="editDepartmentLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDepartmentLabel">Edit Department</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit-department-backend', ['id' => $d->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Name</label>
                                        <input type="text" name="username" class="form-control" id="username-{{ $d->id }}" placeholder="{{ $d->name }}" value="{{ $d->name }}" autocomplete="off" required="">
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

@extends('layouts/blankLayout')

@section('title', 'Leave Approval')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Login -->
      <div class="card p-2">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20,"withbg"=>'fill: #fff;'])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName')}}</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-2">
          <div class="text-center">
            <h4 class="mb-2"><b>Leave Approval</b></h4>
            <p class="mb-4">Requested by {{ $leave->staff->username }}</p>
            @switch($leave->status)
                          @case('2')
                              <p class="badge bg-label-warning rounded-pill">Pending</p>
                          @break

                          @case('1')
                              <p class="badge bg-label-success rounded-pill">Approved by Manager</p>
                          @break

                          @case('0')
                              <p class="badge bg-label-danger rounded-pill">Rejected by Manager</p>
                          @break

                          @case('3')
                              <p class="badge bg-label-success rounded-pill">Approved by Finance</p>
                          @break

                          @case('4')
                              <p class="badge bg-label-danger rounded-pill">Rejected by Finance</p>
                          @break

                          @case('5')
                              <p class="badge bg-label-success rounded-pill">Reimbursed</p>
                          @break

                          @case('6')
                              <p class="badge bg-label-warning rounded-pill">Escalated to Director</p>
                          @break

                          @case('7')
                              <p class="badge bg-label-success rounded-pill">Approved by Director</p>
                          @break

                          @case('8')
                              <p class="badge bg-label-danger rounded-pill">Rejected by Director</p>
                          @break

                          @default
                              <p class="badge bg-label-primary rounded-pill">Unknown Status</p>
            @endswitch


          </div>

          <form id="leaveApprovalForm" class="mb-3" action="{{ route('submit-leave-approval', ['leaveID' => $leave->id, 'id' => $staff->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="leave_id" value="{{ $leave->id }}">
            <input type="hidden" name="action" value="" id="actionInput"> <!-- Add a hidden field for action -->

            <!-- Display leave details -->
            <p><b>Start Date:</b> <br>{{ $leave->startDate }}</p>
            <p><b>End Date:</b> <br>{{ $leave->endDate }}</p>
            <p><b>Days: </b> <br>{{ $weekDays }} working days</p>
            <p><b>Leave Type: </b> <br>
                    @if($leave->type == 1)
                        <span class="badge bg-label-primary rounded-pill">Annual Leave</span>
                    @elseif($leave->type == 2)
                        <span class="badge bg-label-primary rounded-pill">Sick Leave</span>
                    @elseif($leave->type == 3)
                        <span class="badge bg-label-primary rounded-pill">Emergency Leave</span>
                    @elseif($leave->type == 4)
                        <span class="badge bg-label-primary rounded-pill">Unpaid Leave</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge bg-label-primary rounded-pill">undefined</span>
                    @endif
            </p>
            <p><b>Reason:</b> <br>{{ $leave->reason }}</p>
            <div id="buttonSection">
                <!-- Approve and Reject buttons in a single row -->
                <div class="mb-3 d-flex justify-content-between">
                    <button class="btn btn-danger w-48" type="button" onclick="showPasswordInput(0)">Reject</button>
                    <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(1)">Approve</button>
                </div>
            </div>

            <!-- Password input and Confirm button -->
            <div id="passwordSection" class="mb-3 text-center" style="display: none;">
              <p>Dear {{ $staff->username}}, please confirm your password below.</p>
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">

                            <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                            <label for="password">Password</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                </div>

                <!-- Confirm button -->
                <button class="btn btn-primary mt-3" type="submit" >Confirm</button>
            </div>

        </form>

        <script>
            function showPasswordInput(action) {
                // Set the value of the hidden input for action
                document.getElementById('actionInput').value = action;

                // Hide buttons
                document.getElementById('buttonSection').style.display = 'none';

                // Show password input and confirm button
                document.getElementById('passwordSection').style.display = 'block';
            }
        </script>

        </div>

      </div>
      <!-- /Login -->
      <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
    </div>
  </div>
</div>
@endsection

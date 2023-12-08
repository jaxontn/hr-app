@extends('layouts/blankLayout')

@section('title', 'Claim Approval')

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
            <h4 class="mb-2"><b>Claim Approval</b></h4>
            <p class="mb-4">Requested by {{ $claim->staff->username }}</p>
            @switch($claim->status)
                          @case('2')
                              <p class="badge bg-label-warning rounded-pill">Pending</p>
                          @break

                          @case('1')
                              <p class="badge bg-label-success rounded-pill">Forwarded to Finance</p>
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

          <form id="claimApprovalForm" class="mb-3" action="{{ route('submit-claim-approval', ['claimID' => $claim->id, 'id' => $staff->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="claim_id" value="{{ $claim->id }}"> <!-- Add a hidden field for claim_id -->
            <input type="hidden" name="action" value="" id="actionInput"> <!-- Add a hidden field for action -->

            <!-- Display claim details -->
            <p><b>Amount:</b> <br>RM{{ $claim->amount }}</p>
            <p><b>Claim Type: </b> <br>
                  	@if($claim->type == 1)
                        <span class="badge bg-label-primary rounded-pill">Utilities</span>
                    @elseif($claim->type == 2)
                        <span class="badge bg-label-primary rounded-pill">Transport</span>
                    @elseif($claim->type == 3)
                        <span class="badge bg-label-primary rounded-pill">Office Supplies</span>
                    @elseif($claim->type == 4)
                        <span class="badge bg-label-primary rounded-pill">Miscellaneous</span>
                    @else
                        <!-- Handle other cases or provide a default -->
                        <span class="badge bg-label-primary rounded-pill">undefined</span>
                    @endif
            </p>
            <p><b>Reason:</b> <br>{{ $claim->reason }}</p>
            <p><b>Attachment:</b> <br><a href="#" data-bs-toggle="modal" data-bs-target="#details-image-modal-{{ $claim->id }}">View Image</a></p>
            <!--IF $claim->remark_manager not null, show remark-->
            @if($claim->remark_manager  != null)
            <p><b>Remark by Manager:</b> <br>{{ $claim->remark_manager }}</p>
            @endif

            <!--IF $claim->remark_finance not null, show remark-->
            @if($claim->remark_finance != null)
            <p><b>Remark by Finance:</b> <br>{{ $claim->remark_finance }}</p>
            @endif

            <!--IF $claim->remark_director not null, show remark-->
            @if($claim->remark_director != null)
            <p><b>Remark by Director:</b> <br>{{ $claim->remark_director }}</p>
            @endif

            <div class="modal fade" id="details-image-modal-{{ $claim->id }}" tabindex="-1" aria-labelledby="detailsImageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsImageModalLabel">Attachment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <img src="{{ env('APP_URL') . '/'. $claim->attachment }}" alt="Details Image" class="img-fluid">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="buttonSection">
              <!--ADD REMARK TEXAREA HERE-->
              <div class="mb-3">
                <div class="form-floating form-floating-outline">
                  <textarea class="form-control" id="remark" name="remark" placeholder="Leave a remark here" style="height: 100px"></textarea>
                  <label for="remark">Remark as {{ $staff->therole->permission }}</label>
                </div>
              </div>
                <!-- Approve and Reject buttons in a single row -->
                <div class="mb-3 d-flex justify-content-between">
                  @if($staff->therole->permission == 'manager' || $staff->therole->permission == 'master')
                  <button class="btn btn-danger w-48" type="button" onclick="showPasswordInput(0)">Reject</button>
                  <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(1)">Approve</button>
                  @endif
                  @if($staff->therole->permission == 'finance' || $staff->therole->permission == 'master')
                  <button class="btn btn-danger w-48" type="button" onclick="showPasswordInput(4)">Reject</button>
                  <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(3)">Approve</button>

                  @endif
                  @if($staff->therole->permission == 'director' || $staff->therole->permission == 'master')
                  <button class="btn btn-danger w-48" type="button" onclick="showPasswordInput(8)">Reject</button>
                  <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(7)">Approve</button>
                  @endif
                </div>

                <div class="mb-3 d-flex justify-content-between">
                  @if($staff->therole->permission == 'finance' || $staff->therole->permission == 'master')
                  <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(5)">Reimbursed</button>
                  <button class="btn btn-success w-48" type="button" onclick="showPasswordInput(6)">Escalate</button>
                  @endif
                </div>
            </div>

            <div id="passwordSection" class="mb-3 text-center" style="display:none">
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



            <!-- Password input -->
            {{--<div class="mb-3">
              <div class="form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                    <label for="password">Password</label>
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                </div>
              </div>
            </div>--}}

            <!-- Approve and Reject buttons in a single row -->
            {{--<div class="mb-3 d-flex justify-content-between">
              @if($staff->therole->permission == 'manager' || $staff->therole->permission == 'master')
              <button class="btn btn-danger w-48" type="submit" name="action" value="0">Reject</button>
              <button class="btn btn-success w-48" type="submit" name="action" value="1">Approve</button>
              @endif
              @if($staff->therole->permission == 'finance' || $staff->therole->permission == 'master')
              <button class="btn btn-danger w-48" type="submit" name="action" value="4">Reject</button>
              <button class="btn btn-success w-48" type="submit" name="action" value="3">Approve</button>

              @endif
              @if($staff->therole->permission == 'director' || $staff->therole->permission == 'master')
              <button class="btn btn-danger w-48" type="submit" name="action" value="8">Reject</button>
              <button class="btn btn-success w-48" type="submit" name="action" value="7">Approve</button>
              @endif
            </div>

            <div class="mb-3 d-flex justify-content-between">
              @if($staff->therole->permission == 'finance' || $staff->therole->permission == 'master')
              <button class="btn btn-success w-48" type="submit" name="action" value="5">Reimbursed</button>
              <button class="btn btn-success w-48" type="submit" name="action" value="6">Escalate</button>
              @endif
            </div>--}}
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

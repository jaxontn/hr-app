@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

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
<div class="row gy-4">
  <!-- Congratulations card -->
  <div class="col-md-12 col-lg-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-1">Hello {{ auth()->user()->username }}! 👋</h4>
        <p class="pb-0">Here's your <b>remaining</b> annual leave</p>
        <h4 class="text-primary mb-1">{{ auth()->user()->totalLeave - auth()->user()->usedLeave }} Days in <?php echo date("Y"); ?></h4>
        <p class="mb-2 pb-1">You've used up <b>{{ auth()->user()->usedLeave }}</b> days of your leave</p>
        <a href="/my-leaves" class="btn btn-sm btn-primary">My Leaves</a>
      </div>
      <img src="{{asset('assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background">
      <img src="{{asset('assets/img/illustrations/trophy.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4 pb-2" width="83" alt="view sales">
    </div>
  </div>
  <!--/ Congratulations card -->



  <!-- Transactions -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Claims</h5>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-dots-vertical mdi-24px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="/">Refresh</a>
            </div>
          </div>
        </div>
        <p class="mt-3"><span class="fw-medium">Here is your Claim Status</span> 💰</p>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-primary rounded shadow">
                  <i class="mdi mdi-trending-up mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Transferred to Finance</div>
                <h5 class="mb-0">${{ $toFinance }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-success rounded shadow">
                  <i class="mdi mdi-account-outline mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Escalated by Finance</div>
                <h5 class="mb-0">${{ $toDirector }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-warning rounded shadow">
                  <i class="mdi mdi-cellphone-link mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Reimbursed by Finance</div>
                <h5 class="mb-0">${{ $reimbursed }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-info rounded shadow">
                  <i class="mdi mdi-currency-usd mdi-24px"></i>
                </div>
              </div>
              <div class="ms-3">
                <div class="small mb-1">Approved by Director</div>
                <h5 class="mb-0">${{ $directorApprove }}</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Transactions -->



  <!-- Deposit / Withdraw -->
  <div class="col-xl-8">
    <div class="card h-100">
      <div class="card-body row g-2">
        <div class="col-12 col-md-6 card-separator pe-0 pe-md-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Pending</h5>
            <a class="fw-medium" href="/my-claims">View all</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">
              @foreach($latestClaims as $lc)
              <li class="d-flex mb-2 align-items-center pb-2">
                <div class="flex-shrink-0 me-3 ">
                  {{--<img src="{{asset('assets/img/icons/payments/gumroad.png')}}" class="img-fluid" alt="gumroad" height="30" width="30">--}}
                  <span class="mdi mdi-account-clock"></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Claim</h6>
                    <small>{{ $lc->reason }}</small>
                  </div>
                    <h6 class="text-danger mb-0">${{ $lc->amount }}</h6>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="col-12 col-md-6 ps-0 ps-md-3 mt-3 mt-md-2">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <h5 class="m-0 me-2">Reimbursed</h5>
            <a class="fw-medium" href="/my-claims">View all</a>
          </div>
          <div class="pt-2">
            <ul class="p-0 m-0">
              @foreach($latestReimbursed as $lr)
              <li class="d-flex mb-2 align-items-center pb-2">
                <div class="flex-shrink-0 me-3">
                  {{--<img src="{{asset('assets/img/icons/brands/google.png')}}" class="img-fluid" alt="google" height="30" width="30">--}}
                  <span class="mdi mdi-check-outline"></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2" style="max-width: 20rem;">
                    <h6 class="mb-0">Claim</h6>
                    <small>{{ $lr->reason }}</small>
                  </div>
                  <h6 class="text-success mb-0">${{ $lr->amount }}</h6>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Deposit / Withdraw -->


</div>
@endsection

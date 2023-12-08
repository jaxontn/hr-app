<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Claim;

class Analytics extends Controller
{
  public function index()
  {
    //return view('content.dashboard.dashboards-analytics');

    //count total claim amount cloumn for claims status that is transferred ti finannce, 1
    $toFinance = number_format(Claim::where('staffid', auth()->user()->id)->where('status', 1)->sum('amount'), 2);

    //STATUS 6
    $toDirector = number_format(Claim::where('staffid', auth()->user()->id)->where('status', 6)->sum('amount'), 2);

    //status 5
    $reimbursed = number_format(Claim::where('staffid', auth()->user()->id)->where('status', 5)->sum('amount'), 2);

    //status 7'
    $directorApprove = number_format(Claim::where('staffid', auth()->user()->id)->where('status', 7)->sum('amount'), 2);


    //Get the latest 5 claims where status is not 5
    //$latestClaims = Claim::where('staffid', auth()->user()->id)->where('status', '!=', 5)->orderBy('created_date', 'desc')->take(5)->get();
    $latestClaims = Claim::where('staffid', auth()->user()->id)
    ->whereNotIn('status', [0, 4, 5, 8])
    ->orderBy('created_date', 'desc')
    ->take(5)
    ->get();

    //Get the latest 5 claims where status is 5
    $latestReimbursed = Claim::where('staffid', auth()->user()->id)
    ->where('status', 5)
    ->orderBy('created_date', 'desc')
    ->take(5)
    ->get();

    return view('content.dashboard.dashboardnew', compact('toFinance', 'toDirector', 'reimbursed', 'directorApprove', 'latestClaims', 'latestReimbursed'));
  }
}

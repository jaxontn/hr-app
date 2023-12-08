<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//ADDED (STARTED)-------------------------------------
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; //FOR LOGGING OUT
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Staff;
use App\Models\Leave;
use App\Models\Claim;
use App\Models\Department;
use App\Models\Role;
//ADDED (ENDED)---------------------------------------
class DashboardController extends Controller
{
  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function showLoginForm()
  {
    //Log::info('entered showLoginForm()');
    //access the auth middleware
    if (Auth::guard('staff')->check()) {
      //Log::info('entered showLoginForm() IF-statement');
      //return redirect()->route('member');
      //error_log the result
      $staff = Auth::guard('staff')->user();
      //Log::info("The value of showLoginForm \$Staff is: " . $staff . "\n");

      //Log::info('DashboardController.php -> showLoginForm() -> $staff: ' . json_encode($staff) . "\n");

      //----------------------------------------------------------------
      if ($staff->role == 'finance') {
        //return an external url pepsi888.com/report
        //return redirect()->away('https://pepsi888.com/report');
      }
      //----------------------------------------------------------------
      //return and do nothing
      return redirect()->route('dashboard');
    }
    return view('content.authentications.login');
  }


  public function leaveApproval($leaveID, $id)
  {
    //Find the leave
    $leave = Leave::find($leaveID);

    //Find the staff
    $staff = Staff::find($id);

    //Find out the number of days for the leave, excluding the weekends
    $startDate = strtotime($leave->startDate);
    $endDate = strtotime($leave->endDate);
    $datediff = $endDate - $startDate;
    $days = round($datediff / (60 * 60 * 24)) + 1;
    $weekDays = 0;
    for ($i=0; $i<$days; $i++) {
      $date = date('Y-m-d', strtotime($leave->startDate . ' + ' . $i . ' days'));
      if (date('N', strtotime($date)) < 6) {
        $weekDays += 1;
      }
    }

    return view('content.authentications.leaveapproval', compact('leave', 'staff', 'weekDays'));
  }


  public function claimApproval($claimID, $id)
  {
    //Find the claim
    $claim = Claim::find($claimID);

    //Find the staff
    $staff = Staff::find($id);

    return view('content.authentications.claimapproval', compact('claim', 'staff'));
  }


  public function approveOrRejectLeave(Request $request, $leaveID, $id)
  {
    //Find the leave
    $leave = Leave::find($leaveID);

    //Find the staff
    $staff = Staff::find($id);

    //Verify staff password
    if (Hash::check($request->password . $staff->salt, $staff->encrypted_password)) {
      //If password is correct, update the leave status based on submit button value

      $leave->status = $request->action;
      $leave->save();
      Log::info("request->action: " . $request->action);
        if($request->action == 1)
        {
          //Calculate the number or days between startDate and endDate
          $startDate = strtotime($leave->startDate);
          $endDate = strtotime($leave->endDate);
          $datediff = $endDate - $startDate;
          $days = round($datediff / (60 * 60 * 24)) + 1;
          $staff = Staff::find($leave->staffid);


          //Log::info("startDate: " . $startDate);
          //Log::info("endDate: " . $endDate);
          //Log::info("datediff: " . $datediff);
          //Log::info("days: " . $days);


          //Update the usedLeave (exclude weekends)
          for ($i=0; $i<$days; $i++) {
            $date = date('Y-m-d', strtotime($leave->startDate . ' + ' . $i . ' days'));
            //Log::info("date: " . $date);
            if (date('N', strtotime($date)) < 6) {
              $staff->usedLeave += 1;
            }
          }
          $staff->save();
        }


      return redirect()
        ->route('leave-approval', ['leaveID' => $leaveID, 'id' => $id])
        ->withSuccess('Leave status updated');
    } else {
      return redirect()
        ->route('leave-approval', ['leaveID' => $leaveID, 'id' => $id])
        ->withSuccess('Password incorrect');
    }
  }



  public function approveOrRejectClaim(Request $request, $claimID, $id)
  {
      //Find the claim
      $claim = Claim::find($claimID);

      //Find the staff
      $staff = Staff::find($id);

      //Verify staff password
      if (Hash::check($request->password . $staff->salt, $staff->encrypted_password)) {
        //If password is correct, update the claim status based on submit button value
        $claim->status = $request->action;

        //insert remark based on auth user permission riole
        if ($staff->therole->permission == "manager"){
          $claim->remark_manager = $request->remark;
        }
        if ($staff->therole->permission == "finance"){
          $claim->remark_finance = $request->remark;
        }
        if ($staff->therole->permission == "director"){
          $claim->remark_director = $request->remark;
        }

        $claim->save();

        return redirect()
          ->route('claim-approval', ['claimID' => $claimID, 'id' => $id])
          ->withSuccess('Claim status updated');
      } else {
        return redirect() //include back the claimID and id claim-approval/{}/{}
          ->route('claim-approval', ['claimID' => $claimID, 'id' => $id])
          ->withSuccess('Password incorrect');
      }
  }


  public function leaveReminder(Request $request, $id)
  {
      $leave = Leave::find($id);

      if ($leave) {
        //get the manager
        $manager = Staff::find($request->input('manager'));
        $contact = $manager->contact;

        //contruct the whatsapp api with a url message
        $url = "https://api.whatsapp.com/send?phone=" . $contact .
        "&text=Hi%20" . $manager->username . ",%20" .
        Auth::guard('staff')->user()->username .
        "%20has%20applied%20for%20leave%20from%20" .
        $leave->startDate . "%20to%20" .
        $leave->endDate .
        ".%20Please%20approve%20or%20reject%20the%20leave%20application%20at%20https://hrapp.durian888.com/leave-approval/" . $leave->id . "/" . $manager->id;
      }

      return redirect()->away($url);
  }

  public function claimReminder(Request $request, $id)
  {
      $claim = Claim::find($id);

      if ($claim) {
        //get the manager
        $manager = Staff::find($request->input('manager'));
        $contact = $manager->contact;

        //contruct the whatsapp api with a url message
        $url = "https://api.whatsapp.com/send?phone=" . $contact .
        "&text=Hi%20" . $manager->username . ",%20" .
        Auth::guard('staff')->user()->username .
        "%20has%20applied%20for%20claim%20of%20RM" .
        $claim->amount .
        ".%20Please%20approve%20or%20reject%20the%20claim%20application%20at%20https://hrapp.durian888.com/claim-approval/" . $claim->id . "/" . $manager->id;
      }

      return redirect()->away($url);
  }






  /*____________________________________________________
      NAME: login
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S): Login for staff, if you're looking for login for frontend, go to FEAuthController.php instead
      ____________________________________________________
    */
  public function loginBack(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);
    Log::info('ENTERED loginBack()');

    $credentials = $request->only('username', 'password');
    $staff = Staff::where('username', $credentials['username'])->first();
    //get all staff
    $staffs = Staff::all();
    $credentialsString = json_encode($credentials);
    Log::info("The value of \$credentials is: " . $credentialsString);
    Log::info("The value of \$Staff is: " . $staff);

    if ($staff && Hash::check($credentials['password'] . $staff->salt, $staff->encrypted_password)) {
      Auth::guard('staff')->login($staff);
      //if staff is finance, redirect to finance page
      if ($staff->role == 'finance') {
        //return an external url pepsi888.com/report
        // return redirect()->away('https://pepsi888.com/report');
      }
      return redirect()
        ->route('dashboard')
        ->withSuccess('Signed in');
    } else {
      //Log::warning('Generated hash: ' . Hash::make($credentials['password'] . $staff->salt));
      //Log::warning('Stored encrypted password: ' . $staff->encrypted_password);
      //Log::warning('Stored salt: ' . $staff->salt);
    }

    //Log::warning('Authentication failed for user: ' . $credentials['username']);
    return back()->withErrors([
      'username' => 'The provided credentials do not match our records.',
    ]);
  }







  /*____________________________________________________
      NAME: signOut
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function signOut()
  {
    Session::flush();
    Auth::logout();

    return Redirect('/');
  }






  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function allStaff()
  {
    $staffs = Staff::all();
    $role = Role::all();
    $dept = Department::all();
    return view('content.dashboard.allStaff', compact('staffs', 'role', 'dept'));
  }






  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
    public function allDepartment()
    {
      $department = Department::all();
      return view('content.dashboard.allDepartment', compact('department'));
    }






    /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
    public function allRole()
    {
      $role = Role::all();
      return view('content.dashboard.allRole', compact('role'));
    }





  /*____________________________________________________
      NAME: editStaffBackend
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function editStaffBackend(Request $request, $id)
  {
    $staff = Staff::find($id);

    $salt = Str::random(16); // Generate a random salt
    $encrypted_password = Hash::make($request->password . $salt);

    if ($staff) {

      //make sure no duplicate username where id not the same id
      $staffCheck = Staff::where('username', $request->username)
                            ->where('id', '!=', $id)
                            ->first();
      if ($staffCheck) {
        return redirect()
          ->route('all-staff')
          ->withSuccess('Username already exists');
      }

      // Update the user data
      $staff->update([
        'username' => $request->input('username'),
        'encrypted_password' => $encrypted_password,
        'salt' => $salt,
        'role' => $request->input('role'),
        'department' => $request->input('dept'),
        'totalLeave' => $request->input('totalLeave'),
        'usedLeave' => $request->input('usedLeave'),
        'contact' => $request->input('whatsapp'),
        // Add other fields you want to update here
      ]);

      // Redirect back to the profile page with a success message
      return redirect()
        ->route('all-staff')
        ->with('success', 'Staff has been edited successfully.');
    } else {
      // Handle the case when the member is not found
      return redirect()
        ->route('all-staff')
        ->with('error', 'Staff not found.');
    }
  }






   /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function editDepartmentBackend(Request $request, $id)
  {
    $department = Department::find($id);

    if ($department) {
      // Update the user data
      $department->update([
        'name' => $request->input('username'),
        // Add other fields you want to update here
      ]);

      // Redirect back to the profile page with a success message
      return redirect()
        ->route('all-department')
        ->with('success', 'Department has been edited successfully.');
    } else {
      // Handle the case when the member is not found
      return redirect()
        ->route('all-department')
        ->with('error', 'Department not found.');
    }
  }




   /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function editRoleBackend(Request $request, $id)
  {
    $role = Role::find($id);

    if ($role) {
      // Update the user data
      $role->update([
        'name' => $request->input('username'),
        'permission' => $request->input('permission'),
        // Add other fields you want to update here
      ]);

      // Redirect back to the profile page with a success message
      return redirect()
        ->route('all-role')
        ->with('success', 'Role has been edited successfully.');
    } else {
      // Handle the case when the member is not found
      return redirect()
        ->route('all-role')
        ->with('error', 'Role not found.');
    }
  }







  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function customStaff(Request $request)
  {
    Log::info('customStaff() -> The value of $request is: ' . json_encode($request) . "\n");
    $request->validate([
      'username' => 'required',
      'password' => 'required',
      'dept' => 'required',
      'role' => 'required',
      'contact' => 'required',
      'totalLeave' => 'required',
    ]);

    $salt = Str::random(16); // Generate a random salt
    $encrypted_password = Hash::make($request->password . $salt);

    //MAKE SURE NOT DUSPLICATE USERNAME
    $staff = Staff::where('username', $request->username)->first();
    if ($staff) {
      return redirect()
        ->route('all-staff')
        ->withSuccess('Username already exists');
    }

    Staff::create([
      'username' => $request->username,
      'encrypted_password' => $encrypted_password,
      'salt' => $salt,
      'role' => $request->role,
      'department' => $request->dept,
      'contact' => $request->contact,
      'totalLeave' => $request->totalLeave,
    ]);

    return redirect()
      ->route('all-staff')
      ->withSuccess('New user successfully registered');
  }



   /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function customDepartment(Request $request)
  {
    Log::info('customDepartment() -> The value of $request is: ' . json_encode($request) . "\n");
    $request->validate([
      'username' => 'required',
    ]);

    Department::create([
      'name' => $request->username,
    ]);

    return redirect()
      ->route('all-department')
      ->withSuccess('New department successfully registered');
  }


/*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function customRole(Request $request)
  {
    Log::info('customRole() -> The value of $request is: ' . json_encode($request) . "\n");
    Log::info('Permission value from request: ' . $request->permission);
    Log::info('Role name: ' . $request->username); // Fix here
    Role::create([
      'name' => $request->username,
      'permission' => $request->permission,
    ]);

    return redirect()
      ->route('all-role')
      ->withSuccess('New role successfully registered');
  }



  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function applyLeave()
  {
    return view('content.dashboard.applyLeave');
  }







   /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
    public function applyClaim()
    {
      return view('content.dashboard.applyClaim');
    }







  /*____________________________________________________
      NAME:
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function submitLeave(Request $request)
  {
    Log::info("DashboardController.php -> submitLeave() ");

    //If start date is after end date
    if ($request->startDate > $request->endDate) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('Start date cannot be after end date');
    }

    //If start date is before today
    if ($request->startDate < date('Y-m-d')) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('Start date cannot be before today');
    }

    //If end date is before today
    if ($request->endDate < date('Y-m-d')) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('End date cannot be before today');
    }

    //If start date is today
    if ($request->startDate == date('Y-m-d')) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('Start date cannot be today');
    }

    //If end date is today
    if ($request->endDate == date('Y-m-d')) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('End date cannot be today');
    }

    //If start date is on a weekend
    if (date('N', strtotime($request->startDate)) >= 6) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('Start date cannot be on a weekend');
    }

    //If end date is on a weekend
    if (date('N', strtotime($request->endDate)) >= 6) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('End date cannot be on a weekend');
    }

    //Leave type cannot be null
    if ($request->leaveType == null) {
      return redirect()
        ->route('apply-leave')
        ->withSuccess('Please select a leave type');
    }

    //Add to Leave table
    Leave::create([
      'staffid' => Auth::guard('staff')->user()->id,
      'startDate' => $request->startDate,
      'endDate' => $request->endDate,
      'reason' => $request->reason,
      'status' => 2,
      'type' => $request->leaveType,
    ]);

    Log::info("DashboardController.php -> submitLeave(): Created Leave");

    return redirect()
      ->route('apply-leave')
      ->withSuccess('Leave successfully submitted');
  }






  /*____________________________________________________
      NAME: submitClaim
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
  public function submitClaim(Request $request)
  {
    Log::info("DashboardController.php -> submitClaim() ");

    //If amount is negative
    if ($request->amount < 0) {
      return redirect()
        ->route('apply-claim')
        ->withSuccess('Amount cannot be negative');
    }

    //If amount is 0
    if ($request->amount == 0) {
      return redirect()
        ->route('apply-claim')
        ->withSuccess('Amount cannot be 0');
    }

    //If claim type is null
    if ($request->claimType == null) {
      return redirect()
        ->route('apply-claim')
        ->withSuccess('Please select a claim type');
    }

    // Validate and store the receipt image
    /*$request->validate([
      'receipt' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
    ]);*/

    $imagePath = "0";
    if ($request->hasFile('receipt')) {
        // Store the file in the 'public' disk
        $imagePath = $request->file('receipt')->store('receipts', 'public');
        // Get the public URL of the stored file
        $publicUrl = 'storage/' .  $imagePath;//asset('storage/' . $imagePath);
    } else {
        $imagePath = null; // Set to null if no receipt is provided
        $publicUrl = null;
    }

    //Log::info("imagePath: " . $imagePath);

    //Add to Claim table
    Claim::create([
      'staffid' => Auth::guard('staff')->user()->id,
      'amount' => $request->amount,
      'reason' => $request->reason,
      'status' => 2,
      'attachment' => $publicUrl, // Add the receipt image path to the 'receipt' column
      'type' => $request->claimType,
    ]);

    Log::info("DashboardController.php -> submitClaim(): Created Claim");

    return redirect()
      ->route('apply-claim')
      ->withSuccess('Claim successfully submitted');
  }





    /*____________________________________________________
      NAME: workspace
      PURPOSE:
      IMPORT:
      EXPORT:
      COMMENT(S):
      ____________________________________________________
    */
    public function workspace()
    {
      //Retrieve pending leave
      $leave = Leave::with('staff')
          ->where('status', 2)
          ->get();

      $claim4Manager = Claim::with('staff')
          ->where('status', 2)
          ->get();

      $claim4Fin = Claim::with('staff')
          ->whereIn('status', [1, 7])
          ->get();

      $claim4Director = Claim::with('staff')
          ->where('status', 6)
          ->get();

      //Identify the auth role
      $permission = Auth::guard('staff')->user()->therole->permission;

      //do switch case and assign claim to either claim4manager, claim4fin, or claim4director
      switch ($permission) {
        case "manager":
          $claim = $claim4Manager;
          break;
        case "finance":
          $claim = $claim4Fin;
          break;
        case "director":
          $claim = $claim4Director;
          break;
        default:
          $claim = $claim4Manager;
      }

      //make sure leave and claim are in the same department as the user
      foreach ($leave as $key => $value) {
        if ($value->staff->department != Auth::guard('staff')->user()->department) {
          unset($leave[$key]);
        }
      }

      foreach ($claim as $key => $value) {
        if ($value->staff->department != Auth::guard('staff')->user()->department) {
          unset($claim[$key]);
        }
      }

      //Log the leave and claim
     // Log::info("DashboardController.php -> workspace(): Retrieve leave: " . $leave );
     // Log::info("DashboardController.php -> workspace(): Retrieve claim: " . $claim );
      return view('content.dashboard.approval', compact('leave', 'claim'));
    }



    public function approveLeave($id)
    {
        $leave = Leave::find($id);
        $leave->status = 1;
        //Calculate the number or days between startDate and endDate
        $startDate = strtotime($leave->startDate);
        $endDate = strtotime($leave->endDate);
        $datediff = $endDate - $startDate;
        $days = round($datediff / (60 * 60 * 24)) + 1;
        $staff = Staff::find($leave->staffid);
        $leave->save();

        //Log::info("startDate: " . $startDate);
        //Log::info("endDate: " . $endDate);
        //Log::info("datediff: " . $datediff);
        //Log::info("days: " . $days);


        //Update the usedLeave (exclude weekends)
        for ($i=0; $i<$days; $i++) {
          $date = date('Y-m-d', strtotime($leave->startDate . ' + ' . $i . ' days'));
          //Log::info("date: " . $date);
          if (date('N', strtotime($date)) < 6) {
            $staff->usedLeave += 1;
          }
        }
        $staff->save();
        //$staff->usedLeave += $days;
        //$staff->save();

        return redirect()
        ->route('workspace')
        ->withSuccess('Leave Approved!');
    }

    public function rejectLeave($id)
    {
        $leave = Leave::find($id);
        $leave->status = 0;
        $leave->save();

        return redirect()
        ->route('workspace')
        ->withSuccess('Leave Rejected!');
    }

    public function approveClaim($id)
    {
        $claim = Claim::find($id);
        $claim->status = 1;
        $claim->save();

        return redirect()
        ->route('workspace')
        ->withSuccess('Claim Approved!');
    }

    public function updateClaim($id, $status)
    {
        $claim = Claim::find($id);
        $claim->status = $status;
        $claim->save();

        return redirect()
        ->route('workspace')
        ->withSuccess('Claim Updated!');
    }

    public function rejectClaim($id)
    {
        $claim = Claim::find($id);
        $claim->status = 0;
        $claim->save();

        return redirect()
        ->route('workspace')
        ->withSuccess('Claim Rejected!');
    }


    public function leaveView()
    {
      $leave = Leave::all();

      //make sure claim are in the same department as the user
      foreach ($leave as $key => $value) {
        if ($value->staff->department != Auth::guard('staff')->user()->department) {
          unset($leave[$key]);
        }
      }

      return view('content.dashboard.leavelist', compact('leave'));
    }

    public function editLeaveHistory(Request $request, $id)
    {
      //Just update the status
      $leave = Leave::find($id);

      if ($leave) {
        // Update the user data
        $leave->update([
          'status' => $request->input('statusHistory'),
          // Add other fields you want to update here
        ]);

        // Redirect back to the profile page with a success message
        return redirect()
          ->route('leave')
          ->with('success', 'Leave has been edited successfully.');
      } else {
        // Handle the case when the member is not found
        return redirect()
          ->route('leave')
          ->with('error', 'Leave not found.');
      }

    }

    public function editClaimHistory(Request $request, $id)
    {
      //Just update the status
      $claim = Claim::find($id);

      if ($claim) {
        // Update the user data
        $claim->update([
          'status' => $request->input('statusHistory'),
        ]);

        // Redirect back to the profile page with a success message
        return redirect()
          ->route('claim')
          ->with('success', 'Claim has been edited successfully.');
      } else {
        // Handle the case when the member is not found
        return redirect()
          ->route('claim')
          ->with('error', 'Claim not found.');
      }
    }

    public function claimView()
    {
      $claim = Claim::all();

      //make sure claim are in the same department as the user
      foreach ($claim as $key => $value) {
        if ($value->staff->department != Auth::guard('staff')->user()->department) {
          unset($claim[$key]);
        }
      }

      return view('content.dashboard.claimlist', compact('claim'));
    }

    public function myLeaves()
    {
      $leave = Leave::where('staffid', Auth::guard('staff')->user()->id)->get();

      //Get managers from the same department as the authenticated staff department
      $managers = Staff::where('department', Auth::guard('staff')->user()->department)
                  ->whereHas('therole', function ($query) {
                      $query->where('permission', 'manager');
                    })
                  ->get();

      $heading = "My Leaves";

      return view('content.dashboard.myleave', compact('leave', 'managers', 'heading'));
    }



    public function myClaims()
    {
      $claim = Claim::where('staffid', Auth::guard('staff')->user()->id)->get();
      $upper = [];
      //if user role permission is staff, get manager of the same department.
      //use auth checkRole
      //Log staff's permission
      Log::info("DashboardController.php -> myClaims(): Auth::guard('staff')->user()->therole->permission: " . Auth::guard('staff')->user()->therole->permission);
      if (Auth::guard('staff')->user()->therole->permission == "staff"){
        $upper = Staff::where('department', Auth::guard('staff')->user()->department)
                    ->whereHas('therole', function ($query) {
                        $query->where('permission', 'manager');
                      })
                    ->get();
      }

      //if user role permission is manager, get all finance of the same department.
      if (Auth::guard('staff')->user()->therole->permission == "manager" || Auth::guard('staff')->user()->therole->permission == "master"){
        $upper = Staff::where('department', Auth::guard('staff')->user()->department)
                    ->whereHas('therole', function ($query) {
                        $query->where('permission', 'finance');
                      })
                    ->get();
      }
      //if user role permission is finance, get all director of the same department.
      if (Auth::guard('staff')->user()->therole->permission == "finance"){
        $upper = Staff::where('department', Auth::guard('staff')->user()->department)
                    ->whereHas('therole', function ($query) {
                        $query->where('permission', 'director');
                      })
                    ->get();
      }

      $heading = "My Claims";

      return view('content.dashboard.myclaim', compact('claim', 'upper', 'heading'));
    }







    //get the claim of the same departnemtn which role is staff
    public function teamClaims(){
      $claim = Claim::whereHas('staff', function ($query) {
          $query->where('department', Auth::guard('staff')->user()->department)
                ->whereHas('therole', function ($query) {
                    $query->where('permission', 'staff');
                  });
        })
        ->get();

      //if user role permission is manager, get all finance of the same department.
      if (Auth::guard('staff')->user()->therole->permission == "manager" || Auth::guard('staff')->user()->therole->permission == "master"){
        $upper = Staff::where('department', Auth::guard('staff')->user()->department)
                    ->whereHas('therole', function ($query) {
                        $query->where('permission', 'finance');
                      })
                    ->get();
      }

      //if user role permission is finance, get all director of the same department.
      if (Auth::guard('staff')->user()->therole->permission == "finance"){
        $upper = Staff::where('department', Auth::guard('staff')->user()->department)
                    ->whereHas('therole', function ($query) {
                        $query->where('permission', 'director');
                      })
                    ->get();
      }

      $heading = "Team Claims";

      return view('content.dashboard.myclaim', compact('claim', 'upper', 'heading'));
    }









    public function calendar()
    {
      $leaves = Leave::where('status', 1)
                  ->get();
      //Generate a json for each leave
      /*{
        title: 'Long Event',
        start: '2023-11-07T16:30:00',
        end: '2023-11-10'
      }, */

      //Make sure the leave staff is in the same department as the current auth user department
      foreach ($leaves as $key => $value) {
        if ($value->staff->department != Auth::guard('staff')->user()->department) {
          unset($leaves[$key]);
        }
      }


      //Create an array to store all leaves data and convert it into JSON format
      $json = array();
      foreach ($leaves as $leave) {
        $json[] = array(
          'title' => $leave->staff->username . ' - ' . $leave->reason,
          'start' => $leave->startDate,
          'end' => $leave->endDate,
        );
      }
      return view('content.dashboard.calendarnew', compact('json'));
    }
}

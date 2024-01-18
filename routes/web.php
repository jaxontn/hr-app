<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\MdiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;

//ADDED (STARTED)-------------------------------------
use App\Http\Controllers\DashboardController;
//ADDED (ENDED)---------------------------------------

Route::get('/foo', function () {
  Log::info('Called storage link');
  Artisan::call('storage:link');
  Log::info('Done storage Link');
});

//MASTER**************
Route::middleware(['auth:staff', 'checkRole:master'])->group(function () {
  //ALL STAFF
  Route::get('/all-staff', [DashboardController::class, 'allStaff'])->name('all-staff');
  Route::post('/edit-staff-backend/{id}', [DashboardController::class, 'editStaffBackend'])->name('edit-staff-backend');
  Route::post('/register-staff', [DashboardController::class, 'customStaff'])->name('register-staff');
  //Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard-analytics');

  //DEPARTMENT
  Route::get('/all-department', [DashboardController::class, 'allDepartment'])->name('all-department');
  Route::post('/edit-department-backend/{id}', [DashboardController::class, 'editDepartmentBackend'])->name('edit-department-backend');
  Route::post('/register-department', [DashboardController::class, 'customDepartment'])->name('register-department');

  //ROLE
  Route::get('/all-role', [DashboardController::class, 'allRole'])->name('all-role');
  Route::post('/edit-role-backend/{id}', [DashboardController::class, 'editRoleBackend'])->name('edit-role-backend');
  Route::post('/register-role', [DashboardController::class, 'customRole'])->name('register-role');
});



//MASTER, MANAGER*******************
Route::middleware(['auth:staff', 'checkRole:master,manager'])->group(function () {
  //CALENDAR
  //Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');

  //WORKSPACE - LEAVE
  Route::get('/leave-approve/{id}', [DashboardController::class, 'approveLeave'])->name('leave-approve');
  Route::get('/leave-reject/{id}', [DashboardController::class, 'rejectLeave'])->name('leave-reject');

  //TEAM LEAVES
  //Route::get('/team-leaves', [DashboardController::class, 'teamLeaves'])->name('team-leaves');


});

//MASTER, FINANCE******************
Route::middleware(['auth:staff', 'checkRole:master,finance'])->group(function () {
  Route::get('/claim-approve/{id}', [DashboardController::class, 'approveClaim'])->name('claim-approve');
  Route::get('/claim-reject/{id}', [DashboardController::class, 'rejectClaim'])->name('claim-reject');

});

//MASTER, MANAGER, FINANCE********
Route::middleware(['auth:staff', 'checkRole:master,manager,finance'])->group(function () {
  //TEAM CLAIMS
  Route::get('/team-claims', [DashboardController::class, 'teamClaims'])->name('team-claims');
});

//MASTER, MANAGER, FINANCE, STAFF******************
Route::middleware(['auth:staff', 'checkRole:master,manager,finance,staff'])->group(function () {

  //CALENDAR
  Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');

  //APPLY LEAVE
  Route::get('/apply-leave', [DashboardController::class, 'applyLeave'])->name('apply-leave');
  Route::post('/submit-leave', [DashboardController::class, 'submitLeave'])->name('submit-leave');

  //SUBMIT CLAIM
  Route::get('/apply-claim', [DashboardController::class, 'applyClaim'])->name('apply-claim');
  Route::post('/submit-claim', [DashboardController::class, 'submitClaim'])->name('submit-claim');

  //MY LEAVES
  Route::get('/my-leaves', [DashboardController::class, 'myLeaves'])->name('my-leaves');
  //MY CLAIMS
  Route::get('/my-claims', [DashboardController::class, 'myClaims'])->name('my-claims');

  //EDIT LEAVE
  Route::get('/edit-leave', [DashboardController::class, 'editLeave'])->name('edit-leave');
  Route::post('/update-leave-number', [DashboardController::class, 'updateLeaveNumber'])->name('update-leave-number');

  //LEAVE REMINDER
  Route::post('/leave-reminder/{id}', [DashboardController::class, 'leaveReminder'])->name('leave-reminder');

  //EDIT LEAVE NUMBER REMINDER
  Route::post('/edit-leave-number-reminder/{id}', [DashboardController::class, 'editLeaveNumberReminder'])->name('edit-leave-number-reminder');

  //CLAIM REMINDER
  Route::post('/claim-reminder/{id}', [DashboardController::class, 'claimReminder'])->name('claim-reminder');


});


//MASTER, MANAGER, FINANCE, DIRECTOR*****************
Route::middleware(['auth:staff', 'checkRole:master,manager,finance,director'])->group(function () {
  //WORKSPACE
  Route::get('/workspace', [DashboardController::class, 'workspace'])->name('workspace');
  Route::get('/update-claim/{id}/{status}', [DashboardController::class, 'updateClaim'])->name('update-claim');

   //HISTORY - LEAVE
   Route::get('/leave', [DashboardController::class, 'leaveView'])->name('leave');
   Route::post('/edit-leave-history/{id}', [DashboardController::class, 'editLeaveHistory'])->name('edit-leave-history');

   //HISTORY - CLAIM
   Route::get('/claim', [DashboardController::class, 'claimView'])->name('claim');
   Route::post('/edit-claim-history/{id}', [DashboardController::class, 'editClaimHistory'])->name('edit-claim-history');
});


//ALL - MASTER, MANAGER, FINANCE, DIRECTOR, STAFF
Route::middleware(['auth:staff', 'checkRole:master,manager,finance,staff,director'])->group(function () {
  // Main Page Route
  Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard');
});


//ADDED (STARTED)-----------------------------------------------------------------------
Route::get('/', [DashboardController::class, 'showLoginForm'])->name('/');
Route::get('/auth/calendar', [DashboardController::class, 'showLoginFormCalendar'])->name('auth-calendar');
Route::get('/view/calendar/{id}', [DashboardController::class, 'viewCalendar'])->name('view-calendar');
Route::post('login-back', [DashboardController::class, 'loginBack'])->name('login-back');
Route::post('cal-login-back', [DashboardController::class, 'calLoginBack'])->name('cal-login-back');
Route::post('/logout', [DashboardController::class, 'signOut'])->name('logout');
//Route::get('/login', [LoginBasic::class, 'index'])->name('login');
Route::get('/register', [RegisterBasic::class, 'index'])->name('register');
Route::get('/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('forgot-password');


Route::get('/leave-approval/{leaveID}/{id}', [DashboardController::class, 'leaveApproval'])->name('leave-approval');
Route::get('/leave-edit/{EditLeaveID}/{id}', [DashboardController::class, 'leaveEdit'])->name('leave-edit');
Route::post('/submit-leave-approval/{leaveID}/{id}', [DashboardController::class, 'approveOrRejectLeave'])->name('submit-leave-approval');
Route::post('/submit-leave-edit/{EditLeaveID}/{id}', [DashboardController::class, 'editLeaveBackend'])->name('submit-leave-edit');

Route::get('/claim-approval/{claimID}/{id}', [DashboardController::class, 'claimApproval'])->name('claim-approval');
Route::post('/submit-claim-approval/{claimID}/{id}', [DashboardController::class, 'approveOrRejectClaim'])->name('submit-claim-approval');
//ADDED (ENDED)-------------------------------------------------------------------------




Route::middleware(['auth:staff', 'checkRole:master'])->group(function () {
    // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

    // layout
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

    // pages
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name(
      'pages-account-settings-account'
    );
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name(
      'pages-account-settings-notifications'
    );
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name(
      'pages-account-settings-connections'
    );
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name(
      'pages-misc-under-maintenance'
    );

    // cards
    Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

    // User Interface
    Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
    Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
    Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
    Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
    Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
    Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
    Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
    Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
    Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
    Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
    Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
    Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
    Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
    Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
    Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
    Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
    Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
    Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
    Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

    // extended ui
    Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
    Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

    // icons
    Route::get('/icons/icons-mdi', [MdiIcons::class, 'index'])->name('icons-mdi');

    // form elements
    Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
    Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

    // form layouts
    Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
    Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

    // tables
    Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
});

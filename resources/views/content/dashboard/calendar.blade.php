
<!DOCTYPE html>

<html lang="en" class="light-style layout-compact layout-navbar-fixed layout-menu-fixed     " dir="ltr" data-theme="theme-default" data-assets-path="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/" data-base-url="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1" data-framework="laravel" data-template="vertical-menu-theme-default-light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Fullcalendar - Apps |
    Materio -
    Bootstrap 5 HTML + Laravel Admin Template</title>
  <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 + Laravel HTML Admin Dashboard Template built for developers!" />
  <meta name="keywords" content="dashboard, material, material design, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="jgB7s9juZLbDxdWDmYa84bfrCXCC1FNXmMdVZLNl">
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://themeselection.com/item/materio-bootstrap-laravel-admin-template/">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/favicon/favicon.ico" />


      <!-- Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5DDHKGP');</script>
  <!-- End Google Tag Manager -->


  <!-- Include Styles -->
  <!-- $isFront is used to append the front layout styles only on the front layout otherwise the variable will be blank -->
  <!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet">

<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/fonts/materialdesignicons.css?id=6dcb6840ed1b54e81c4279112d07827e" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/fonts/flag-icons.css?id=121bcc3078c6c2f608037fb9ca8bce8d" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/node-waves/node-waves.css?id=aa72fb97dfa8e932ba88c8a3c04641bc" />
<!-- Core CSS -->
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/core.css?id=844d8848f059310b5530fe2f16a8521a" class="template-customizer-core-css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-default.css?id=52fab3455fdcaff9f4acefe519ec216b" class="template-customizer-theme-css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/css/demo.css?id=e0dd12b480da2fee900cf30c26103f98" />

<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css?id=f83e2378d0545f439cbfea281f4852dd" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/typeahead-js/typeahead.css?id=97b6e7a4d886c3d71a065c4b0d0d5f54" />

<!-- Vendor Styles -->
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/fullcalendar/fullcalendar.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/quill/editor.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />


<!-- Page Styles -->
<link rel="stylesheet" href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/pages/app-calendar.css" />

  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- $isFront is used to append the front layout scriptsIncludes only on the front layout otherwise the variable will be blank -->
  <!-- laravel style -->
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/helpers.js"></script>
<!-- beautify ignore:start -->
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/template-customizer.js"></script>

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/js/config.js"></script>

  <script>
    window.templateCustomizer = new TemplateCustomizer({
      cssPath: '',
      themesPath: '',
      defaultStyle: "light",
      defaultShowDropdownOnHover: "true", // true/false (for horizontal layout only)
      displayCustomizer: "true",
      lang: 'en',
      pathResolver: function(path) {
        var resolvedPaths = {
          // Core stylesheets
                      'core.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/core.css?id=844d8848f059310b5530fe2f16a8521a',
            'core-dark.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/core-dark.css?id=e02525be49a99197a4c9d5a84947fc8b',

          // Themes
                      'theme-default.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-default.css?id=52fab3455fdcaff9f4acefe519ec216b',
            'theme-default-dark.css':
            'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-default-dark.css?id=c8fd4937f51751cb21fc1b850985e28d',
                      'theme-bordered.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-bordered.css?id=2e360cd4013a77f41e5735180028af47',
            'theme-bordered-dark.css':
            'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-bordered-dark.css?id=0fd70b0f8c51077b53c94c534b6dea08',
                      'theme-semi-dark.css': 'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-semi-dark.css?id=7eb0cf231320db79df76c9cc343a9c64',
            'theme-semi-dark-dark.css':
            'https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/css/rtl/theme-semi-dark-dark.css?id=0d086bfea4ae48a5c1384981979967ac',
                  }
        return resolvedPaths[path] || path;
      },
      'controls': ["rtl","style","headerType","contentLayout","layoutCollapsed","layoutNavbarOptions","themes"],
    });
  </script>
</head>

<body>

      <!-- Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->


  <!-- Layout Content -->
  <div class="layout-wrapper layout-content-navbar ">
  <div class="layout-container">

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
    <a href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo-1" class="app-brand-link">
      <span class="app-brand-logo demo me-1">
        <span style="color:#9055FD;">
  <svg width="30" height="20" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z" fill="currentColor" />
    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z" fill="currentColor" />
    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
    <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd" d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="currentColor" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z" fill="white" fill-opacity="0.15" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="currentColor" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z" fill="white" fill-opacity="0.3" />
  </svg>
</span>
      </span>

  </div>

</aside>


    <!-- Layout page -->
    <div class="layout-page">




      <!-- BEGIN: Navbar-->
            <!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->

      <!-- ! Not required for layout-without-menu -->
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0  d-xl-none ">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
          </a>
        </div>

</nav>
  <!-- / Navbar -->
            <!-- END: Navbar-->


      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
                  <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card app-calendar-wrapper">
  <div class="row g-0">
    <!-- Calendar Sidebar -->
    <div class="col app-calendar-sidebar border-end" id="app-calendar-sidebar">
      <div class="p-3 pb-2 my-sm-0 mb-3">
        <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="offcanvas" data-bs-target="#addEventSidebar" aria-controls="addEventSidebar">
          Add Event
        </button>
      </div>
      <div class="p-4">

        <!-- Filter -->
        <div class="mb-4">
          <small class="text-small text-muted text-uppercase align-middle">Calendars</small>
        </div>

        <div class="form-check form-check-secondary mb-4">
          <input class="form-check-input select-all" type="checkbox" id="selectAll" data-value="all" checked>
          <label class="form-check-label" for="selectAll">View All</label>
        </div>

        <div class="app-calendar-events-filter">
          <div class="form-check form-check-danger mb-4">
            <input class="form-check-input input-filter" type="checkbox" id="select-personal" data-value="personal" checked>
            <label class="form-check-label" for="select-personal">Personal</label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input input-filter" type="checkbox" id="select-business" data-value="business" checked>
            <label class="form-check-label" for="select-business">Business</label>
          </div>
          <div class="form-check form-check-warning mb-4">
            <input class="form-check-input input-filter" type="checkbox" id="select-family" data-value="family" checked>
            <label class="form-check-label" for="select-family">Family</label>
          </div>
          <div class="form-check form-check-success mb-4">
            <input class="form-check-input input-filter" type="checkbox" id="select-holiday" data-value="holiday" checked>
            <label class="form-check-label" for="select-holiday">Holiday</label>
          </div>
          <div class="form-check form-check-info">
            <input class="form-check-input input-filter" type="checkbox" id="select-etc" data-value="etc" checked>
            <label class="form-check-label" for="select-etc">ETC</label>
          </div>
        </div>
      </div>
    </div>
    <!-- /Calendar Sidebar -->

    <!-- Calendar & Modal -->
    <div class="col app-calendar-content">
      <div class="card shadow-none border-0 ">
        <div class="card-body pb-0">
          <!-- FullCalendar -->
          <div id="calendar"></div>
        </div>
      </div>
      <div class="app-overlay"></div>
      <!-- FullCalendar Offcanvas -->
      <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="addEventSidebarLabel">Add Event</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <form class="event-form pt-0" id="eventForm" onsubmit="return false">
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Event Title" />
              <label for="eventTitle">Title</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <select class="select2 select-event-label form-select" id="eventLabel" name="eventLabel">
                <option data-label="primary" value="Business" selected>Business</option>
                <option data-label="danger" value="Personal">Personal</option>
                <option data-label="warning" value="Family">Family</option>
                <option data-label="success" value="Holiday">Holiday</option>
                <option data-label="info" value="ETC">ETC</option>
              </select>
              <label for="eventLabel">Label</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="eventStartDate" name="eventStartDate" placeholder="Start Date" />
              <label for="eventStartDate">Start Date</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="eventEndDate" name="eventEndDate" placeholder="End Date" />
              <label for="eventEndDate">End Date</label>
            </div>
            <div class="mb-3">
              <label class="switch">
                <input type="checkbox" class="switch-input allDay-switch" />
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label">All Day</span>
              </label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <input type="url" class="form-control" id="eventURL" name="eventURL" placeholder="https://www.google.com" />
              <label for="eventURL">Event URL</label>
            </div>
            <div class="form-floating form-floating-outline mb-4 select2-primary">
              <select class="select2 select-event-guests form-select" id="eventGuests" name="eventGuests" multiple>
                <option data-avatar="1.png" value="Jane Foster">Jane Foster</option>
                <option data-avatar="3.png" value="Donna Frank">Donna Frank</option>
                <option data-avatar="5.png" value="Gabrielle Robertson">Gabrielle Robertson</option>
                <option data-avatar="7.png" value="Lori Spears">Lori Spears</option>
                <option data-avatar="9.png" value="Sandy Vega">Sandy Vega</option>
                <option data-avatar="11.png" value="Cheryl May">Cheryl May</option>
              </select>
              <label for="eventGuests">Add Guests</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="eventLocation" name="eventLocation" placeholder="Enter Location" />
              <label for="eventLocation">Location</label>
            </div>
            <div class="form-floating form-floating-outline mb-4">
              <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
              <label for="eventDescription">Description</label>
            </div>
            <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4 gap-2">
              <div class="d-flex">
                <button type="submit" class="btn btn-primary btn-add-event me-sm-2 me-1">Add</button>
                <button type="reset" class="btn btn-outline-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">Cancel</button>
              </div>
              <button class="btn btn-outline-danger btn-delete-event d-none">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Calendar & Modal -->
  </div>
</div>

          </div>
          <!-- / Content -->

          <!-- Footer -->
                    <!-- Footer-->
<!--/ Footer-->
                    <!-- / Footer -->
          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

        <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->
    <!--/ Layout Content -->





  <!-- Include Scripts -->
  <!-- $isFront is used to append the front layout scripts only on the front layout otherwise the variable will be blank -->
  <!-- BEGIN: Vendor JS-->
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/jquery/jquery.js?id=0f7eb1f3a93e3e19e8505fd8c175925a"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/popper/popper.js?id=baf82d96b7771efbcc05c3b77135d24c"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/bootstrap.js?id=4b1a450d7bd34439656711e022110b65"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/node-waves/node-waves.js?id=4fae469a3ded69fb59fce3dcc14cd638"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js?id=44b8e955848dc0c56597c09f6aebf89a"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/hammer/hammer.js?id=0a520e103384b609e3c9eb3b732d1be8"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/typeahead-js/typeahead.js?id=f6bda588c16867a6cc4158cb4ed37ec6"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/js/menu.js?id=c6ce30ded4234d0c4ca0fb5f2a2990d8"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/moment/moment.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/js/main.js?id=e46da52cc43e079943fb6810bf346c25"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/js/app-calendar-events.js"></script>
<script src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/js/app-calendar.js"></script>
<!-- END: Page JS-->

</body>

</html>

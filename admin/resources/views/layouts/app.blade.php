<!-- 
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com) & Updivision (https://www.updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim & Updivision

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/logo/logo-no-background.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/logo/logo-no-background.png') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        <!-- CSS Files -->
        <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />
        {{-- bootstrap icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        {{-- bootstrap5 cdn link --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
          .form-control:hover {
            border: none !important;
            outline: none !important;
          }
        </style>
      </head>

    <body>
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "") wrapper-full-page @endif">

            @if (auth()->check() && request()->route()->getName() != "")
                @include('layouts.navbars.sidebar')
                @include('pages/sidebarstyle')
            @endif

            <div class="@if (auth()->check() && request()->route()->getName() != "") main-panel @endif">
                @include('layouts.navbars.navbar')
                @yield('content')
                @include('layouts.footer.nav')
            </div>

        </div>
       


    </body>
        <!--   Core JS Files   -->
    <script src="{{ asset('light-bootstrap/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!--  Chartist Plugin  -->
    <script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
    <!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>
    {{-- bootstrap 5 cdn link --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @stack('js')
    <script>
      $(document).ready(function () {
        
        $('#facebook').sharrre({
          share: {
            facebook: true
          },
          enableHover: false,
          enableTracking: false,
          enableCounter: false,
          click: function(api, options) {
            api.simulateClick();
            api.openPopup('facebook');
          },
          template: '<i class="fab fa-facebook-f"></i> Facebook',
          url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });

        $('#google').sharrre({
          share: {
            googlePlus: true
          },
          enableCounter: false,
          enableHover: false,
          enableTracking: true,
          click: function(api, options) {
            api.simulateClick();
            api.openPopup('googlePlus');
          },
          template: '<i class="fab fa-google-plus"></i> Google',
          url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });

        $('#twitter').sharrre({
          share: {
            twitter: true
          },
          enableHover: false,
          enableTracking: false,
          enableCounter: false,
          buttons: {
            twitter: {
              via: 'CreativeTim'
            }
          },
          click: function(api, options) {
            api.simulateClick();
            api.openPopup('twitter');
          },
          template: '<i class="fab fa-twitter"></i> Twitter',
          url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });
      });
    </script> 
    <script>
    $(document).ready(function() {
        $('.edit-btn').click(function(){
           var applicationNumber = $(this).data('application-number');
           $('#applicationNumber').val(applicationNumber);
           $('#editModal').modal('show');
        });
        $('#saveChanges').click(function() {
            var applicationNumber = $('#applicationNumber').val();
            var newAmount = $('#newAmount').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });    
        
        $.ajax({
          url : '/update-amount/' + applicationNumber,
          method : 'POST',
          data : {newAmount : newAmount},
          success : function(response) {
            console.log('New Amount:', newAmount);
            console.log('Application Number:', applicationNumber);

            $('#message').text('Amount updated Successfully');
            setTimeout(function()  {
              $('#editModal').modal('hide');
              location.reload();
              var rowToUpdate = $('#dataTable tbody tr[data-application-number="' +applicationNumber+ '"]');
              rowToUpdate.find('.amount_granted').text(newAmount);
            
          }, 1500);
          
        }, 
          error: function (xhr, status, error) {
        console.log(xhr.responseText); // Log the detailed error response
        alert('An error occurred while updating the amount');
         
          }
        });
      });
    });
   </script>
   <script>
    $(document).ready(function () {
        $('.approve-btn').click(function () {
            var applicationNumber = $(this).data('application-number');
            var approveButton = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/approve-application/' + applicationNumber,
                method: 'POST',
                success: function (response) {
                    
                    // Update the status cell with "Approved" text
                    var rowToUpdate = $('#dataTable tbody tr[data-application-number="' + applicationNumber + '"]');
                    rowToUpdate.find('.status').text('Approved');
                   
                    approveButton.text('Approved');
                  
                   var approvalMessage = $('#approval-message');
                   approvalMessage.text('Loan application approved successfully');
                   approvalMessage.show(); 
                   
   
                   setTimeout(function () {
                   approvalMessage.hide();
                   
                 }, 3000); 
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Log the detailed error response
                    alert('An error occurred while approving the loan application');
                }
            });
        });
    });   
</script>

   
    
</html>

 <!--error : function() {
   alert('An error occured while updating the amount');-->

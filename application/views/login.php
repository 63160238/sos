<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Smart Apartment</title>

    <!-- page css -->
    <link href="dist/css/pages/login-register-lock.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Smart Apartment</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material text-center" id="loginForm" >
                    <a href="javascript:void(0)" class="db"><img src="assets/images/Group 9.png" alt="Home" />
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username" id="username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password" id="password">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Log In</button><br>
                            <span id="errMsg" class="text-danger"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        loginForm.onsubmit = function(e){
        // $('#loginSubmit').click(function(e){
          e.preventDefault();

          var username = $('#username').val();
          var password = $('#password').val();

          if(!username || !password){
              var errMsg = !username ? "Enter your username" : "Enter your password";

              $('#errMsg').html(errMsg);
          }else{
            // console.log('login');
              $('#errMsg').removeClass('text-danger');
              $('#errMsg').addClass('text-warning');
              $('#errMsg').html("กำลังตรวจสอบความถูกต้อง......");

              $.ajax({
                  url: "login/checkLogin",
                  method: "POST",
                  dataType: 'json',
                  data: {username:username, password:password}
              }).done(function(returnedData){
                if(returnedData.status === 1){
                  $('#errMsg').removeClass('text-warning');
                  $('#errMsg').addClass('text-success');
                  $('#errMsg').html('ตรวจสอบความถูกต้องเรียบร้อย. กำลังเข้าสู่ระบบ....');
                  $('#errMsg').html('กำลังเข้าสู่ระบบ....');

                  handleLoginRedirect();
                }else{
                  $('#errMsg').removeClass('text-warning');
                  $('#errMsg').addClass('text-danger');
                  $('#errMsg').html(returnedData.msg);
                }
                //$('#errMsg').html();
              }).fail(function(jqXHR, textStatus){
                  //set error message based on the internet connectivity of the user

                  alert( "Request failed: " + textStatus );
                  $('#errMsg').html("Log in failed. Please check your internet connection and try again later.");

              });
          }
        };
        function handleLoginRedirect(){
            //get the current url to check whether "red_uri" is set. Red_uri is suppose to hold details about the url user was trying to access
            //before been redirected to log in

            var currentUrl = window.location.href;

            //split the url using "red_uri", then get the 1st part after the red_uri (i.e. key 1)
            var uriToRedirectTo = currentUrl.split("red_uri=")[1] || "home";

            //redirect to dashboard
            window.location.replace(uriToRedirectTo);
        }
    </script>

</body>

</html>

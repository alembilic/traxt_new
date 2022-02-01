<!DOCTYPE html>
<html>
<head>
    <title>Traxr</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="favicon.ico">

    <!-- JavaScript Resources -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Baloo+2:400,500,600,700,800|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
    <link href="/assets/css/main.css?ver=1" rel="stylesheet">

    <script>$(function () {
            Login.init();
        });</script>
</head>

<body class="login">
<!-- Pen Title-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-bc-grad login-section">
                <div class="form-box bc-white">
                    <div class="form-header pad-3">
                        <img src="/img/traxr-logo-dark.svg" class="form-logo">
                    </div>
                    <div class="form">
                        <p class="form-heading align-center">Login to your account</p>
                        @if($success)
                        <p style="color: green;">We sent you an email</p>
                        @endif
                        <form class="login-form" action="/app/resetpassword" method="POST">
                            @csrf
                            <input type="email" name="email" placeholder="Email Address" value="{{ $displayEmail }}" required/>
                            @if (!$hasEmail)
                            <div class='help-block' id='user-error'>Email Address not entered<br></div>
                            @endif
                            <input type="hidden" name="form_submission" value="forgot_password">
                            <button class="bc-btn-primary ">Reset Password</button>
                        </form>
                        <div class="form-footer-links">
                            <a href="/app/login" class="form-footer-link fw-700">Go to login</a>
                            <a href="/pricing" class="form-footer-link fw-700">Not Yet a member?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Form Module-->
<div class="module form-module">
</div>
<div class="text-muted text-center" id="login-footer">
</div>
<script src="/assets/jquery/jquery.slim.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/custom.js"></script>
<script>
    // Initialize Tooltips
    $('[data-toggle="tooltip"], .show-tooltip').tooltip({container: 'body', animation: false});
</script>

</body>
</html>

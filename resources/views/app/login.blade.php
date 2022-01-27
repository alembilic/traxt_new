<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Traxr</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/ico" href="/favicon.ico">

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
                                <form class="login-form" action="/app/login" method="POST">
                                    @csrf
                                    @if($authFailed ?? false)
                                        <div class='help-block' id='user-error'>Login or password invalid</div>
                                    @endif
                                    <input type="text" placeholder="Your email/username" name="username"/>
                                    <input type="password" placeholder="Your password" name="password"/>
                                    <button class="bc-btn-primary ">login</button>
                                    <input type="hidden" name="form_submission" value="login">
                                </form>
                                <div class="form-footer-links">
                                    <a href="/app/resetpassword" class="form-footer-link fw-700">Forgot Your password?</a>
                                    <a href="/pricing" class="form-footer-link fw-700">Not Yet a member?</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Form Module-->

        <script src="/assets/jquery/jquery.slim.min.js"></script>
        <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/custom.js"></script>
        <script>
            // Initialize Tooltips
            $('[data-toggle="tooltip"], .show-tooltip').tooltip({container: 'body', animation: false});
        </script>

    </body>
</html>

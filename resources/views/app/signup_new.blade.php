@extends('promo.layout')
@section('titles')
    <title>Traxr Signup - World class service for monitoring links</title>
    <meta name="description" content="Signup for our service">
    <meta name="author" content="">
    <link rel="canonical" href="https://traxr.net/signup" />
    <style>
        .nav{
            background: #FFFFFF;
            box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.08);
        }
        .nav-burger-item, .nav-burger-item::after, .nav-burger-item::before{
            background-color: rgba(0, 0, 0, 0.85);
        }
        .form-group label{
            font-family: 'Nunito';
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 24px;
            color: rgba(0, 0, 0, 0.85);
            width: 100%;
        }
        .form-group input{
            border: 1px solid #D6D6D6;
            border-radius: 12px;
            height: 48px;
            margin-top: 10px;
        }
        .form-heading{
            margin-bottom:40px;
            font-size: 26px;
            font-weight: 700;
        }
        .text-blue{
            color: #1890FF
        }
        .referral-small-text{
            font-weight: 500;
            font-size: 12px;
        }
        ::placeholder {
            font-size: 14px;
            color: #D6D6D6;
        }
        .form-check-label{
            font-size: 14px;
        }
        .form-check-input{
            margin-top: 6px;
        }
        .main-signup-btn{
            padding: 8px 16px;
            height: 48px;
            background: #F5F5F5;
            border: 1px solid #D9D9D9;
            box-shadow: 0px 2px 0px rgba(0, 0, 0, 0.016);
            border-radius: 2px;
            margin-top: 40px;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            text-align: center;
            color: rgba(0, 0, 0, 0.25);
        }
        .have-acc{
            font-size: 14px;
        }
    </style>
@endsection

@section('traxr-logo')
    <a href="/" class="nav-logo-link"><img src="/img/traxr-logo-dark.svg"></a>
@endsection
@section('content')
<section>
    <div class="p-3 px-2">
        <div>
            <p class="form-heading">Sign up to <span class="text-blue">Traxr</span></p>
        </div>

        <form action="/app/signup.php" method="post" id="myForm">
            <div class="form-group">
                <label>First Name*
                    <input type="text" name="firstname" class="form-control" value="{{ $formData['firstname'] ?? '' }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>Last Name*
                    <input type="text" name="lastname" class="form-control" value="{{ $formData['lastname'] ?? '' }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>E-mail*
                    <input type="email" name="email" placeholder="example@email.com" class="form-control" value="{{ $formData['email'] ?? '' }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>Password*
                    <input type="password" name="password" placeholder="8+ character" class="form-control" value="{{ $formData['password'] ?? '' }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>Confirm Password*
                    <input type="password" name="conf_password" class="form-control" value="{{ $formData['conf_password'] ?? '' }}" required>
                </label>
            </div>
            <div class="form-group">
                <label>Referral code
                    <p class="referral-small-text"><span class="text-blue">Click here</span> to read more</p>
                    <input type="text" name="referral_code" placeholder="XYIGNH%^" class="form-control" value="{{ $formData['referral_code'] ?? '' }}">
                </label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="terms-conditions" name="terms" value="1" required>
                <label class="form-check-label" for="terms-conditions">Accept <span class="text-blue">Terms and Conditions</span></label>
            </div>

            <div class="main-signup-btn">
                <span>Sign me up</span>
            </div>
        </form>

        <div class="text-center font-weight-bold my-4 have-acc">
            Already have an account? <span class="text-blue">Sign in</span>
        </div>

{{--        <input type="hidden" name="username" placeholder="Username" value="{{ $formData['username'] ?? '' }}"/>--}}
{{--        <input type="text" name="firstname" placeholder="First Name" value="{{ $formData['firstname'] ?? '' }}" required/>--}}
{{--        <input type="text" name="lastname" placeholder="Last Name" value="{{ $formData['lastname'] ?? '' }}" required/>--}}
{{--        <input type="password" name="password" placeholder="Password" value="{{ $formData['password'] ?? '' }}" required/>--}}
{{--        <input type="password" name="conf_password" placeholder="Confirm Password" value="{{ $formData['conf_password'] ?? '' }}" required/>--}}
{{--        <input type="email" name="email" placeholder="Email Address" value="{{ $formData['email'] ?? '' }}" required/>--}}
{{--        <input type="email" name="conf_email" placeholder="Confirm Email Address" value="{{ $formData['conf_email'] ?? '' }}" required/>--}}
{{--        <div class="form-divider"></div>--}}
{{--        <input type="hidden" name="form_submission" value="register">--}}
{{--        <input type="text" name="company" placeholder="Company" value="{{ $formData['company'] ?? '' }}" required/>--}}
{{--        <input type="text" name="vat_number" id="vat_number" placeholder="Vat NO (DK40388737)" value="{{ $formData['vat_number'] ?? '' }}" required/>--}}
{{--        <input type="hidden" name="vat_valid" id="vat_valid" value="{{ $formData['vat_valid'] ?? '' }}" required/>--}}
{{--        <input type="text" name="city" placeholder="City" value="{{ $formData['city'] ?? '' }}" required/>--}}
{{--        <input type="text" name="address" placeholder="Address" value="{{ $formData['address'] ?? '' }}" required/>--}}
    </div>
</section>
@endsection
@section('footer')
    <div></div>
@endsection
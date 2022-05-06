<!DOCTYPE html>
<html>
<head>
    <title>Traxr - Register Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Baloo+2:400,500,600,700,800|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">
    <script src="/app/admin/js/jquery-2.1.3.min.js"></script>
    <script src="/app/admin/js/jquery-ui.js"></script>
    <script src="/app/admin/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162383577-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-162383577-1');
    </script>

    <script>
        function isEU(countryCode) {
            return (jQuery.inArray(countryCode, {!! json_encode(config('app.eu_country_codes'))  !!}));
        }

        $(document).ready(function () {
            $("#vat_number").blur(function () {
                var formvat = $("#vat_number").val();
                var ctry = formvat.substring(0, 2);
                var vat = formvat.substring(2);
                vat = vat.replace("-", "");
                if (formvat !== vat)
                    $("#vat_number").val(ctry + vat);
                var up_ctry = ctry.toUpperCase();
                if (up_ctry !== 'DK') {
                    $.getJSON("/api/vat?countryCode=" + up_ctry + "&vatNo=" + vat, function (data) {
                        if (data.status === 'success' || data.status === 'error') {
                            if (data.valid) {
                                $("#vat_number").css('border', '1px solid #d9d9d9');
                                $("#vat_valid").val(data.isEU ? 'EU' : 'WORLD');

                                $("#vat_number").css('border', '1px solid #d9d9d9');
                            } else {
                                $("#vat_valid").val('');
                                $("#vat_number").css('border', '2px solid red');
                            }
                        }
                    });
                } else {
                    $("#vat_valid").val('DK');
                    $("#vat_number").css('border', '1px solid #d9d9d9');
                }
            });
            $("#myForm").submit(function () {
                var formvat = $("#vat_number").val();
                var ctry = formvat.substring(0, 2);
                var selected_ctry = $('select[name="land"]').children("option:selected").val();
                var vat = formvat.substring(3);
                var up_ctry = ctry.toUpperCase();
                if (up_ctry !== 'DK') {
                    $.getJSON("/api/vat?countryCode=" + up_ctry + "&vatNo=" + vat, function (data) {
                        if (data.status === 'success') {
                            if (data.valid) {
                                $("#vat_valid").val(data.isEU ? 'EU' : 'WORLD');
                                $("#vat_number").css('border', '1px solid #d9d9d9');
                            } else {
                                $("#vat_valid").val('');
                                $("#vat_number").css('border', '2px solid red');
                            }
                        }
                    });
                } else {
                    $("#vat_valid").val('DK');
                    $("#vat_number").css('border', '1px solid #d9d9d9');
                }
                if ($("#vat_number").val() !== '' && selected_ctry !== up_ctry) {
                    alert('Selected country and VAT code country selection must fit')
                    return false;
                }
                if (!$("#terms").prop('checked')) {
                    $("#termstext").css('color', 'red');
                    return false;
                }
            });
        });
    </script>
</head>

<body class="login">
<!-- Pen Title-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-bc-grad sign-up-section">
                <div class="form-box bc-white wide-box">
                    <div class="form-header pad-2">
                        <img src="/img/traxr-logo-dark.svg" class="form-logo">
                    </div>
                    <p class="form-heading align-center">Sign up for an account</p>
                    <div style="color: red;">
                        @foreach($validationErrors ?? [] as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    <form action="/app/signup.php" method="post" id="myForm" class="sign-up-form">
                        @csrf
                        <input type="hidden" name="username" placeholder="Username" value="{{ $formData['username'] ?? '' }}"/>
                        <input type="text" name="firstname" placeholder="First Name" value="{{ $formData['firstname'] ?? '' }}" required/>
                        <input type="text" name="lastname" placeholder="Last Name" value="{{ $formData['lastname'] ?? '' }}" required/>
                        <input type="password" name="password" placeholder="Password" value="{{ $formData['password'] ?? '' }}" required/>
                        <input type="password" name="conf_password" placeholder="Confirm Password" value="{{ $formData['conf_password'] ?? '' }}" required/>
                        <input type="email" name="email" placeholder="Email Address" value="{{ $formData['email'] ?? '' }}" required/>
                        <input type="email" name="conf_email" placeholder="Confirm Email Address" value="{{ $formData['conf_email'] ?? '' }}" required/>
                        <div class="form-divider"></div>
                        <input type="hidden" name="form_submission" value="register">
                        <input type="text" name="company" placeholder="Company" value="{{ $formData['company'] ?? '' }}" required/>
                        <input type="text" name="vat_number" id="vat_number" placeholder="Vat NO (DK40388737)" value="{{ $formData['vat_number'] ?? '' }}" required/>
                        <input type="hidden" name="vat_valid" id="vat_valid" value="{{ $formData['vat_valid'] ?? '' }}" required/>
                        <input type="text" name="city" placeholder="City" value="{{ $formData['city'] ?? '' }}" required/>
                        <input type="text" name="address" placeholder="Address" value="{{ $formData['address'] ?? '' }}" required/>
                        <select name="land" id="country" required>
                            <option selected="true" disabled="disabled">Choose country</option>
                            <option value="DK">Denmark</option>
                            <option value="AF">Afghanistan</option>
                            <option value="AX">Åland Islands</option>
                            <option value="AL">Albania</option>
                            <option value="DZ">Algeria</option>
                            <option value="AS">American Samoa</option>
                            <option value="AD">Andorra</option>
                            <option value="AO">Angola</option>
                            <option value="AI">Anguilla</option>
                            <option value="AQ">Antarctica</option>
                            <option value="AG">Antigua and Barbuda</option>
                            <option value="AR">Argentina</option>
                            <option value="AM">Armenia</option>
                            <option value="AW">Aruba</option>
                            <option value="AU">Australia</option>
                            <option value="AT">Austria</option>
                            <option value="AZ">Azerbaijan</option>
                            <option value="BS">Bahamas</option>
                            <option value="BH">Bahrain</option>
                            <option value="BD">Bangladesh</option>
                            <option value="BB">Barbados</option>
                            <option value="BY">Belarus</option>
                            <option value="BE">Belgium</option>
                            <option value="BZ">Belize</option>
                            <option value="BJ">Benin</option>
                            <option value="BM">Bermuda</option>
                            <option value="BT">Bhutan</option>
                            <option value="BO">Bolivia, Plurinational State of</option>
                            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                            <option value="BA">Bosnia and Herzegovina</option>
                            <option value="BW">Botswana</option>
                            <option value="BV">Bouvet Island</option>
                            <option value="BR">Brazil</option>
                            <option value="IO">British Indian Ocean Territory</option>
                            <option value="BN">Brunei Darussalam</option>
                            <option value="BG">Bulgaria</option>
                            <option value="BF">Burkina Faso</option>
                            <option value="BI">Burundi</option>
                            <option value="KH">Cambodia</option>
                            <option value="CM">Cameroon</option>
                            <option value="CA">Canada</option>
                            <option value="CV">Cape Verde</option>
                            <option value="KY">Cayman Islands</option>
                            <option value="CF">Central African Republic</option>
                            <option value="TD">Chad</option>
                            <option value="CL">Chile</option>
                            <option value="CN">China</option>
                            <option value="CX">Christmas Island</option>
                            <option value="CC">Cocos (Keeling) Islands</option>
                            <option value="CO">Colombia</option>
                            <option value="KM">Comoros</option>
                            <option value="CG">Congo</option>
                            <option value="CD">Congo, the Democratic Republic of the</option>
                            <option value="CK">Cook Islands</option>
                            <option value="CR">Costa Rica</option>
                            <option value="CI">Côte d'Ivoire</option>
                            <option value="HR">Croatia</option>
                            <option value="CU">Cuba</option>
                            <option value="CW">Curaçao</option>
                            <option value="CY">Cyprus</option>
                            <option value="CZ">Czech Republic</option>
                            <option value="DK">Denmark</option>
                            <option value="DJ">Djibouti</option>
                            <option value="DM">Dominica</option>
                            <option value="DO">Dominican Republic</option>
                            <option value="EC">Ecuador</option>
                            <option value="EG">Egypt</option>
                            <option value="SV">El Salvador</option>
                            <option value="GQ">Equatorial Guinea</option>
                            <option value="ER">Eritrea</option>
                            <option value="EE">Estonia</option>
                            <option value="ET">Ethiopia</option>
                            <option value="FK">Falkland Islands (Malvinas)</option>
                            <option value="FO">Faroe Islands</option>
                            <option value="FJ">Fiji</option>
                            <option value="FI">Finland</option>
                            <option value="FR">France</option>
                            <option value="GF">French Guiana</option>
                            <option value="PF">French Polynesia</option>
                            <option value="TF">French Southern Territories</option>
                            <option value="GA">Gabon</option>
                            <option value="GM">Gambia</option>
                            <option value="GE">Georgia</option>
                            <option value="DE">Germany</option>
                            <option value="GH">Ghana</option>
                            <option value="GI">Gibraltar</option>
                            <option value="GR">Greece</option>
                            <option value="GL">Greenland</option>
                            <option value="GD">Grenada</option>
                            <option value="GP">Guadeloupe</option>
                            <option value="GU">Guam</option>
                            <option value="GT">Guatemala</option>
                            <option value="GG">Guernsey</option>
                            <option value="GN">Guinea</option>
                            <option value="GW"></option>
                            <option value="GY">Guyana</option>
                            <option value="HT">Haiti</option>
                            <option value="HM">Heard Island and McDonald Islands</option>
                            <option value="VA">Holy See (Vatican City State)</option>
                            <option value="HN">Honduras</option>
                            <option value="HK">Hong Kong</option>
                            <option value="HU">Hungary</option>
                            <option value="IS">Iceland</option>
                            <option value="IN">India</option>
                            <option value="ID">Indonesia</option>
                            <option value="IR">Iran, Islamic Republic of</option>
                            <option value="IQ">Iraq</option>
                            <option value="IE">Ireland</option>
                            <option value="IM">Isle of Man</option>
                            <option value="IL">Israel</option>
                            <option value="IT">Italy</option>
                            <option value="JM">Jamaica</option>
                            <option value="JP">Japan</option>
                            <option value="JE">Jersey</option>
                            <option value="JO">Jordan</option>
                            <option value="KZ">Kazakhstan</option>
                            <option value="KE">Kenya</option>
                            <option value="KI">Kiribati</option>
                            <option value="KP"></option>
                            <option value="KR">Korea, Republic of</option>
                            <option value="KW">Kuwait</option>
                            <option value="KG">Kyrgyzstan</option>
                            <option value="LA">Lao People's Democratic Republic</option>
                            <option value="LV">Latvia</option>
                            <option value="LB">Lebanon</option>
                            <option value="LS">Lesotho</option>
                            <option value="LR">Liberia</option>
                            <option value="LY">Libya</option>
                            <option value="LI">Liechtenstein</option>
                            <option value="LT">Lithuania</option>
                            <option value="LU">Luxembourg</option>
                            <option value="MO">Macao</option>
                            <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                            <option value="MG">Madagascar</option>
                            <option value="MW">Malawi</option>
                            <option value="MY">Malaysia</option>
                            <option value="MV">Maldives</option>
                            <option value="ML">Mali</option>
                            <option value="MT">Malta</option>
                            <option value="MH">Marshall Islands</option>
                            <option value="MQ">Martinique</option>
                            <option value="MR">Mauritania</option>
                            <option value="MU">Mauritius</option>
                            <option value="YT">Mayotte</option>
                            <option value="MX">Mexico</option>
                            <option value="FM">Micronesia, Federated States of</option>
                            <option value="MD"></option>
                            <option value="MC">Monaco</option>
                            <option value="MN">Mongolia</option>
                            <option value="ME">Montenegro</option>
                            <option value="MS">Montserrat</option>
                            <option value="MA">Morocco</option>
                            <option value="MZ">Mozambique</option>
                            <option value="MM">Myanmar</option>
                            <option value="NA">Namibia</option>
                            <option value="NR">Nauru</option>
                            <option value="NP">Nepal</option>
                            <option value="NL">Netherlands</option>
                            <option value="NC">New Caledonia</option>
                            <option value="NZ">New Zealand</option>
                            <option value="NI">Nicaragua</option>
                            <option value="NE">Niger</option>
                            <option value="NG">Nigeria</option>
                            <option value="NU">Niue</option>
                            <option value="NF">Norfolk Island</option>
                            <option value="MP">Northern Mariana Islands</option>
                            <option value="NO">Norway</option>
                            <option value="OM">Oman</option>
                            <option value="PK">Pakistan</option>
                            <option value="PW">Palau</option>
                            <option value="PS">Palestinian Territory, Occupied</option>
                            <option value="PA">Panama</option>
                            <option value="PG">Papua New Guinea</option>
                            <option value="PY">Paraguay</option>
                            <option value="PE">Peru</option>
                            <option value="PH">Philippines</option>
                            <option value="PN">Pitcairn</option>
                            <option value="PL">Poland</option>
                            <option value="PT">Portugal</option>
                            <option value="PR">Puerto Rico</option>
                            <option value="QA">Qatar</option>
                            <option value="RE">Réunion</option>
                            <option value="RO">Romania</option>
                            <option value="RU">Russian Federation</option>
                            <option value="RW">Rwanda</option>
                            <option value="BL">Saint Barthélemy</option>
                            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                            <option value="KN">Saint Kitts and Nevis</option>
                            <option value="LC">Saint Lucia</option>
                            <option value="MF">Saint Martin (French part)</option>
                            <option value="PM">Saint Pierre and Miquelon</option>
                            <option value="VC">Saint Vincent and the Grenadines</option>
                            <option value="WS">Samoa</option>
                            <option value="SM">San Marino</option>
                            <option value="ST">Sao Tome and Principe</option>
                            <option value="SA">Saudi Arabia</option>
                            <option value="SN">Senegal</option>
                            <option value="RS">Serbia</option>
                            <option value="SC">Seychelles</option>
                            <option value="SL">Sierra Leone</option>
                            <option value="SG">Singapore</option>
                            <option value="SX"></option>
                            <option value="SK">Slovakia</option>
                            <option value="SI">Slovenia</option>
                            <option value="SB">Solomon Islands</option>
                            <option value="SO">Somalia</option>
                            <option value="ZA">South Africa</option>
                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                            <option value="SS">South Sudan</option>
                            <option value="ES">Spain</option>
                            <option value="LK">Sri Lanka</option>
                            <option value="SD">Sudan</option>
                            <option value="SR">Suriname</option>
                            <option value="SJ">Svalbard and Jan Mayen</option>
                            <option value="SZ">Swaziland</option>
                            <option value="SE">Sweden</option>
                            <option value="CH">Switzerland</option>
                            <option value="SY">Syrian Arab Republic</option>
                            <option value="TW"></option>
                            <option value="TJ">Tajikistan</option>
                            <option value="TZ">Tanzania, United Republic of</option>
                            <option value="TH">Thailand</option>
                            <option value="TL">Timor-Leste</option>
                            <option value="TG">Togo</option>
                            <option value="TK">Tokelau</option>
                            <option value="TO">Tonga</option>
                            <option value="TT">Trinidad and Tobago</option>
                            <option value="TN">Tunisia</option>
                            <option value="TR">Turkey</option>
                            <option value="TM">Turkmenistan</option>
                            <option value="TC">Turks and Caicos Islands</option>
                            <option value="TV">Tuvalu</option>
                            <option value="UG">Uganda</option>
                            <option value="UA">Ukraine</option>
                            <option value="AE">United Arab Emirates</option>
                            <option value="GB">United Kingdom</option>
                            <option value="US">United States</option>
                            <option value="UM">United States Minor Outlying Islands</option>
                            <option value="UY">Uruguay</option>
                            <option value="UZ">Uzbekistan</option>
                            <option value="VU">Vanuatu</option>
                            <option value="VE">Venezuela, Bolivarian Republic of</option>
                            <option value="VN">Viet Nam</option>
                            <option value="VG">Virgin Islands, British</option>
                            <option value="VI">Virgin Islands, U.S.</option>
                            <option value="WF">Wallis and Futuna</option>
                            <option value="EH">Western Sahara</option>
                            <option value="YE">Yemen</option>
                            <option value="ZM">Zambia</option>
                            <option value="ZW">Zimbabwe</option>
                        </select>
                        <div class="checkbox-box fw-700">
                            <input type="checkbox" name="terms" id="terms" value="1" required>
                            <label for="terms" class="terms" id="termstext" style="margin-left: 20px;">
                                Accept terms and conditions <a href="/conditions" target="_blank">(Read)</a>
                            </label>
                        </div>
                        <button class="bc-btn-primary btn-sign-up">Yes, Sign me up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Initialize Tooltips
    $('[data-toggle="tooltip"], .show-tooltip').tooltip({container: 'body', animation: false});
</script>

</body>
</html>

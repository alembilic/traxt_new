<!DOCTYPE html>
<html>
<head>
    <title>Traxr - Plans</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="favicon.ico">

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/fonts/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="/dist/css/plans.css" rel="stylesheet">

    <link href="/admin/css/style.css" rel="stylesheet">

    <!-- JavaScript Resources -->
    <script src="/admin/js/jquery-2.1.3.min.js"></script>
    <script src="/admin/js/jquery-ui.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>

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
        $(function () {
            $(".tooltips").tooltip();
        });
    </script>

</head>

<body class="login" style="background-color:#fff">
<!-- Pen Title-->
<div class="pen-title">
    <h1><img src="https://traxr.net/wp-content/uploads/2019/03/Logo2-small.png" class="login_logo"/></h1>
</div>
<!-- Form Module-->
<!-- Register -->

@php
    /* @var \App\Entities\Product|null $plan */
    /* @var \App\Entities\Product $availablePlan */
    /* @var \App\Entities\User $user */
    /* @var \App\Entities\OrderSubscription|null $subscription */
@endphp
<div class="form" id="form-register">
    <div style="text-align: center">
        <h1>Select Subscription</h2>
            @if (!$user->isActivePlan())
                <p style="color:red; font-size: 16px;">You account is expired or suspended. Renew to continue the use of
                    Traxr.</p>
            @endif
            Switch between monthly and yearly subscriptions. Save up to 168 USD pr. year.
            <br/>
            <div class="toggle_prices">
                <label class="toggler toggler--is-active" id="filt-monthly">Monthly</label>
                <div class="toggle">
                    <input type="checkbox" id="switcher" class="check">
                    <b class="b switch"></b>
                </div>
                <label class="toggler" id="filt-yearly">Yearly</label>
            </div>
    </div>
    <div class="s04-pricing wrapper-full" id="monthly">
        <!-- Register -->
        @if (isset($_GET['cancelpayment']))
            <div style="color: red;font-weight:bold;">You canceled the Payment, pick a plan to continue</div>
        @endif
        @foreach ($plans as $key => $availablePlan)
            <div class="s04-pricing-column {{ $key === 3 ? 'recommended' : '' }}">
                <div class="s04-pricing-ribbon"><span>{{ $key === 3 ? 'Recommended' : '' }}</span></div>
                <div class="s04-pricing-header">
                    <h1>{{ $availablePlan->getProductName() }}</h1>
                </div>
                <div class="s04-pricing-amount">
                    <strong>
                        <span class="s04-pricing-currency">$</span><span>{{ number_format($availablePlan->getPricePerMonth() / 100, 2, '.', '') }}</span>
                        <code>00</code>
                    </strong>
                    <div class="s04-pricing-frequency">Monthly</div>
                </div>
                <ul class="s04-pricing-feature">
                    <li>
                        Domains
                        <span title="Domains">{{ $availablePlan->getDomains() }}</span>
                    </li>
                    <li>
                        Links
                        <span title="Links">{{ $availablePlan->getLinks() }}</span>
                    </li>
                    <li>
                        Response Codes:
                        <span title="Response Codes">
                        @if($availablePlan->getResponseCode())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="We track response code of links, and check if they redirect"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We Dont track response code of links, and dont check if they redirect"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Manuel update:
                        <span title="Manuel update">
                        @if($availablePlan->getManualUpdate())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="You can force an update to check your links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="You cant force an update to check your links"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        JS render service:
                        <span title="JS render service">
                            @if($availablePlan->getRenderService())
                                <i class="fas fa-check white tooltips"
                                   title="We check the JavaScript rendered version of you links origin"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We dont check the JavaScript rendered version of you links origin"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Canonical Check
                        <span title="Canonical Check">
                            @if($availablePlan->getCanonical())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="We check for canonical links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We check for Canonical links"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Index Check
                        <span title="Index Check">
                            @if($availablePlan->getIndexService())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="Indexservice include. We track if google index your links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="Indexservice Not include. We Dont track if google index your links"></i>
                            @endif
                        </span>
                    </li>
                    @if ($availablePlan->getFreeTrail())
                        <li>Free Trail<span title="Free Trail">{{ $availablePlan->getFreeTrail() }}</span> Days</li>
                    @endif
                </ul>
                <div class="s04-pricing-footer">
                    <a class="s04-pricing-button" href="/app/plans/{{ $availablePlan->getMixId() }}/once">Pick this plan</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="s04-pricing wrapper-full hide" id="yearly">
        <!-- Register -->
        @if (isset($_GET['cancelpayment']))
            <div style="color: red;font-weight:bold;">You canceled the Payment, pick a plan to continue</div>
        @endif
        @foreach ($plans as $key => $availablePlan)
            <div class="s04-pricing-column {{ $key === 3 ? 'recommended' : '' }}">
                <div class="s04-pricing-ribbon"><span>{{ $key === 3 ? 'Recommended' : '' }}</span></div>
                <div class="s04-pricing-header">
                    <h1>{{ $availablePlan->getProductName() }}</h1>
                </div>
                <div class="s04-pricing-amount">
                    <strong>
                        <span class="s04-pricing-currency">$</span><span>{{ number_format($availablePlan->getPriceSubscription() / 100, 2, '.', '') }}</span>
                        <code>00</code>
                    </strong>
                    <div class="s04-pricing-frequency">Paid Yearly</div>
                </div>
                <ul class="s04-pricing-feature">
                    <li>
                        Domains
                        <span title="Domains">{{ $availablePlan->getDomains() }}</span>
                    </li>
                    <li>
                        Links
                        <span title="Links">{{ $availablePlan->getLinks() }}</span>
                    </li>
                    <li>
                        Response Codes:
                        <span title="Response Codes">
                        @if($availablePlan->getResponseCode())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="We track response code of links, and check if they redirect"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We Dont track response code of links, and dont check if they redirect"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Manuel update:
                        <span title="Manuel update">
                        @if($availablePlan->getManualUpdate())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="You can force an update to check your links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="You cant force an update to check your links"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        JS render service:
                        <span title="JS render service">
                            @if($availablePlan->getRenderService())
                                <i class="fas fa-check white tooltips"
                                   title="We check the JavaScript rendered version of you links origin"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We dont check the JavaScript rendered version of you links origin"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Canonical Check
                        <span title="Canonical Check">
                            @if($availablePlan->getCanonical())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="We check for canonical links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="We check for Canonical links"></i>
                            @endif
                        </span>
                    </li>
                    <li>
                        Index Check
                        <span title="Index Check">
                            @if($availablePlan->getIndexService())
                                <i class="fas fa-check white tooltips" title=""
                                   data-original-title="Indexservice include. We track if google index your links"></i>
                            @else
                                <i class="fa fa-stop-circle red tooltips" title=""
                                   data-original-title="Indexservice Not include. We Dont track if google index your links"></i>
                            @endif
                        </span>
                    </li>
                    @if ($availablePlan->getFreeTrail())
                        <li>Free Trail<span title="Free Trail">{{ $availablePlan->getFreeTrail() }}</span> Days</li>
                    @endif
                </ul>
                <div class="s04-pricing-footer">
                    <a class="s04-pricing-button" href="/app/plans/{{ $availablePlan->getMixId() }}/subscribe">Pick this plan</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="text-muted text-center" id="login-footer">
</div>

<script>
    var e = document.getElementById("filt-monthly"),
        d = document.getElementById("filt-yearly"),
        t = document.getElementById("switcher"),
        m = document.getElementById("monthly"),
        y = document.getElementById("yearly");

    e.addEventListener("click", function () {
        t.checked = false;
        e.classList.add("toggler--is-active");
        d.classList.remove("toggler--is-active");
        m.classList.remove("hide");
        y.classList.add("hide");
    });

    d.addEventListener("click", function () {
        t.checked = true;
        d.classList.add("toggler--is-active");
        e.classList.remove("toggler--is-active");
        m.classList.add("hide");
        y.classList.remove("hide");
    });

    t.addEventListener("click", function () {
        d.classList.toggle("toggler--is-active");
        e.classList.toggle("toggler--is-active");
        m.classList.toggle("hide");
        y.classList.toggle("hide");
    })
</script>
</body>
</html>

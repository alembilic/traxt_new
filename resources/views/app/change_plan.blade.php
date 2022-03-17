<!DOCTYPE html>
<html>
<head>
    <title>Traxr - Plans</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="favicon.ico">

    <!-- JavaScript Resources -->
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,500,600,700,800|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link href="/assets/css/main.css?ver=1.0" rel="stylesheet">
    <script>
        $( function() {
            $(".tooltips").tooltip();
        } );
    </script>
</head>

@php
    /* @var \App\Entities\Product|null $plan */
    /* @var \App\Entities\User $user */
@endphp
<body class="login">
<!-- Pen Title-->
<section class="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-bc-grad pre-payment-section">
                <div class="form-box bc-white wide-box-pre-payment">
                    <div class="form-header pad-2">
                        <img src="/img/traxr-logo-dark.svg" class="form-logo">
                    </div>
                    <p class="form-heading-pre-payment-sub">Awesome, now you are just a few steps from unleasing the full power of Traxr!</p>
                    <p class="form-heading-pre-payment align-center">Your Order</p>
                    <div class="pre-payment-box-wrapper pad-2">
                        <div class="pre-payment-box pad-2 align-left bc-light-light-grey">
                            <h3>Invoice Details</h3>
                            <div class="sm-divider-left"></div>
                            <ul>
                                <li>Company: </td><td>{{ $user->getCompany() }}</td></li>
                                <li>VAT no: </td><td>{{ $user->getVatNumber() }}</li>
                                <li>Firstname: </td><td>{{ $user->getFirstname() }}</li>
                                <li>Lastname: </td><td>{{ $user->getLastname() }}</li>
                                <li>Address : </td><td>{{ $user->getAddress() }}</li>
                                <li>City : </td><td>{{ $user->getCity() }}</li>
                                <li>Email: </td><td>{{ $user->getEmail() }}</li>
                            </ul>
                        </div>

                        <div class="pre-payment-box pad-2 align-left bc-light-light-grey">
                            <h3>Products details (change)</h3>
                            <div class="sm-divider-left"></div>
                            <ul>
                                <li>Product name: <span class="color-grey">{{ $plan->getProductName() }}</span></li>
                                <li>Domains: <span class="color-grey">{{ $plan->getDomains() }}</span></li>
                                <li>Links: <span class="color-grey">{{ $plan->getLinks() }}</span></li>
                                <li><img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment"><span class="color-black">HTTP headers</span></li>
                                <li><img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment"><span class="color-black">HTML headers</span></li>
                                <li>@if($plan->getIndexService())
                                        <img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment">
                                    @else
                                        <img src="/img/icons/price-not-icon.svg" class="price-check-icon-pre-payment">
                                    @endif<span class="color-black">Index services</span></li>
                                <li>@if($plan->getResponseCode())
                                        <img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment">
                                    @else
                                        <img src="/img/icons/price-not-icon.svg" class="price-check-icon-pre-payment">
                                    @endif<span class="color-black">Reponscodes</span></li>
                                <li>@if($plan->getManualUpdate())
                                        <img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment">
                                    @else
                                        <img src="/img/icons/price-not-icon.svg" class="price-check-icon-pre-payment">
                                    @endif<span class="color-black">Manuel update:</span></li>
                                <li>@if($plan->getRenderService())
                                        <img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment">
                                    @else
                                        <img src="/img/icons/price-not-icon.svg" class="price-check-icon-pre-payment">
                                    @endif<span class="color-black">JS Render service</span></li>
                                <li>@if($plan->getCanonical())
                                        <img src="/img/icons/price-check-icon.svg" class="price-check-icon-pre-payment">
                                    @else
                                        <img src="/img/icons/price-not-icon.svg" class="price-check-icon-pre-payment">
                                    @endif<span class="color-black">Canonical checks</span></li>
                            </ul>
                        </div>

                        <div class="pre-payment-box pad-2 align-left bc-dark-blue color-white">
                            <table class="pre-payment-pricing-table">
                                <tr>
                                    <td>Price</td>
                                    <td class="align-right">{{ number_format($price, 2, '.', '') }} USD</td>
                                </tr>
                                <tr>
                                    <td>VAT</td>
                                    <td>{{ $vat }} USD VAT</td>
                                </tr>
                                <tr>
                                    <td>Total including</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            </table>
                            <div class="pre-payment-pricing-bottom align-center">
                                <p>Every {{ $type === 'monthly' ? $plan->getRenew() : $plan->getRenewSubscribe() }} Months</p>
                                @if ($plan->getFreeTrail())
                                    <p class="color-grey pad-top-2">First withdrawal: {{ $nextDueDate }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (!$plan->getPricePerMonth())
                        <a class="btn-custom bc-btn-primary align-center btn-go-to-payment" href="/app/dashboard">Goto dashboard</a>
                    @else
                        <a href="/app/subscription/pay?product={{ $plan->getMixId() }}&type={{ $type }}" class="btn-custom bc-btn-primary align-center btn-go-to-payment">Go to Payment</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

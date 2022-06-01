@php
    /* @var \App\Entities\User $user */
    /* @var \App\Entities\Notification $notification */
    $user = \EntityManager::find(\App\Entities\User::class, Auth::user()->getAuthIdentifier());
    $page = preg_replace('!(\?.*)!i', '', str_replace('/app/', '', $_SERVER['REQUEST_URI']));
    $isAccount = in_array($page, ['/app/minkonto', '/app/invoices', '/app/myplan']);
@endphp
    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traxr - @yield('pageName')</title>
    <!-- Bootstrap CSS -->
    <link href="/assets-app/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets-app/css/all.min.css">
    <link rel="stylesheet" href="/assets-app/css/style.css">
    <link rel="stylesheet" href="/assets-app/css/table.css">
    <link rel="stylesheet" href="/assets-app/css/custom-style.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="/assets-app/js/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="/assets-app/js/bootstrap.bundle.min.js"></script>
    <!--  -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!--  -->
    <script src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <!-- Charts JS -->
    <script src="/assets-app/js/chart.min.js"></script>
    <!-- Main JS -->
    <script src="/assets-app/js/apis.js"></script>
    <script src="/assets-app/js/main.js"></script>
    <script src="/assets-app/js/cookie.js"></script>

    <script src="/assets-app/js/sweetalert2.js"></script>

    <link href="/admin/css/introjs.min.css" rel="stylesheet">
    <script src="/admin/js/intro.min.js"></script>
@if($newSignup ?? false)
    <!-- Global site tag (gtag.js) - Google Ads: 619209208 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-619209208"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-619209208');
        gtag('event', 'conversion', {'send_to': 'AW-619209208/mNa3CPODxNUBEPjDoacC'});
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162383577-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-162383577-1');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2197430967008741');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2197430967008741&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
    <script>
        fbq('track', 'Purchase', {currency: "USD", value: 1.00});
    </script>
@endif
    <script>
        var apiToken = '{{ $user->getApiToken() }}';
        $(function () {
            $('.notifications-icon-bell img').on('click', function () {
                $('.notifications-popup').slideToggle('fast');
            });
            $('.notifications-icon-bell .btn-close').on('click', function () {
                $('.notifications-popup').slideToggle('fast');
            });
            $('.notification-item').on('click', function () {
                $('.notification-message', this).slideToggle('fast');
            });
            $(".read-all").click(function () {
                $.ajax({
                    url: '/api/notifications/markAsReadAll',
                    type: 'PUT',
                    headers: {'X-Auth-Token': apiToken},
                    success: function (data) {
                        $('.notifications-list').html('<div class="notification-item-empty">No new messages</div>');
                        $('.read-all').addClass('hidden');
                        $('.header-icon-number').html(0);
                    },
                    error: function () {
                        location.reload();
                    }
                });
            });
        });
    </script>
</head>
<body>
<div class="page-wrap">
    <header class="header">
        <a href="/app/" class="logo">
            <img src="/assets-app/images/logo.png" alt="logo">
        </a>
        <a href="#" class="sidebar-btn d-md-none">
            <img src="/assets-app/images/icon-sidebar.svg" alt="icon-sidebar">
        </a>
        <nav class="header-nav d-none d-md-flex">
            <a href="#" onclick="startIntro();" class="header-icon">
                <img src="/assets-app/images/icon-question.svg" alt="icon-question">
            </a>
            <span class="header-icon notifications-icon-bell">
                <img src="/assets-app/images/icon-bell.svg" alt="icon-bell">
                @if($user->getNotifications()->count())
                <span class="header-icon-number">{{ $user->getNotifications()->count() }}</span>
                @endif
                <div class="notifications-popup">
                    <div class="btn-close"></div>
                    <div class="notifications-list">
                        @if($user->getNotifications()->count())
                            @foreach($user->getNotifications() as $notification)
                            <div class="notification-item" rel="{{ $notification->getId() }}">
                                <div class="notification-title">{{ $notification->getTitle() }}</div>
                                <div class="notification-message">{!! $notification->getMessage() !!} </div>
                            </div>
                            @endforeach
                        @else
                            <div class="notification-item-empty">No new messages</div>
                        @endif
                    </div>
                    <div class="read-all-container">
                        <a href="#" class="btn btn-primary read-all{{$user->getNotifications()->count() ? '' : ' hidden'}}">Mark all as read</a>
                    </div>
                </div>
            </span>
            <a href="/app/myaccount" class="user-profile-link">
                <div class="img-wrap">
                    <img height="24" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->getEmail()))) }}.jpg"  alt="user-avatar"/>
                </div>
                {{ $user->getFirstName() ? $user->getFirstName() . ' ' . $user->getLastName() : $user->getEmail() }}
            </a>
        </nav>
    </header>
    <main class="main-content">
        <div class="sidebar">
            <nav class="header-nav d-md-none">
                <a href="#" class="header-icon">
                    <img src="/assets-app/images/icon-question.svg" alt="icon-question">
                </a>
                <a href="#" class="header-icon">
                    <img src="/assets-app/images/icon-bell.svg" alt="icon-bell">
                    @if($user->getNotifications()->count())
                        <span class="header-icon-number">{{ $user->getNotifications()->count() }}</span>
                    @endif
                </a>
                <a href="{!! route('myaccount') !!}" class="user-profile-link">
                    <div class="img-wrap">
                        <img height="24" src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->getEmail()))) }}.jpg"  alt="user-avatar"/>
                    </div>
                    {{ $user->getFirstName() ? $user->getFirstName() . ' ' . $user->getLastName() : $user->getEmail() }}
                </a>
            </nav>
            <ul class="list-group">
                @if($user->getPlan() && $user->getPlan()->getBureau())
                    <li class="list-group-item{!! Route::is('managers') ? ' active' : '' !!}">
                        <a href="{!! route('managers') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_360_22711)">
                                        <path d="M13.5 1.49707H0.5C0.223437 1.49707 0 1.72051 0 1.99707V11.9971C0 12.2736 0.223437 12.4971 0.5 12.4971H13.5C13.7766 12.4971 14 12.2736 14 11.9971V1.99707C14 1.72051 13.7766 1.49707 13.5 1.49707ZM12.875 11.3721H1.125V2.62207H12.875V11.3721ZM8.53594 6.43457H10.4641C10.4844 6.43457 10.5 6.37832 10.5 6.30957V5.55957C10.5 5.49082 10.4844 5.43457 10.4641 5.43457H8.53594C8.51562 5.43457 8.5 5.49082 8.5 5.55957V6.30957C8.5 6.37832 8.51562 6.43457 8.53594 6.43457ZM8.61094 8.68457H11.5125C11.5734 8.68457 11.6234 8.62832 11.6234 8.55957V7.80957C11.6234 7.74082 11.5734 7.68457 11.5125 7.68457H8.61094C8.55 7.68457 8.5 7.74082 8.5 7.80957V8.55957C8.5 8.62832 8.55 8.68457 8.61094 8.68457ZM2.5 9.5127H3.18594C3.25156 9.5127 3.30469 9.46113 3.30937 9.39551C3.36875 8.60645 4.02812 7.98145 4.82812 7.98145C5.62813 7.98145 6.2875 8.60645 6.34688 9.39551C6.35156 9.46113 6.40469 9.5127 6.47031 9.5127H7.15625C7.1732 9.51272 7.18999 9.50929 7.20557 9.50262C7.22116 9.49595 7.23523 9.48618 7.24692 9.4739C7.25862 9.46163 7.26769 9.4471 7.27359 9.4312C7.27949 9.41531 7.2821 9.39838 7.28125 9.38145C7.2375 8.54863 6.78125 7.82363 6.11562 7.41113C6.40916 7.08847 6.57135 6.66765 6.57031 6.23145C6.57031 5.26426 5.79063 4.48145 4.82969 4.48145C3.86875 4.48145 3.08906 5.26426 3.08906 6.23145C3.08906 6.68613 3.26094 7.09863 3.54375 7.41113C3.20489 7.62112 2.92188 7.91 2.71891 8.25311C2.51593 8.59621 2.399 8.98334 2.37812 9.38145C2.37188 9.45332 2.42812 9.5127 2.5 9.5127ZM4.82812 5.41895C5.27344 5.41895 5.63594 5.78301 5.63594 6.23145C5.63594 6.67988 5.27344 7.04395 4.82812 7.04395C4.38281 7.04395 4.02031 6.67988 4.02031 6.23145C4.02031 5.78301 4.38281 5.41895 4.82812 5.41895Z" fill="black" fill-opacity="0.85"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_360_22711">
                                            <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            {{ trans('template.managers') }}
                        </a>
                    </li>
                @else
                    <li class="list-group-item{{ Route::is('dashboard') ? ' active' : '' }}" aria-current="true">
                        <a href="{!! route('dashboard') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5 0H0.5C0.223437 0 0 0.223438 0 0.5V10.5C0 10.7766 0.223437 11 0.5 11H13.5C13.7766 11 14 10.7766 14 10.5V0.5C14 0.223438 13.7766 0 13.5 0ZM12.875 3.25H9.5625V1.125H12.875V3.25ZM12.875 6.75H9.5625V4.25H12.875V6.75ZM5.4375 4.25H8.5625V6.75H5.4375V4.25ZM8.5625 3.25H5.4375V1.125H8.5625V3.25ZM1.125 4.25H4.4375V6.75H1.125V4.25ZM1.125 1.125H4.4375V3.25H1.125V1.125ZM1.125 7.75H4.4375V9.875H1.125V7.75ZM5.4375 7.75H8.5625V9.875H5.4375V7.75ZM12.875 9.875H9.5625V7.75H12.875V9.875Z" fill="black"/>
                                </svg>
                            </div>
                            {{ trans('template.dashboard') }}
                        </a>
                    </li>
                    <li class="list-group-item{!! Route::is('links') ? ' active' : '' !!}">
                        <a href="{!! route('links') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.96855 9.3957C7.94506 9.37244 7.91334 9.35939 7.88027 9.35939C7.84721 9.35939 7.81549 9.37244 7.79199 9.3957L5.97637 11.2113C5.13574 12.052 3.71699 12.141 2.78887 11.2113C1.85918 10.2816 1.94824 8.86445 2.78887 8.02383L4.60449 6.2082C4.65293 6.15977 4.65293 6.08008 4.60449 6.03164L3.98262 5.40977C3.95912 5.3865 3.9274 5.37345 3.89434 5.37345C3.86127 5.37345 3.82955 5.3865 3.80605 5.40977L1.99043 7.22539C0.668555 8.54727 0.668555 10.6863 1.99043 12.0066C3.3123 13.327 5.45137 13.3285 6.77168 12.0066L8.5873 10.191C8.63574 10.1426 8.63574 10.0629 8.5873 10.0145L7.96855 9.3957ZM12.0092 1.98945C10.6873 0.667578 8.54824 0.667578 7.22793 1.98945L5.41074 3.80508C5.38748 3.82857 5.37443 3.8603 5.37443 3.89336C5.37443 3.92642 5.38748 3.95815 5.41074 3.98164L6.03105 4.60195C6.07949 4.65039 6.15918 4.65039 6.20762 4.60195L8.02324 2.78633C8.86387 1.9457 10.2826 1.85664 11.2107 2.78633C12.1404 3.71602 12.0514 5.1332 11.2107 5.97383L9.39512 7.78945C9.37185 7.81295 9.3588 7.84467 9.3588 7.87774C9.3588 7.9108 9.37185 7.94252 9.39512 7.96602L10.017 8.58789C10.0654 8.63633 10.1451 8.63633 10.1936 8.58789L12.0092 6.77227C13.3295 5.45039 13.3295 3.31133 12.0092 1.98945ZM8.53262 4.81602C8.50912 4.79275 8.4774 4.7797 8.44434 4.7797C8.41127 4.7797 8.37955 4.79275 8.35605 4.81602L4.81699 8.35352C4.79373 8.37701 4.78068 8.40874 4.78068 8.4418C4.78068 8.47486 4.79373 8.50659 4.81699 8.53008L5.43574 9.14883C5.48418 9.19727 5.56387 9.19727 5.61231 9.14883L9.1498 5.61133C9.19824 5.56289 9.19824 5.4832 9.1498 5.43477L8.53262 4.81602Z" fill="black" fill-opacity="0.85"/>
                                </svg>
                            </div>
                            {{ trans('template.links') }}
                        </a>
                    </li>
                    <li class="list-group-item{!! Route::is('domains') ? ' active' : '' !!}">
                        <a href="{!! route('domains') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.8063 11.0748C11.809 11.0707 11.8131 11.0666 11.8158 11.0625C12.7113 9.99746 13.25 8.6248 13.25 7.125C13.25 5.6252 12.7113 4.25254 11.8172 3.1875C11.8145 3.1834 11.8104 3.18066 11.8076 3.17656C11.7926 3.15879 11.7789 3.14238 11.7639 3.12598C11.7584 3.11914 11.7529 3.11367 11.7475 3.10684L11.6914 3.04258L11.69 3.04121C11.6695 3.01797 11.6477 2.99473 11.6271 2.97148L11.6258 2.97012C11.582 2.92363 11.5383 2.87715 11.4932 2.83203L11.4918 2.83066L11.4262 2.76504L11.4221 2.76094C11.4016 2.74043 11.3811 2.72129 11.3605 2.70215C11.3537 2.69531 11.3469 2.68848 11.3387 2.68164C11.325 2.66797 11.3113 2.65566 11.2977 2.64336C11.2936 2.63926 11.2881 2.63516 11.284 2.62969C10.193 1.61797 8.73145 1 7.125 1C5.51855 1 4.05703 1.61797 2.96465 2.62969C2.96055 2.63379 2.95508 2.63789 2.95098 2.64336C2.9373 2.65566 2.92363 2.66934 2.90996 2.68301C2.90312 2.68984 2.89629 2.69668 2.88809 2.70352C2.86758 2.72266 2.84707 2.74316 2.82656 2.7623L2.82246 2.76641L2.75684 2.83203L2.75547 2.8334C2.71035 2.87852 2.6666 2.925 2.62285 2.97148L2.62148 2.97285C2.59961 2.99609 2.5791 3.01934 2.55859 3.04258L2.55723 3.04395C2.53809 3.06445 2.51895 3.08633 2.50117 3.1082C2.4957 3.11504 2.49023 3.12051 2.48477 3.12734C2.46973 3.14375 2.45605 3.16152 2.44102 3.17793C2.43828 3.18203 2.43418 3.18477 2.43145 3.18887C1.53867 4.25254 1 5.6252 1 7.125C1 8.6248 1.53867 9.99746 2.43281 11.0625C2.43555 11.0666 2.43965 11.0707 2.44238 11.0748L2.48477 11.1254C2.49023 11.1322 2.4957 11.1377 2.50117 11.1445L2.55723 11.2088C2.55723 11.2102 2.55859 11.2102 2.55859 11.2115C2.5791 11.2348 2.59961 11.258 2.62148 11.2799L2.62285 11.2812C2.6666 11.3277 2.71035 11.3742 2.7541 11.4193L2.75547 11.4207C2.77734 11.4426 2.79785 11.4645 2.81973 11.485L2.82383 11.4891C2.86895 11.5342 2.91543 11.5779 2.96191 11.6203C4.05703 12.632 5.51855 13.25 7.125 13.25C8.73145 13.25 10.193 12.632 11.2854 11.6203C11.3319 11.5776 11.3775 11.5339 11.4221 11.4891L11.4262 11.485C11.448 11.4631 11.4699 11.4426 11.4904 11.4207L11.4918 11.4193C11.5369 11.3742 11.5807 11.3277 11.623 11.2812L11.6244 11.2799C11.6449 11.2566 11.6668 11.2348 11.6873 11.2115C11.6873 11.2102 11.6887 11.2102 11.6887 11.2088C11.7078 11.1883 11.727 11.1664 11.7447 11.1445C11.7502 11.1377 11.7557 11.1322 11.7611 11.1254C11.7766 11.1089 11.7916 11.092 11.8063 11.0748ZM11.8623 9.1252C11.6736 9.5709 11.4248 9.98379 11.1213 10.3584C10.7795 10.063 10.4057 9.80664 10.007 9.59414C10.1656 8.95293 10.2641 8.24883 10.29 7.50781H12.252C12.2109 8.06699 12.0797 8.60977 11.8623 9.1252ZM12.252 6.74219H10.29C10.2641 6.00117 10.1656 5.29707 10.007 4.65586C10.4076 4.44258 10.7809 4.18555 11.1213 3.8916C11.7811 4.70368 12.1757 5.69866 12.252 6.74219ZM9.1252 2.3877C9.66797 2.61738 10.1615 2.93457 10.5963 3.33379C10.3437 3.54884 10.0719 3.74014 9.78418 3.90527C9.56953 3.29004 9.29473 2.75547 8.9748 2.32754C9.02539 2.34668 9.07598 2.36719 9.1252 2.3877ZM7.88652 11.9662C7.76074 12.0646 7.63496 12.1398 7.50781 12.1904V9.6543C8.0503 9.69214 8.58378 9.81295 9.08965 10.0125C8.97617 10.3488 8.84492 10.6592 8.69316 10.9395C8.45527 11.3824 8.17637 11.7365 7.88652 11.9662ZM8.69316 3.31055C8.84355 3.59219 8.97617 3.90254 9.08965 4.2375C8.58378 4.43705 8.0503 4.55786 7.50781 4.5957V2.06094C7.63359 2.11152 7.76074 2.18535 7.88652 2.28516C8.17637 2.51348 8.45527 2.86758 8.69316 3.31055ZM7.50781 8.88731V7.50781H9.52441C9.50254 8.11211 9.42734 8.69863 9.30156 9.25508L9.29746 9.27148C8.7237 9.05391 8.12032 8.92438 7.50781 8.88731ZM7.50781 6.74219V5.3627C8.13398 5.32441 8.73555 5.1918 9.29746 4.97852L9.30156 4.99492C9.42734 5.55137 9.50254 6.13652 9.52441 6.74219H7.50781ZM6.74219 7.50781V8.88731C6.11602 8.92559 5.51445 9.0582 4.95254 9.27148L4.94844 9.25508C4.82266 8.69863 4.74746 8.11348 4.72559 7.50781H6.74219ZM4.72559 6.74219C4.74746 6.13789 4.82266 5.55137 4.94844 4.99492L4.95254 4.97852C5.51445 5.1918 6.11465 5.32441 6.74219 5.3627V6.74219H4.72559ZM6.74219 9.6543V12.1891C6.61641 12.1385 6.48926 12.0646 6.36348 11.9648C6.07363 11.7365 5.79336 11.3811 5.55547 10.9381C5.40508 10.6564 5.27246 10.3461 5.15898 10.0111C5.66758 9.81152 6.19668 9.69258 6.74219 9.6543ZM6.74219 4.5957C6.1997 4.55786 5.66622 4.43705 5.16035 4.2375C5.27383 3.90117 5.40508 3.59082 5.55684 3.31055C5.79473 2.86758 6.07363 2.51211 6.36484 2.28379C6.49062 2.18535 6.61641 2.11016 6.74355 2.05957V4.5957H6.74219ZM5.1248 2.3877C5.17539 2.36719 5.22461 2.34668 5.2752 2.32754C4.95527 2.75547 4.68047 3.29004 4.46582 3.90527C4.17871 3.74121 3.90664 3.5498 3.65371 3.33379C4.08848 2.93457 4.58203 2.61738 5.1248 2.3877ZM2.3877 5.1248C2.57637 4.6791 2.8252 4.26621 3.12871 3.8916C3.46914 4.18555 3.84238 4.44258 4.24297 4.65586C4.08438 5.29707 3.98594 6.00117 3.95996 6.74219H1.99805C2.03906 6.18301 2.17031 5.64023 2.3877 5.1248ZM1.99805 7.50781H3.95996C3.98594 8.24883 4.08438 8.95293 4.24297 9.59414C3.84427 9.80664 3.47054 10.063 3.12871 10.3584C2.46895 9.54632 2.07429 8.55134 1.99805 7.50781ZM5.1248 11.8623C4.58203 11.6326 4.08848 11.3154 3.65371 10.9162C3.90664 10.7002 4.17871 10.5102 4.46582 10.3447C4.68047 10.96 4.95527 11.4945 5.2752 11.9225C5.22461 11.9033 5.17402 11.8828 5.1248 11.8623ZM9.1252 11.8623C9.07461 11.8828 9.02539 11.9033 8.9748 11.9225C9.29473 11.4945 9.56953 10.96 9.78418 10.3447C10.0713 10.5088 10.3434 10.7002 10.5963 10.9162C10.1639 11.3138 9.66628 11.6338 9.1252 11.8623Z" fill="black" fill-opacity="0.85"/>
                                </svg>
                            </div>
                            {{ trans('template.domains') }}
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" onclick="startIntro(); return false;">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 0.875C3.61758 0.875 0.875 3.61758 0.875 7C0.875 10.3824 3.61758 13.125 7 13.125C10.3824 13.125 13.125 10.3824 13.125 7C13.125 3.61758 10.3824 0.875 7 0.875ZM7 12.0859C4.1918 12.0859 1.91406 9.8082 1.91406 7C1.91406 4.1918 4.1918 1.91406 7 1.91406C9.8082 1.91406 12.0859 4.1918 12.0859 7C12.0859 9.8082 9.8082 12.0859 7 12.0859Z" fill="black" fill-opacity="0.85"/>
                                    <path d="M8.52557 4.32946C8.11541 3.96989 7.57401 3.77301 6.99979 3.77301C6.42557 3.77301 5.88416 3.97125 5.47401 4.32946C5.04744 4.7027 4.81229 5.20446 4.81229 5.74176V5.84567C4.81229 5.90582 4.86151 5.95504 4.92166 5.95504H5.57791C5.63807 5.95504 5.68729 5.90582 5.68729 5.84567V5.74176C5.68729 5.13883 6.27654 4.64801 6.99979 4.64801C7.72303 4.64801 8.31229 5.13883 8.31229 5.74176C8.31229 6.16696 8.01151 6.5566 7.5453 6.73571C7.25545 6.84645 7.00936 7.04059 6.83299 7.29489C6.65389 7.55465 6.56092 7.86637 6.56092 8.18219V8.47614C6.56092 8.53629 6.61014 8.58551 6.67029 8.58551H7.32655C7.3867 8.58551 7.43592 8.53629 7.43592 8.47614V8.16578C7.43663 8.03306 7.47731 7.90363 7.55267 7.79437C7.62803 7.68511 7.73456 7.6011 7.85838 7.55328C8.66502 7.24293 9.18592 6.53199 9.18592 5.74176C9.18729 5.20446 8.95213 4.7027 8.52557 4.32946ZM6.45291 10.0074C6.45291 10.1524 6.51053 10.2915 6.61309 10.3941C6.71565 10.4966 6.85475 10.5543 6.99979 10.5543C7.14483 10.5543 7.28393 10.4966 7.38649 10.3941C7.48904 10.2915 7.54666 10.1524 7.54666 10.0074C7.54666 9.86235 7.48904 9.72325 7.38649 9.62069C7.28393 9.51813 7.14483 9.46051 6.99979 9.46051C6.85475 9.46051 6.71565 9.51813 6.61309 9.62069C6.51053 9.72325 6.45291 9.86235 6.45291 10.0074Z" fill="black" fill-opacity="0.85"/>
                                </svg>
                            </div>
                            {{ trans('template.how_to_use') }}
                        </a>
                    </li>
                    <li class="list-group-item{!! Route::is('guide') ? ' active' : '' !!}">
                        <a href="{!! route('guide') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_360_22703)">
                                        <path d="M13.5 1.51758H9.925C9.15781 1.51758 8.40781 1.73789 7.7625 2.15352L7 2.64258L6.2375 2.15352C5.59283 1.73797 4.84199 1.51717 4.075 1.51758H0.5C0.223437 1.51758 0 1.74102 0 2.01758V10.8926C0 11.1691 0.223437 11.3926 0.5 11.3926H4.075C4.84219 11.3926 5.59219 11.6129 6.2375 12.0285L6.93125 12.4754C6.95156 12.4879 6.975 12.4957 6.99844 12.4957C7.02187 12.4957 7.04531 12.4895 7.06563 12.4754L7.75937 12.0285C8.40625 11.6129 9.15781 11.3926 9.925 11.3926H13.5C13.7766 11.3926 14 11.1691 14 10.8926V2.01758C14 1.74102 13.7766 1.51758 13.5 1.51758ZM4.075 10.2676H1.125V2.64258H4.075C4.62812 2.64258 5.16562 2.80039 5.62969 3.09883L6.39219 3.58789L6.5 3.6582V10.877C5.75625 10.477 4.925 10.2676 4.075 10.2676ZM12.875 10.2676H9.925C9.075 10.2676 8.24375 10.477 7.5 10.877V3.6582L7.60781 3.58789L8.37031 3.09883C8.83438 2.80039 9.37187 2.64258 9.925 2.64258H12.875V10.2676ZM5.20156 4.64258H2.29844C2.2375 4.64258 2.1875 4.6957 2.1875 4.75977V5.46289C2.1875 5.52695 2.2375 5.58008 2.29844 5.58008H5.2C5.26094 5.58008 5.31094 5.52695 5.31094 5.46289V4.75977C5.3125 4.6957 5.2625 4.64258 5.20156 4.64258ZM8.6875 4.75977V5.46289C8.6875 5.52695 8.7375 5.58008 8.79844 5.58008H11.7C11.7609 5.58008 11.8109 5.52695 11.8109 5.46289V4.75977C11.8109 4.6957 11.7609 4.64258 11.7 4.64258H8.79844C8.7375 4.64258 8.6875 4.6957 8.6875 4.75977ZM5.20156 6.83008H2.29844C2.2375 6.83008 2.1875 6.8832 2.1875 6.94727V7.65039C2.1875 7.71445 2.2375 7.76758 2.29844 7.76758H5.2C5.26094 7.76758 5.31094 7.71445 5.31094 7.65039V6.94727C5.3125 6.8832 5.2625 6.83008 5.20156 6.83008ZM11.7016 6.83008H8.79844C8.7375 6.83008 8.6875 6.8832 8.6875 6.94727V7.65039C8.6875 7.71445 8.7375 7.76758 8.79844 7.76758H11.7C11.7609 7.76758 11.8109 7.71445 11.8109 7.65039V6.94727C11.8125 6.8832 11.7625 6.83008 11.7016 6.83008Z" fill="black" fill-opacity="0.85"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_360_22703">
                                            <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            {{ trans('template.guide_tour') }}
                        </a>
                    </li>
                    @if ($user->isSuperAdmin())
                    <li class="list-group-item{!! Route::is('admin') ? ' active' : '' !!}">
                        <a href="#">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_360_22711)">
                                        <path d="M13.5 1.49707H0.5C0.223437 1.49707 0 1.72051 0 1.99707V11.9971C0 12.2736 0.223437 12.4971 0.5 12.4971H13.5C13.7766 12.4971 14 12.2736 14 11.9971V1.99707C14 1.72051 13.7766 1.49707 13.5 1.49707ZM12.875 11.3721H1.125V2.62207H12.875V11.3721ZM8.53594 6.43457H10.4641C10.4844 6.43457 10.5 6.37832 10.5 6.30957V5.55957C10.5 5.49082 10.4844 5.43457 10.4641 5.43457H8.53594C8.51562 5.43457 8.5 5.49082 8.5 5.55957V6.30957C8.5 6.37832 8.51562 6.43457 8.53594 6.43457ZM8.61094 8.68457H11.5125C11.5734 8.68457 11.6234 8.62832 11.6234 8.55957V7.80957C11.6234 7.74082 11.5734 7.68457 11.5125 7.68457H8.61094C8.55 7.68457 8.5 7.74082 8.5 7.80957V8.55957C8.5 8.62832 8.55 8.68457 8.61094 8.68457ZM2.5 9.5127H3.18594C3.25156 9.5127 3.30469 9.46113 3.30937 9.39551C3.36875 8.60645 4.02812 7.98145 4.82812 7.98145C5.62813 7.98145 6.2875 8.60645 6.34688 9.39551C6.35156 9.46113 6.40469 9.5127 6.47031 9.5127H7.15625C7.1732 9.51272 7.18999 9.50929 7.20557 9.50262C7.22116 9.49595 7.23523 9.48618 7.24692 9.4739C7.25862 9.46163 7.26769 9.4471 7.27359 9.4312C7.27949 9.41531 7.2821 9.39838 7.28125 9.38145C7.2375 8.54863 6.78125 7.82363 6.11562 7.41113C6.40916 7.08847 6.57135 6.66765 6.57031 6.23145C6.57031 5.26426 5.79063 4.48145 4.82969 4.48145C3.86875 4.48145 3.08906 5.26426 3.08906 6.23145C3.08906 6.68613 3.26094 7.09863 3.54375 7.41113C3.20489 7.62112 2.92188 7.91 2.71891 8.25311C2.51593 8.59621 2.399 8.98334 2.37812 9.38145C2.37188 9.45332 2.42812 9.5127 2.5 9.5127ZM4.82812 5.41895C5.27344 5.41895 5.63594 5.78301 5.63594 6.23145C5.63594 6.67988 5.27344 7.04395 4.82812 7.04395C4.38281 7.04395 4.02031 6.67988 4.02031 6.23145C4.02031 5.78301 4.38281 5.41895 4.82812 5.41895Z" fill="black" fill-opacity="0.85"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_360_22711">
                                            <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            {{ trans('template.admin_area') }}
                        </a>
                    </li>
                    @endif
                    <li class="list-group-item{!! Route::is('contacts') ? ' active' : '' !!}">
                        <a href="{!! route('contacts') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_360_22717)">
                                        <path d="M8.28594 8.39551C8.57947 8.07284 8.74167 7.65203 8.74063 7.21582C8.74063 6.24863 7.96094 5.46582 7 5.46582C6.03906 5.46582 5.25938 6.24863 5.25938 7.21582C5.25938 7.67051 5.43125 8.08301 5.71406 8.39551C5.3752 8.60549 5.0922 8.89438 4.88922 9.23748C4.68624 9.58058 4.56932 9.96772 4.54844 10.3658C4.54759 10.3828 4.5502 10.3997 4.5561 10.4156C4.562 10.4315 4.57107 10.446 4.58276 10.4583C4.59446 10.4706 4.60853 10.4803 4.62411 10.487C4.6397 10.4937 4.65648 10.4971 4.67344 10.4971H5.35938C5.425 10.4971 5.47813 10.4455 5.48281 10.3799C5.54219 9.58926 6.20156 8.96582 7.00156 8.96582C7.80156 8.96582 8.46094 9.59082 8.52031 10.3799C8.525 10.4455 8.57812 10.4971 8.64375 10.4971H9.32812C9.34508 10.4971 9.36186 10.4937 9.37745 10.487C9.39304 10.4803 9.40711 10.4706 9.4188 10.4583C9.43049 10.446 9.43956 10.4315 9.44547 10.4156C9.45137 10.3997 9.45397 10.3828 9.45312 10.3658C9.40938 9.53301 8.95312 8.80801 8.28594 8.39551ZM7 8.02832C6.55469 8.02832 6.19219 7.66426 6.19219 7.21582C6.19219 6.76738 6.55469 6.40332 7 6.40332C7.44531 6.40332 7.80781 6.76738 7.80781 7.21582C7.80781 7.66426 7.44531 8.02832 7 8.02832ZM13.5 2.49707H11V1.62207C11 1.55332 10.9438 1.49707 10.875 1.49707H10C9.93125 1.49707 9.875 1.55332 9.875 1.62207V2.49707H7.5625V1.62207C7.5625 1.55332 7.50625 1.49707 7.4375 1.49707H6.5625C6.49375 1.49707 6.4375 1.55332 6.4375 1.62207V2.49707H4.125V1.62207C4.125 1.55332 4.06875 1.49707 4 1.49707H3.125C3.05625 1.49707 3 1.55332 3 1.62207V2.49707H0.5C0.223437 2.49707 0 2.72051 0 2.99707V11.9971C0 12.2736 0.223437 12.4971 0.5 12.4971H13.5C13.7766 12.4971 14 12.2736 14 11.9971V2.99707C14 2.72051 13.7766 2.49707 13.5 2.49707ZM12.875 11.3721H1.125V3.62207H3V4.49707C3 4.56582 3.05625 4.62207 3.125 4.62207H4C4.06875 4.62207 4.125 4.56582 4.125 4.49707V3.62207H6.4375V4.49707C6.4375 4.56582 6.49375 4.62207 6.5625 4.62207H7.4375C7.50625 4.62207 7.5625 4.56582 7.5625 4.49707V3.62207H9.875V4.49707C9.875 4.56582 9.93125 4.62207 10 4.62207H10.875C10.9438 4.62207 11 4.56582 11 4.49707V3.62207H12.875V11.3721Z" fill="black" fill-opacity="0.85"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_360_22717">
                                            <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            {{ trans('template.contacts') }}
                        </a>
                    </li>
                    <li class="list-group-item{!! Route::is('rewards') ? ' active' : '' !!}">
                        <a href="{!! route('rewards') !!}">
                            <div class="icon-wrap">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clips-path="url(#clip0_360_22717)">
                                        <path d="M12.75 3.8457H10.4438C10.6562 3.51133 10.7812 3.11445 10.7812 2.68945C10.7812 1.50039 9.81406 0.533203 8.625 0.533203C7.97813 0.533203 7.39531 0.820703 7 1.27383C6.60469 0.820703 6.02187 0.533203 5.375 0.533203C4.18594 0.533203 3.21875 1.50039 3.21875 2.68945C3.21875 3.11445 3.34219 3.51133 3.55625 3.8457H1.25C0.973437 3.8457 0.75 4.06914 0.75 4.3457V7.4707C0.75 7.53945 0.80625 7.5957 0.875 7.5957H1.5V12.9707C1.5 13.2473 1.72344 13.4707 2 13.4707H12C12.2766 13.4707 12.5 13.2473 12.5 12.9707V7.5957H13.125C13.1938 7.5957 13.25 7.53945 13.25 7.4707V4.3457C13.25 4.06914 13.0266 3.8457 12.75 3.8457ZM7.53125 2.68945C7.53125 2.08633 8.02187 1.5957 8.625 1.5957C9.22812 1.5957 9.71875 2.08633 9.71875 2.68945C9.71875 3.29258 9.22812 3.7832 8.625 3.7832H7.53125V2.68945ZM5.375 1.5957C5.97813 1.5957 6.46875 2.08633 6.46875 2.68945V3.7832H5.375C4.77187 3.7832 4.28125 3.29258 4.28125 2.68945C4.28125 2.08633 4.77187 1.5957 5.375 1.5957ZM1.8125 6.5332V4.9082H6.46875V6.5332H1.8125ZM2.5625 7.5957H6.46875V12.4082H2.5625V7.5957ZM11.4375 12.4082H7.53125V7.5957H11.4375V12.4082ZM12.1875 6.5332H7.53125V4.9082H12.1875V6.5332Z" fill="black" fill-opacity="0.85"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_360_22717">
                                            <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <!-- TODO add translate php variable her -->
                            {{trans('template.rewards')}}
                        </a>
                    </li>
                    <li class="list-group-item has-sub-menu{!! $isAccount ? ' active' : '' !!}">
                        <span>
                            <div class="icon-wrap">
                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4141 10.4322C11.1194 9.73406 10.6916 9.09989 10.1547 8.56504C9.61946 8.02865 8.9854 7.60099 8.28754 7.30567C8.28129 7.30254 8.27504 7.30098 8.26879 7.29785C9.24223 6.59473 9.87504 5.44942 9.87504 4.15723C9.87504 2.0166 8.14066 0.282227 6.00004 0.282227C3.85941 0.282227 2.12504 2.0166 2.12504 4.15723C2.12504 5.44942 2.75785 6.59473 3.73129 7.29942C3.72504 7.30254 3.71879 7.3041 3.71254 7.30723C3.01254 7.60254 2.38441 8.02598 1.84535 8.5666C1.30896 9.10186 0.881296 9.73593 0.585977 10.4338C0.295855 11.117 0.139386 11.8495 0.125039 12.5916C0.124622 12.6083 0.127547 12.6249 0.133642 12.6404C0.139737 12.6559 0.148878 12.6701 0.160527 12.682C0.172176 12.694 0.186098 12.7034 0.201471 12.7099C0.216844 12.7164 0.233358 12.7197 0.250039 12.7197H1.18754C1.25629 12.7197 1.31098 12.665 1.31254 12.5979C1.34379 11.3916 1.82816 10.2619 2.68441 9.40567C3.57035 8.51973 4.74691 8.03223 6.00004 8.03223C7.25316 8.03223 8.42973 8.51973 9.31566 9.40567C10.1719 10.2619 10.6563 11.3916 10.6875 12.5979C10.6891 12.6666 10.7438 12.7197 10.8125 12.7197H11.75C11.7667 12.7197 11.7832 12.7164 11.7986 12.7099C11.814 12.7034 11.8279 12.694 11.8396 12.682C11.8512 12.6701 11.8603 12.6559 11.8664 12.6404C11.8725 12.6249 11.8755 12.6083 11.875 12.5916C11.8594 11.8447 11.7047 11.1182 11.4141 10.4322ZM6.00004 6.84473C5.28285 6.84473 4.60785 6.56504 4.10004 6.05723C3.59223 5.54942 3.31254 4.87442 3.31254 4.15723C3.31254 3.44004 3.59223 2.76504 4.10004 2.25723C4.60785 1.74941 5.28285 1.46973 6.00004 1.46973C6.71723 1.46973 7.39223 1.74941 7.90004 2.25723C8.40785 2.76504 8.68754 3.44004 8.68754 4.15723C8.68754 4.87442 8.40785 5.54942 7.90004 6.05723C7.39223 6.56504 6.71723 6.84473 6.00004 6.84473Z" fill="black" fill-opacity="0.85"/>
                                </svg>
                            </div>
                            {{ trans('template.account') }}
                        </span>
                        <ul class="sub-menu">
                            <li{!! Route::has('myaccount') ? ' class="active"' : '' !!}>
                                <a href="{!! route('myaccount') !!}">
                                </a>
                            </li>
                            <li{!! Route::has('invoices') ? ' class="active"' : '' !!}>
                                <a href="{!! route('invoices') !!}">{{ trans('template.invoices') }}</a>
                            </li>
                            <li{!! Route::has('myplan') ? ' class="active"' : '' !!}>
                                <a href="{!! route('myplan') !!}">{{ trans('template.my_plan') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="list-group-item{!! Route::is('logout') ? ' active' : '' !!}">
                    <a href="{!! route('logout') !!}">
                        <div class="icon-wrap">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.8797 10.8324H12.0391C11.9734 10.8324 11.9188 10.8871 11.9188 10.9527V11.9184H2.07969V2.07773H11.9203V3.04336C11.9203 3.10898 11.975 3.16367 12.0406 3.16367H12.8813C12.9469 3.16367 13.0016 3.11055 13.0016 3.04336V1.47773C13.0016 1.21211 12.7875 0.998047 12.5219 0.998047H1.47969C1.21406 0.998047 1 1.21211 1 1.47773V12.5184C1 12.784 1.21406 12.998 1.47969 12.998H12.5203C12.7859 12.998 13 12.784 13 12.5184V10.9527C13 10.8855 12.9453 10.8324 12.8797 10.8324ZM13.1703 6.89961L10.9531 5.14961C10.8703 5.08399 10.75 5.14336 10.75 5.24805V6.43555H5.84375C5.775 6.43555 5.71875 6.4918 5.71875 6.56055V7.43555C5.71875 7.5043 5.775 7.56055 5.84375 7.56055H10.75V8.74805C10.75 8.85274 10.8719 8.91211 10.9531 8.84649L13.1703 7.09649C13.1853 7.08479 13.1973 7.06985 13.2056 7.0528C13.214 7.03574 13.2183 7.01702 13.2183 6.99805C13.2183 6.97908 13.214 6.96035 13.2056 6.9433C13.1973 6.92624 13.1853 6.9113 13.1703 6.89961Z" fill="black" fill-opacity="0.85"/>
                            </svg>
                        </div>
                        {{ trans('template.logout') }}
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer d-none d-md-block">
                <a href="#" class="sidebar-btn">
                    <img src="/assets-app/images/icon-sidebar.svg" alt="icon-sidebar">
                </a>
            </div>
        </div>
        <div class="content-wrap">
            <div class="content-head">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/app/">{{ trans('template.home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('pageName')</li>
                    </ol>
                </nav>
                @yield('title-section')
            </div>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>
</div>
</body>
</html>

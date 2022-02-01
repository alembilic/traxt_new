<!DOCTYPE html>
<html>
<head>
    <title>Traxr</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/navigation.css" rel="stylesheet">
    <link href="/admin/css/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="/admin/css/style.css?ver=1" rel="stylesheet">
    <link href="/admin/css/dashboard.css" rel="stylesheet">
    <link href="/admin/css/introjs.min.css" rel="stylesheet">
    <link href="/admin/css/modern.css" rel="stylesheet">

    <!-- JavaScript Resources -->
    <script src="/admin/js/jquery-2.1.3.min.js"></script>
    <script src="/admin/js/jquery-ui.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/xavier.js"></script>
    <script src="/js/chart/Chart.js"></script>
    <link rel="stylesheet" href="/app/dist/jquery-confirm.min.css">
    <script src="/app/dist/jquery-confirm.min.js"></script>
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
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=2197430967008741&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
    <script>
        fbq('track', 'Purchase', {currency: "USD", value: 1.00});
    </script>
    @endif
</head>

<body>
<script>
    $(document).ready(function () {
        $(function () {
            $(".tooltips").tooltip();
        });
        $("#notifcations_bell").click(function () {
            $(".allnotifications").slideToggle('fast');
        });
        $('.read_info').hover(
            function () {
                $("#notis_" + $(this).attr('data')).show();
            },
            function () {
                $("#notis_" + $(this).attr('data')).hide();
            }
        );
        $('.delete_all_notifications').hover(
            function () {
                $(".mark_read_all").show();
            },
            function () {
                $(".mark_read_all").hide();
            }
        );
        $(".read_info").click(function () {
            var id = $(this).attr('data');
            $.get("update",
                {
                    read_notification: 1,
                    id: $(this).attr('data')
                },
                function (data, status) {
                    $.get("update",
                        {
                            getnotificationscount: 1
                        },
                        function (data, status) {
                            $(".notifications_number_span").html(data);
                        });
                    //alert($(this).attr('data'));
                    if (data == 1)
                        $("#notis_wrap_" + id).hide('fast');
                    if (data == 'redirect_login')
                        location.reload();
                });
        });
        $(".read_all").click(function () {
            var id = $(this).attr('data');
            $.get("update",
                {
                    read_all: 1
                },
                function (data, status) {
                    //alert($(this).attr('data'));
                    if (data == 1) {
                        $(".messagewrap").hide('fast');
                        $(".notifications_number_span").html(0);
                    }
                    if (data == 'redirect_login')
                        location.reload();
                });
        });
        $('#lang_picker').change(function () {
            $('#lang_picker_form').submit();
        });
    });
</script>
<!-- Page Wrapper -->
<div id="page-wrapper">

    <!-- Side Menu -->
    <nav id="side-menu" class="navbar-default navbar-static-side" role="navigation">
        <div id="sidebar-collapse">

            <div id="logo-element">
                <a class="logo" href="/">
                    <img src="/img/traxr-logo-dark.svg" class="navigation_logo"/>
                </a>
            </div>
        @php
        $user = \EntityManager::find(\App\Entities\User::class, Auth::user()->getAuthIdentifier());
        $pageName = preg_replace('!(\?.*)!i', '', $_SERVER['REQUEST_URI']);
        $isAccount = in_array($pageName, ['/app/minkonto', '/app/invoices', '/app/myplan']);

        /* @var \App\Entities\Products[] $products */
        $products = \EntityManager::getRepository(\App\Entities\Products::class)->findBy([
            'mixId' => $user->getPlan(),
        ]);
        @endphp
        <!-- Site Navigation -->
            <ul class="nav">
                @if(count($products) && current($products)->isBureau())
                <li{!! Route::has('managers') ? ' class="active selected"' : '' !!}>
                    <a href="/app/managers"><i class="fas fa-users"></i> <span class="nav-label">Managers</span></a>
                </li>
                @else
                <li{!! Route::has('guide') ? ' class="active selected"' : '' !!}>
                    <a href="/app/guide"><i class="fas fa-info-circle"></i> <span class="nav-label">How to use</span></a>
                </li>
                <li{!! Route::has('tour') ? ' class="active selected"' : '' !!}>
                    <a href="#" onclick="javascript:startIntro();"><i class="fas fa-question-circle"></i><span class="nav-label">Guided tour</span></a>
                </li>
                <li{!! Route::has('dashboard') ? ' class="active selected"' : '' !!}>
                    <a href="/app/dashboard"><i class="fas fa-home"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li{!! Route::has('domains') ? ' class="active selected"' : '' !!}>
                    <a href="/app/domains"><i class="fas fa-globe"></i> <span class="nav-label">Domains</span></a>
                </li>
                <li{!! Route::has('links') ? ' class="active selected"' : '' !!}>
                    <a href="/app/links"><i class="fas fa-link"></i> <span class="nav-label">Links</span></a>
                </li>
                <li>
                    <a href="/app/logout"><i class="fas fa-sign-out-alt"></i> <span class="nav-label">Logout</span></a>
                </li>
                @endif
                <li{!! $isAccount ? ' class="active selected"' : '' !!}>
                    <a href="#"><i class="fas fa-user"></i> <span class="nav-label">Account</span> <span class="fas fa-angle-double-right"></span></a>
                    <ul class="nav nav-second-level">
                        <li{!! Route::has('minkonto') ? ' class="active selected"' : '' !!}>
                            <a href="/app/myaccount">My Account</a>
                        </li>
                        <li{!! Route::has('invoices') ? ' class="active selected"' : '' !!}>
                            <a href="/app/invoices">Invoices</a>
                        </li>
                        <li{!! Route::has('myplan') ? ' class="active selected"' : '' !!}>
                            <a href="/app/myplan">My plan</a>
                        </li>
                    </ul>
                </li>
                @if ($user->isSuperAdmin())
                <li>
                    <a href="/app/admin"><i class="fas fa-sign-out-alt"></i> <span class="nav-label">Admin Area</span></a>
                </li>
                @endif
            </ul>
            <!-- END Site Navigation -->
        </div>

    </nav>
    <!-- END Side Menu -->
    <!-- Top Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <a class="close-sidebar btn btn-main" href="#"><i class="fas fa-bars"></i> </a>
        <!-- Settings -->
        <!-- User -->
    </nav>
    <!-- END Top Navbar -->
    <!-- Page Content -->
    <div id="page-content" class="gray-bg">

        <!-- Title Header -->
        <div class="title-header white-bg">
            <div class="userinfo">
                <div class="row">
                    <div class="cell" style="display:none;">
                        <form name="lang_picker_form" id="lang_picker_form" method="POST" action="#">
                            <select name="lang_picker" id="lang_picker">
                                <option value="en-US" {!! $user->getLang() === 'en-US' ? 'selected="selected"' : '' !!}>English</option>
                                <option value="da-DK" {!! $user->getLang() === 'da-DK' ? 'selected="selected"' : '' !!}>Danish</option>
                            </select>
                        </form>
                    </div>
                    <div class="cell" id="notification">
                        <div class="notificationwrapper">
                            <i class="far fa-bell" id="notifcations_bell">
                                <span class="notifications_number {{ $user->getNotifications()->count() ? 'noneticolor' : 'noticolor' }}">
                                    <span class="notifications_number_span">{{$user->getNotifications()->count() }}</span>
                                </span>
                            </i>
                            <div class="allnotifications">
                                <div class="messageheader">
                                    New messages: <b class="notifications_number_span">{{$user->getNotifications()->count()}}</b>
                                    <span class="delete_all_notifications">
                                        <i class="fas fa-book-reader read_all"></i>
                                    </span>
                                    <span class="mark_read_all">Mark all as read</span>
                                </div>
                                <div class="messagewrapper">
                                    @if($user->getNotifications()->count())
                                        @foreach ($user->getNotifications() as $notification)
                                            <div class="messagewrap" id="notis_wrap_{{$notification->getId()}}">
                                                <div class="stamp">
                                                    {{ $notification->getCreatedAt()->format('M j, g:ia') }}
                                                    <div class="read_info" data="{{ $notification->getId() }}">
                                                        <span id="notis_{{$notification->getId()}}">Mark as read</span>
                                                        <i class="fas fa-book-reader read"></i>
                                                    </div>
                                                </div>
                                                <div class="message">
                                                    {{ $notification->getMessage() }}
                                                </div>
                                                <div class="markup"></div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="messagewrap">
                                            <div class="stamp">
                                                <div class="read_info"><span>Mark as read</span></div>
                                            </div>
                                            <div class="message" style="text-align: center;">
                                                No new messages
                                            </div>
                                            <div class="markup"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="messagefooter">View all messages</div>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <img
                            src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->getEmail()))) }}.jpg"/>
                        <div class="nametag">
                            {{ $user->getFirstname() ? $user->getFirstname() . ' ' . $user->getLastname() : $user->getEmail() }}
                        </div>
                    </div>
                </div>
            </div>
            <h2>{{ ucfirst($pageName) }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index">Home</a>
                </li>
                <li class="active">{{ ucfirst($pageName) }}</li>
            </ol>
        </div>
        <!-- END Title Header -->
        @yield('content')
        <!-- END Row -->

        <footer>Copyright &copy; Traxr - All rights reserved. </footer>

    </div>

    <!-- Right Sidebar -->
    <div class="sidebar-right">
        <div id="right-sidebar-id">
            <div class="right-sidebar-header"><i class="fas fa-globe"></i>
                <span class="sidebar-header-text">Recently Online</span>
            </div>
            <div class="right-sidebar-section">
                <!-- recentlyOnline(minutes) -->
                @php
                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->gte('timestamp', time() - (5 * 60)))
                        ->setMaxResults(5);
                    $recentUsers = \EntityManager::getRepository(\App\Entities\User::class)
                        ->matching($criteria)
                        ->map(function (\App\Entities\User $user) {
                            return $user->getUsername();
                        })
                        ->toArray();
                @endphp
                {{ implode(' ,', $recentUsers) }}
            </div>
            <div class="right-sidebar-header"><i class="fas fa-bolt"></i>
                <span class="sidebar-header-text">User Activity</span>
            </div>
            <div class="right-sidebar-section">
                @php
                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->neq('username', 'Admin'))
                        ->setMaxResults(1);
                    $userActivity = \EntityManager::getRepository(\App\Entities\User::class)
                        ->matching($criteria)
                        ->map(function (\App\Entities\User $user) {
                            return $user->getUsername() . ' logged on - ' . date(config('app.web_date_format'), $user->getTimestamp());
                        })
                        ->toArray();
                @endphp
                {{ implode(' ,', $userActivity) }}
            </div>
            <div class="right-sidebar-header"><i class="fas fa-chart-line"></i>
                <span class="sidebar-header-text">Statistics</span>
            </div>
            <div class="right-sidebar-section">
                @php
                    $usersCount = \EntityManager::getRepository(\App\Entities\User::class)->count([]);
                    $numActiveGuests = \EntityManager::getRepository(\App\Entities\ActiveGuests::class)->count([]);
                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->in('userLevel', [1, 2]))
                        ->orderBy(['regDate', 'desc']);
                    $adminActivityCount = \EntityManager::getRepository(\App\Entities\User::class)->matching($criteria)->count();

                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->gte('regDate', $user->getPreviousVisit()->getTimestamp()));
                    $usersSince = \EntityManager::getRepository(\App\Entities\User::class)->matching($criteria)->count();

                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->gte('timestamp', time() - 600));
                    $numActiveUsers = \EntityManager::getRepository(\App\Entities\UserSessions::class)->matching($criteria)->count();

                    $criteria = \Doctrine\Common\Collections\Criteria::create()
                        ->where(\Doctrine\Common\Collections\Criteria::expr()->eq('configName', 'record_online_users'));
                    $recordOnline = \EntityManager::getRepository(\App\Entities\Configuration::class)->matching($criteria)->get(0);
                @endphp
                <p><i class='fas fa-check-circle'></i> There are {{ $usersCount }} members.</p>
                <p><i class='fas fa-check-circle'></i> {{ $adminActivityCount }} accounts require activation.</p>
                <p><i class='fas fa-check-circle'></i> {{ $usersSince }} new users have registered since your last visit.</p>
                <p><i class='fas fa-check-circle'></i> There are currently {{ $numActiveUsers }} users and {{ $numActiveGuests }} guests online.</p>
                <p><i class='fas fa-check-circle'></i> Record Users Online : {{ !$recordOnline ? 0 : $recordOnline->getConfigValue() }}</p>
            </div>
        </div>
    </div>
    <!-- END Right Sidebar -->

    <!-- END Page Content -->
</div>
</body>
</html>

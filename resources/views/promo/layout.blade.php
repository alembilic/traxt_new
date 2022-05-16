<!DOCTYPE html>
<html lang="en" class="{!! $page_class ?? '' !!}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/fav/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Baloo+2:400,500,600,700,800|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @sectionMissing('titles')
        <title>Track and Monitor your Links and Mentions online with Easy planning</title>
        <meta name="description" content="Finally you you can monitor and track your backlinks and mentions online in one single software with extraordinary planning tools and measuring. Free Trial">
        <meta name="author" content="">
        <meta property="og:title" content="Monitor your Links with 100% accuracy 24/7 - get full value of all your links" />
        <meta property="og:description" content="Use Traxr.net to get full value of your link building efforts. Get full control of all your valuable links" />
        <meta property="og:image" content="/img/social/main.jpg"/>
        <link rel="canonical" href="https://traxr.net/" />
    @endif
    @hasSection('titles') @yield('titles') @endif
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2197430967008741');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=2197430967008741&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Global site tag (gtag.js) - Google Ads: 619209208 --> <script async src="https://www.googletagmanager.com/gtag/js?id=AW-619209208"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-619209208');
        gtag('config', 'AW-619209208');
    </script>
</head>

<body>

<nav class="nav">
    <div class="container">
        <div class="nav-logo">
            <a href="/" class="nav-logo-link"><img src="/img/traxr-logo-light.svg"></a>
        </div>
        @php
            $page = str_replace('/', '', preg_replace('!(\?.*)!', '', $_SERVER['REQUEST_URI']));
        @endphp
        <div class="nav-menu" {!! $page == 'login' || $page == 'signup' || $page == 'plans' ? 'style="display:none"': '' !!}>
            <a href="/" class="nav-menu-link {!!($page == 'index' || !$page ? 'active': ''); !!}" id="nav-bar-home">Home</a>
            <a href="/features" class="nav-menu-link {!!($page == 'features' ? 'active': ''); !!}" id="nav-bar-features">Features</a>
            <a href="/pricing" class="nav-menu-link {!!($page == 'pricing' ? 'active': ''); !!}" id="nav-bar-pricing">Pricing</a>
            <a href="/contact" class="nav-menu-link {!!($page == 'contact' ? 'active': ''); !!}" id="nav-bar-contact">Contact</a>
            <a href="/about" class="nav-menu-link {!!($page == 'about' ? 'active': ''); !!}" id="nav-bar-about">About</a>
            <a href="/gallery" class="nav-menu-link {!!($page === 'gallery' ? 'active': ''); !!}" id="nav-bar-gallery">Gallery</a>
            <a href="/blog" class="nav-menu-link {!!($page === 'blog' ? 'active': ''); !!}" id="nav-bar-blog">Blog</a>
            <a href="{{ config('app.admin_url') }}/app/" class="nav-menu-link btn-nav">Login</a>
        </div>
        <div class="nav-burger">
            <a href="#" class="nav-burger-link">
                <span class="nav-burger-item "></span>
            </a>
        </div>
    </div>
</nav>
@yield('content')

<footer>
    <div class="container">
        <div class="row align-items-top pad-top-10 pad-bot-2">
            <div class="col-md-3">
                <div class="wrapper align-left">
                    <ul class="footer-list">
                        <li class="text-left fw-700">Info</li>
                        <li><a href="/">Traxr.net</a></li>
                        <li>Mosehøjvej 25B</li>
                        <li>2920 Charlottenlund</li>
                        <li>Denmark</li>
                        <li>CVR: 40388737</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="wrapper align-left">
                    <ul class="footer-list">
                        <li class="text-left fw-700">Legal</li>
                        <li><a href="/privacy">Privacy</a></li>
                        <li><a href="/cookie">Cookie (EU)</a></li>
                        <li><a href="/conditions">Terms and Conditions</a></li>
                        <li><a href="/how_traxr_works">How does Traxr Work?</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="wrapper align-left">
                    <ul class="footer-list">
                        <li class="text-left fw-700">Alternatives</li>
                        <li><a href="/comparison-linkody">To Linkody</a></li>
                        <li><a href="/comparison-linkcheetah">To LinkCheetah</a></li>
                        <li><a href="/comparison-seranking">To SE Ranking</a></li>
                        <li><a href="/comparison-monitorbacklinks">To Monitor Backlinks</a></li>
                        <li><a href="/comparison-linkokay">To LinkOkay</a></li>
                        <li><a href="/complete-comparison">Complete Comparison</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="wrapper align-left">
                    <ul class="footer-list">
                        <li class="text-left fw-700">Contact</li>
                        <li>Inquires towards our sales or support team may be sent to</li>
                        <li><a href="mailto:info@traxr.net">info@traxr.net</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="wrapper">
                    <hr style="border-bottom: 1px solid #bababa; width: 60%;">
                </div>
            </div>

            <div class="col-lg-12">
                <div class="wrapper">
                    <div class="copyright align-center">
                        <p class="color-grey">Copyright © 2021. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Bootstrap core JavaScript -->
<script src="/assets/jquery/jquery.slim.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/jquery-2.1.4.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
<script src="/assets/js/custom.js"></script>
<script src="/assets/js/main.js"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162383577-1"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/cookie-bar/cookiebar-latest.min.js?forceLang=en&tracking=1&thirdparty=1&always=1&privacyPage=https%3A%2F%2Ftraxr.net%2Fprivacy.php"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-162383577-1');

    function removeHeadersOnBreakpoint() {
        const windowWidth = $(window).width()

        const linksIdsToRemove = ['nav-bar-gallery', 'nav-bar-blog', 'nav-bar-contact']
        if (windowWidth <= 990 && windowWidth >= 755 ) {
            for (const link of linksIdsToRemove) {
                $(`#${link}`).css({'display': 'none'})
            }
        }else {
            for (const link of linksIdsToRemove) {
                $(`#${link}`).css({'display': ''})
            }
        }
    }
    removeHeadersOnBreakpoint()
    window.onresize = function() {
        removeHeadersOnBreakpoint()
    }


</script>
</body>
</html>

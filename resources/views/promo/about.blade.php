@extends('promo.layout')
@section('titles')
    <title>Read about the founders of Traxr.net</title>
    <meta name="description" content="This is a short story of the founders behind Traxr.net and why its was developed">
    <meta name="author" content="">
    <meta property="og:title" content="Monitor your Links with 100% accuracy 24/7 - get full value of all your links" />
    <meta property="og:description" content="Use Traxr.net to get full value of your link building efforts. Get full control of all your valuable links" />
    <meta property="og:image" content="img/social/main.jpg"/>
    <link rel="canonical" href="https://traxr.net/about" />
@endsection
@section('content')
    <section class="">
        <div class="container">
            <div class="row align-items-center pad-top-3 pad-bot-1 padding-sm-mob padding-lg-mob-top">
                <img src="/img/shapes/left-light-blue.svg" alt="" title="" class="home-shape-left">
                <div class="col-md-12">
                    <div class="text-content">
                        <img src="/img/shapes/right-small-blue.svg" alt="" title="" class="home-shape-right">
                        <h1 class="pt-2 align-center">About Traxr</h1>
                        <p class="pt-2 align-center text-md-light text-cen-wid-70">
                            <span class="fw-700">The true story of Traxr.net</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row align-items-center pad-top-3 pad-bot-1 padding-lg-mob">
                <div class="col-md-12">
                    Lennart Øster and Tim Petersson started Traxr in 2019, after years of working with link building on their own and customers sites.<br />
                    One of the recurring problems was links being changed after they where published. Some where removed and others changed from dofollow to nofollow or sites where closed, redirected or any other number of issues.<br /><br />
                    To be able to be proactive they developed Traxr.net, with one goal in mind.<br /><br />
                    <i>It must be super easy and intuitive to monitor links and react on any events.</i> <br />
                    <br />
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row align-items-center pad-top-3 pad-bot-1 padding-lg-mob">
                <div class="col-md-6 padding-sm-mob">
                    <div class="features-box pad-10">
                        <div class="text-content">
                            <center><img src="/img/profile-lennart.png" title="Founder of Traxr" style="width:50%">
                                <h3 class="pt-2 align-center">Lennart Øster<br />Founder</h3>
                            </center>
                            <p class="pt-3 align-left ">
                                Lennart has worked with SEO and Link building for more than 10 years.<br /><br />
                                Expert in Search Engine Optimization and Affiliate Marketing<br /><br />
                                20 Years experience with programming and Project management
                            </p>
                            <div class="features-bottom-text-wrapper">
                                <div class="list-icon"></div>
                                <p class="pt-3 align-left fw-700 features-bottom-text">
                                    Mail: lennart@traxr.net<br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 padding-sm-mob">
                    <div class="features-box pad-10">
                        <div class="text-content">
                            <center><img src="/img/profile-tim.png" title="Founder of Traxr" style="width:50%">
                                <h3 class="pt-2 align-center">Tim Peterssen<br />Co-Founder</h3>
                            </center>
                            <p class="pt-3 align-left ">
                                Tim has 10 years of experience with Affiliate Marketing and Search Engine optimization<br /><br />
                                Expert in programming and database management as well as complex problem solving<br /><br />
                                The main developer of Traxr
                            </p>
                            <div class="features-bottom-text-wrapper">
                                <div class="list-icon"></div>
                                <p class="pt-3 align-left fw-700 features-bottom-text">
                                    Mail: tim@traxr.net<br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('promo.testimonials');
@endsection

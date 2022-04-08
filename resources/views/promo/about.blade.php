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
                <img src="img/shapes/left-light-blue.svg" alt="" title="" class="home-shape-left">
                <div class="col-md-12">
                    <div class="text-content">
                        <img src="img/shapes/right-small-blue.svg" alt="" title="" class="home-shape-right">
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
                    Traxr is a backlink CRM system created by Jimmi Meilstrup and Kristoffer Tølbøll. The inspiration for creating the system was the idea of many companies managing their backlinks in Large Excel Spreadsheets and other documents without having the ability to manage their backlinks in a user-friendly and dynamic fashion.
                    <br /><br />
                    Traxr aims to solve this issue with state-of-the-art technology that allows you to see your KPIs and have analytical insight into how their backlinks are performing over time.
                    <br /><br />
                    We are constantly aiming to improve Traxr and become an industry-leading tool in the SEO and backlinking industry.
                    <br /><br />
                    Feedback and inquires should be sent to <a href="mailto:info@traxr.net">info@traxr.net</a><br />
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
                            <center>
                                <img src="img/face1.png" title="Founder of Traxr" style="width:216px">
                                <h3 class="pt-2 align-center">Jimmi Meilstrup<br />CEO</h3>
                            </center>
                            <p class="pt-3 align-left ">
                                Jimmi is an entrepreneur by heart and has always had a passion for generating ideas, developing concepts, and eventually implementing them; this is how Traxr was born.
                                <br /><br />
                                Jimmi is devoted to delivering value to the customer. His experience in the affiliate and SEO industry provides a unique perspective to make Traxr one of the industries leading CRM platforms for backlinking. Jimmi has been involved in 9 start-ups and has completed four successful exits.
                                <br /><br />
                                Jimmi's core competencies are his creativity and his orientation toward solutions.
                            </p>
                            <div class="features-bottom-text-wrapper">
                                <div class="list-icon"></div>
                                <p class="pt-3 align-left fw-700 features-bottom-text">
                                    <a href="https://www.linkedin.com/in/jimmimeilstrup/">https://www.linkedin.com/in/jimmimeilstrup/</a><br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 padding-sm-mob">
                    <div class="features-box pad-10">
                        <div class="text-content">
                            <center><img src="img/face2.jpg" title="Founder of Traxr" style="height: 216px">
                                <h3 class="pt-2 align-center">Kristoffer Tølbøll<br />Tech Lead</h3>
                            </center>
                            <p class="pt-3 align-left ">
                                Kristoffer is the tech lead of Traxr and manages the development process, and delivers value to the end customer.
                                <br /><br />
                                He has over 5+ years of software engineering experience. He has worked in a diverse array of industries, and he has a passion for being between the technical and the commercial side of the business.
                                <br /><br />
                                Kristoffer's core competencies are his ability to think outside the box and apply his technical knowledge to solve business problems.
                            </p>
                            <div class="features-bottom-text-wrapper">
                                <div class="list-icon"></div>
                                <p class="pt-3 align-left fw-700 features-bottom-text">
                                    Mail: kristofferlocktolboll@gmail.com<br />
                                    <a href="https://kristoffer.dk/">https://kristoffer.dk/</a>
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

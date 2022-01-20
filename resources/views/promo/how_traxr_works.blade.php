@extends('promo.layout')
@section('titles')
    <title>>How does Traxr Work</title>
    <meta name="description" content="Read our Terms and conditions for using the Traxr software.">
    <meta name="author" content="">
    <meta property="og:title" content="Monitor your Links with 100% accuracy 24/7 - get full value of all your links" />
    <meta property="og:description" content="Use Traxr.net to get full value of your link building efforts. Get full control of all your valuable links" />
    <meta property="og:image" content="img/social/main.jpg"/>
    <link rel="canonical" href="https://traxr.net/how_traxr_works" />
@endsection
@section('content')
    <section class="">
        <div class="container">
            <div class="row align-items-center pad-top-3 pad-bot-1 padding-sm-mob padding-lg-mob-top">
                <img src="img/shapes/left-light-blue.svg" alt="" title="" class="home-shape-left">
                <div class="col-md-12">
                    <div class="text-content">
                        <img src="img/shapes/right-small-blue.svg" alt="" title="" class="home-shape-right">
                        <h1 class="pt-2 align-center">How does Traxr Work?</h1>
                        <p class="pt-2 align-center text-md-light text-cen-wid-70">
                                <span class="fw-700">Traxr is a very simple system, seen with external eyes. We visit webpages to verify that a link is present on the webpage.
    We only visit webpages users has entered the Traxr system. We never visit a page a user has not entered the system.
    If multiple users enter the same URL, we only visit it once, to make sure we use as little resources as possible in both our own, but also the visited webservers.</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="row align-items-center pad-top-3 pad-bot-1 padding-lg-mob">
                <div class="col-md-12">
                    <strong>No scraping is ever done</strong><br />
                    Traxr does NOT scrape a website for any information. We do not store any content besides the links anchor text and identifiers.<br />
                    We only read the URL that the user has given us to check. We do not follow internal links. This means that if we only have 1 URL from a specific website, we will visit that page once every 24 hours to verify that the links are still present.<br />
                    Websites that publish many links, like news medias or sites selling many links, we will visit once per URL<br />
                    <br />
                    <strong>Traxr is a link management tool</strong><br />
                    Traxr is an advanced link management system to monitor your links and their value.<br />
                    <br />
                    <strong>The Traxr Bot</strong><br />
                    A site will be visited by our bot, which identifies as Traxr Bot. We do this because we have nothing to hide. We do not scrape, but only reads a small piece of a site to determine if a user’s links are still present.<br />
                </div>
            </div>
        </div>
    </section>

@endsection

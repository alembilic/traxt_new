@extends('promo.layout')
@section('titles')
    <title>If you wish to contact Traxr, please use our form or send an email</title>
    <meta name="description" content="If you wish to contact Traxr, please use our form or send an email">
    <meta name="author" content="">
    <meta property="og:title" content="Monitor your Links with 100% accuracy 24/7 - get full value of all your links" />
    <meta property="og:description" content="Use Traxr.net to get full value of your link building efforts. Get full control of all your valuable links" />
    <meta property="og:image" content="img/social/main.jpg"/>
    <link rel="canonical" href="https://traxr.net/contact" />
@endsection
@section('content')

    <section class="contact-section">
        <div class="container">
            <div class="row align-items-top pad-top-6 pad-bot-8">
                <div class="col-md-6 pad-3 padding-lg-mob-top padding-lg-mob">
                    <div class="text-content color-white">
                        <h1 class="align-left">Contact info</h1>
                        <p class="pt-3 align-left text-md text-lef-wid-70">
                            You can contact sales using this email form or using the contact information from the footer below</p>
                        <ul class="contact-list">
                            <li>Mosehøjvej 25B</li>
                            <li>2920 Charlottenlund</li>
                            <li>Denmark</li>
                            <li>CVR: 40388737</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 pad-3 padding-lg-mob bc-light-grey padding-lg-mob padding-lg-mob-top">
                    @if (addslashes($_GET['success']))
                    <div style="color: green">You message has been sent</div>
                    @endif
                    @if (addslashes($_GET['failed']))
                    <div style="color: red">Ups, something went wrong, try sales@traxr.net</div>
                    @endif
                    <h1 class="title align-left">Get in touch</h1>
                    <form class="contact-form" action="/sendmail" method="post">
                        <div class="form-field">
                            <input id="name" name="name" class="input-text js-input" type="text" required>
                            <label class="label" for="name">Your name</label>
                        </div>
                        <div class="form-field">
                            <input id="email" name="email" class="input-text js-input" type="email" required>
                            <label class="label" for="email">Your Email</label>
                        </div>
                        <div class="form-field">
                            <textarea id="message" class="input-text js-input" type="text" required name="message"></textarea>
                            <label class="label" for="message">Your Message</label>
                        </div>
                        <div class="form-field align-cleft">
                            <input class="submit-btn" type="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('promo.testimonials');
@endsection

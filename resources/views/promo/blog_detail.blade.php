@extends('promo.layout')
@section('titles')
    <title>Read about the founders of Traxr.net</title>
    <meta name="description" content="This is a short story of the founders behind Traxr.net and why its was developed">
    <meta name="author" content="">
    <meta property="og:title" content="Monitor your Links with 100% accuracy 24/7 - get full value of all your links" />
    <meta property="og:description" content="Use Traxr.net to get full value of your link building efforts. Get full control of all your valuable links" />
    <meta property="og:image" content="img/social/main.jpg"/>
@endsection
@php
/* @var \App\Entities\BlogPost $post */
@endphp
@section('content')
<section class="">
    <div class="container">
        <div class="row align-items-center pad-top-3 pad-bot-1 padding-sm-mob padding-lg-mob-top">
            <div class=col-md-12>
                <img src="/img/blog/blog_shape.svg" alt="" title="" class="blog-details-shape-left">
                <p class="font-weight-bold text-primary text-center">Published {{ $post->getCreatedAt()->format('M j, Y') }}</p>
                <h1 class="">{{ $post->getTitle() }}</h1>
            </div>
        </div>
        <div class="row align-items-center pad-top-3 pad-bot-1 padding-sm-mob padding-lg-mob-top">
            <div class=col-md-12>
                <div class="img-wrap">
                    <img src="/img/blog/{{ $post->getImage() }}" alt="" title="" class="w-100">
                </div>
            </div>
        </div>        
        <div class="row pad-top-3 pad-bot-1 padding-lg-mob">
            <div class="col-md-4 align-top">
                <h3 class="text-primary text-left">
                    Summary
                </h3>
                <p>
                    {{ $post->getShortContent() }}
                </p>
            </div>
            <div class="col-md-8">
                {{ $post->getFullContent() }}

                <p><a class="btn-custom bc-btn-primary" href="#">Share</a></p>
            </div>
        </div>
    </div>
</section>
@endsection


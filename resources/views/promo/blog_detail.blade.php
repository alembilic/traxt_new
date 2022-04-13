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
        <div class="">
            <h2 class="">{{ $post->getTitle() }}</h2>
            <p class="">{{ $post->getCreatedAt()->format('M j, Y') }}</p>

            <p>
                {!! $post->getFullContent() !!}
            </p>
        </div>
    </div>
</section>
@endsection

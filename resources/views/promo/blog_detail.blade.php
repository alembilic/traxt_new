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
    Post title: {{ $post->getTitle() }}<br />
    Date: {{ $post->getCreatedAt()->format('M j, Y') }}<br />
    Short Content: {!! $post->getShortContent() !!}<br />
    Full Content: {!! $post->getFullContent() !!}<br />
@endsection

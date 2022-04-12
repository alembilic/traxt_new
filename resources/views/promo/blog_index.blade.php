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
/* @var \App\Entities\BlogPost $mainPost */
@endphp
@section('content')
    @if ($mainPost)
        Main Post title: {{ $post->getTitle() }}<br />
        Main Post Date: {{ $post->getCreatedAt()->format('M j, Y') }}<br />
        Main Post Short Content: {!! $post->getShortContent() !!}<br />
        Main Post Full Content: {!! $post->getFullContent() !!}<br />
        Read More: /blog/{{ $post->getUrlCode() }}<br />
    @endif
<br>
    @foreach($posts as $post)

        Post title: {{ $post->getTitle() }}<br />
        Date: {{ $post->getCreatedAt()->format('M j, Y') }}<br />
        Short Content: {!! $post->getShortContent() !!}<br />
        Read More: /blog/{{ $post->getUrlCode() }}<br />
    @endforeach
@endsection

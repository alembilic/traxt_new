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
/* @var \App\Entities\BlogPost $posts */
/* @var \App\Entities\BlogPost $mainPost */
@endphp
@section('content')

<section class="">
  <div class="container">
    @if ($mainPost)
      <div class="row align-items-center pad-top-6 pad-bot-6 reverse-col-mob padding-lg-mob">
        <div class="col-md-6">
          <div class="text-content">
            <p class="font-weight-bold text-primary">{{ $mainPost->getCreatedAt()->format('M j, Y') }}</p>
            <h1 class="text-left">{{ $mainPost->getTitle() }}</h1>
            <p>
              {!! $mainPost->getShortContent() !!}
            </p>
          </div>
          <a class="btn-custom bc-btn-primary" href="/blog/{{ $mainPost->getUrlCode() }}">Read more</a>
        </div>
        <div class="col-md-6 image-element padding-sm-mob">
          <img src="/img/blog/blog_shape.svg" alt="" title="" class="blog-shape-right">
          <div class="img-wrap">
            <img src="/img/blog/blog_jumbotron.svg" alt="" title="" class="w-100">
          </div>
        </div>
      </div>
    @endif
    
    <div class="card-deck">
    @foreach($posts as $post)
      <div class="col-md-4 mb-4">
        <div class="card border-0">
          <img class="card-img-top w-100" src="/img/blog/blog_post.svg" alt="blogpost" title="image-{{ $post->getTitle() }}">
          <div class="card-body">
            <p class="font-weight-bold text-primary">{{ $post->getCreatedAt()->format('M j, Y') }}</p>
            <h3 class="card-title text-left">{{ $post->getTitle() }}</h5>
            <p class="card-text">{{ $post->getShortContent() }}</p>
            <p>
              <a href="/blog/{{ $post->getUrlCode() }}">Read more</a>
            </p>
          </div>
        </div>
      </div>
    @endforeach
    </div>
  </div>
</section>

@endsection

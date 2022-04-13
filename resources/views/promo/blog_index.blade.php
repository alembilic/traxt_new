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
        <div class="jumbotron p-3 p-md-5 rounded">
            <div class="col-md-6 px-0">
            <h1 class="display-4 font-italic">{{ $mainPost->getTitle() }}</h1>
            <p class="lead my-3">{!! $mainPost->getShortContent() !!}</p>
            <p class="lead mb-0"><a href="/blog/{{ $mainPost->getUrlCode() }}" class="font-weight-bold">Continue reading...</a></p>
            </div>
        </div>
    @endif

    <div class="row mb-2">
        @foreach($posts as $post)
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <!--strong class="d-inline-block mb-2 text-primary">World</strong>-->
              <h3 class="mb-0">
                <a class="text-dark" href="/blog/{{ $post->getUrlCode() }}">{{ $post->getTitle() }}</a>
              </h3>
              <div class="mb-1 text-muted">{{ $post->getCreatedAt()->format('M j, Y') }}</div>
              <p class="card-text mb-auto">{!! $post->getShortContent() !!}</p>
              <a href="/blog/{{ $post->getUrlCode() }}">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18021f42a35%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18021f42a35%22%3E%3Crect%20width%3D%22200%22%20height%3D%22250%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2256.20000076293945%22%20y%3D%22131%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
          </div>
        </div>
        @endforeach

    </div>

    </div>
</section>
    
@endsection



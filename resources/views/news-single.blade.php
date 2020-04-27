@extends('layout')

@section('meta_title', $article->meta_title ?? $article->title)

@section('meta_description', $article->meta_description ?? $article->title)

@section('head')

@endsection

@section('content')

<!-- Titlebar -->
<div id="titlebar" class="margin-bottom-50">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <h2>{{ $page->title }}</h2>

        <!-- Breadcrumbs -->
        <nav id="breadcrumbs">
          <ul>
            <li><a href="/{{ $lang }}">{{ __('Main') }}</a></li>
            @if ($page->ancestors->count())
              <li><a href="/{{ $lang }}/i/{{ $page->parent->slug }}">{{ $page->parent->title }}</a></li>
            @endif
            <li><a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a></li>
            <li>{{ $article->title }}</li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Content -->
<div class="container">

  @include('partials.notifications')

  <!-- Blog Posts -->
  <div class="blog-page">
  <div class="row">


    <!-- Post Content -->
    <div class="col-md-8">


      <!-- Blog Post -->
      <div class="blog-post single-post">

        <!-- Img -->
        <img class="post-img" src="images/blog-post-02a.jpg" alt="">


        <!-- Content -->
        <div class="post-content">
          <h3>{{ $article->title }}</h3>

          <ul class="post-meta">
            <li>{{ $article->getDateAttribute() }}</li>
            <!-- <li><a href="#">5 Comments</a></li> -->
          </ul>

          {!! $article->content !!}

          <div class="clearfix"></div>
        </div>
      </div>


      <div class="margin-top-50"></div>


  </div>


  <!-- Widgets -->
  <div class="col-md-4">
    <div class="sidebar right">

      <!-- Widget -->
      <div class="widget">
        <div class="agent-widget">
          <form action="/{{ $lang }}/send-app" name="contact" method="post">
            @csrf
            <h3>{{ __('App form') }}</h3>
            <input type="email" name="email" id="email" placeholder="{{ __('Your Email') }}" required>
            <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
            <textarea name="message" autocomplete="off" required>{{ __('Your Message') }}</textarea>
            <button class="button fullwidth margin-top-5">{{ __('Send Message') }}</button>
          </form>
        </div>
      </div>

      <!-- Widget -->
      <div class="widget">
        <h3 class="margin-top-0 margin-bottom-25">Social</h3>
        <ul class="social-icons rounded">
          <li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
          <li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
          <li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
          <li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
        </ul>

      </div>

      <div class="clearfix"></div>
      <div class="margin-bottom-40"></div>
    </div>
  </div>
  </div>


  </div>
</div>

@endsection

@section('scripts')

@endsection
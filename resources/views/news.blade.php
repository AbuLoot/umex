@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

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
            <li>{{ $page->title }}</li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>


<!-- Content -->
<div class="container margin-bottom-50">

  @include('partials.notifications')

  <!-- Blog Posts -->
  <div class="blog-page">
    <div class="row">
      <div class="col-md-8">

        @foreach ($articles as $article)
          <div class="blog-post">
            <div class="post-content">
              <h3><a href="/{{ $lang }}/news/{{ $article->slug }}">{{ $article->title }}</a></h3>
              <ul class="post-meta">
                <li>{{ $article->getDateAttribute() }}</li>
                <!-- <li><a href="#">5 Comments</a></li> -->
              </ul>
              {!! Str::limit($article->content, 260) !!}
              <a href="/{{ $lang }}/news/{{ $article->slug }}" class="read-more">{{ __('Read More') }} <i class="fa fa-angle-right"></i></a>
            </div>
          </div>
        @endforeach

        <!-- Pagination -->
        <div class="clearfix"></div>
        <div class="pagination-container">
          {{ $articles->links() }}
        </div>
        <div class="clearfix"></div>

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
              <input type="tel" -pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="1" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
              <textarea name="message" autocomplete="off" required>{{ __('Your Message') }}</textarea>
              <button class="button fullwidth margin-top-5">{{ __('Send Message') }}</button>
            </form>
          </div>
        </div>

        <!-- Widget -->
        <!-- <div class="widget">
          <h3 class="margin-top-0 margin-bottom-25">Search Blog</h3>
          <div class="search-blog-input">
            <div class="input"><input class="search-field" type="text" placeholder="Type and hit enter" value=""/></div>
          </div>
          <div class="clearfix"></div>
        </div> -->


        <!-- Widget -->
        <!-- <div class="widget">
          <h3>Got any questions?</h3>
          <div class="info-box margin-bottom-10">
            <p>If you are having any questions, please feel free to ask.</p>
            <a href="contact.html" class="button fullwidth margin-top-20"><i class="fa fa-envelope-o"></i> Drop Us a Line</a>
          </div>
        </div> -->

        <!-- Widget -->
        <div class="widget">
          <h3 class="margin-top-0 margin-bottom-25">Social</h3>
          <ul class="social-icons rounded">
            <li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
            <li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
            <li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
          </ul>

        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

@endsection
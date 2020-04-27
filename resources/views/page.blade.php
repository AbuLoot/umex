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

    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        {!! $page->content !!}
      </div>
    </div>

  </div>

@endsection

@section('scripts')

@endsection

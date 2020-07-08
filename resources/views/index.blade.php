@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

@section('head')

@endsection

@section('content')

    @if($slide_items->isNotEmpty())
      <!-- Slider -->
      <div class="fullwidth-home-slider margin-bottom-40">
        @foreach($slide_items as $key => $slide_item)
          <div data-background-image="/img/slide/{{ $slide_item->image }}" class="item">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="home-slider-container">

                    <!-- Slide Title -->
                    <div class="home-slider-desc">
                      <div class="home-slider-price">{{ $slide_item->marketing }}</div>
                      <div class="home-slider-title">
                        <h3><a href="/{{ $slide_item->link }}">{{ $slide_item->title }}</a></h3>
                      </div>
                      <a href="/{{ $slide_item->link }}" class="button border read-more">{{ __('Details') }} <i class="fa fa-angle-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <!-- Titlebar -->
      <div class="parallax titlebar margin-bottom-40"
        data-background="/img/bg-1-1500.jpg"
        data-color="#333333"
        data-color-opacity="0"
        data-img-width="800"
        data-img-height="505">

        <div id="titlebar">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <?php $tagline = $section->firstWhere('slug', 'tagline'); ?>
                {!! $tagline->content !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Properties -->
    <section class="container padding-bottom-50">
      <div class="row">

        <div class="col-md-12">
          <h2 class="headline centered margin-bottom-35">{{ __('Offer') }}</h2>
        </div>

        <?php $i = 1; $mode_titles = unserialize($mode_recommended->title); ?>
        @foreach($mode_recommended->products->take(6) as $product)
          <?php $product_lang = $product->products_lang->where('lang', $lang)->first(); ?>
          @if ($product_lang != null)
            <div class="col-sm-6 col-md-4">
              <div class="listing-item">
                <a href="/{{ $lang }}/p/{{ $product_lang->slug }}" class="listing-img-container">
                  <div class="listing-badges">
                    <span class="featured">{{ $mode_titles[$lang]['title'] }}</span>
                    <span>{{ trans('statuses.condition.'.$product->condition) }}</span>
                  </div>
                  <div class="listing-img-content">
                    <span class="listing-price">{{ $product_lang->price_total }}₸</span>
                    <!-- <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span> -->
                  </div>
                  <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product_lang->title }}">
                </a>

                <div class="listing-content">
                  <div class="listing-title">
                    <h4><a href="/{{ $lang }}/p/{{ $product_lang->slug }}">{{ $product_lang->title }}</a></h4>
                    <a href="#" class="listing-address popup-gmaps">
                      <i class="fa fa-map-marker"></i> {{ $product_lang->characteristic }}
                    </a>
                  </div>
                  <ul class="listing-features">
                    @foreach ($product->options as $option)
                      <?php $data = unserialize($option->data); ?>
                      @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                        <?php $titles = unserialize($option->title); ?>
                        <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
                      @endif
                    @endforeach
                  </ul>
                  <div class="listing-footer">
                    <a href="#"><i class="fa fa-bank"></i> {{ $product->company->title }}</a>
                  </div>
                </div>
              </div>
            </div>
          @endif
          <?php if ($i++ == 3) : $i = 1; ?>
            <div class="clearfix"></div>
          <?php endif; ?>
        @endforeach

        <div class="col-sm-12 col-md-12 text-center">
          <a href="/{{ $lang }}/i/{{ $pages->firstWhere('slug', 'catalog')->slug }}" class="button">{{ $pages->firstWhere('slug', 'catalog')->title }}</a>
        </div>

      </div>
    </section>

    <!-- For Traveler  -->
    <section class="parallax margin-bottom-70"
      data-background="/img/nur-sultan.jpg"
      data-color="#36383e"
      data-color-opacity="0.5"
      data-img-width="800"
      data-img-height="505">

      <!-- Infobox -->
      <div class="text-content white-font">
        <div class="container">

          <div class="row">
            <div class="col-lg-8 col-sm-8">
              <?php $сlients = $section->firstWhere('slug', 'сlients'); ?>
              <h2>{{ $сlients->title }}</h2>
              {!! $сlients->content !!}
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Advantages Section -->
    <?php $advantages = $section->firstWhere('slug', 'advantages'); ?>
    @if ($advantages != NULL)
      {!! $advantages->content !!}
    @endif

    <!-- Fullwidth Section -->
    <section class="fullwidth margin-top-95 margin-bottom-0">

      <!-- Box Headline -->
      <h3 class="headline-box">{{ $pages->firstWhere('slug', 'news')->title }}</h3>

      <div class="container">
        <div class="row">
          @foreach ($articles as $article)
            <div class="col-sm-6 col-md-4">
              <div class="blog-post">
                <div class="post-content">
                  <h3><a href="/{{ $lang }}/news/{{ $article->slug }}">{{ $article->title }}</a></h3>
                  {!! Str::limit($article->content, 130) !!}
                  <a href="/{{ $lang }}/news/{{ $article->slug }}" class="read-more">{{ __('Read More') }} <i class="fa fa-angle-right"></i></a>
                </div>
              </div>
            </div>
          @endforeach
          <div class="col-md-12 text-center margin-top-25">
            <a href="/{{ $lang }}/i/{{ $pages->firstWhere('slug', 'news')->slug }}" class="button border">{{ $pages->firstWhere('slug', 'news')->title }}</a>
          </div>
        </div>
      </div>
    </section>

@endsection

@section('scripts')

@endsection
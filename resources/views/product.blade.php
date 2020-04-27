@extends('layout')

@section('meta_title', $product_lang->meta_title ?? $product_lang->title)

@section('meta_description', $product_lang->meta_description ?? $product_lang->title)

@section('head')

@endsection

@section('content')

<!-- Titlebar -->
<div id="titlebar" class="property-titlebar margin-bottom-0">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <a href="{{ url()->previous() }}" class="back-to-listings"></a>

        <div class="property-title">
          <h2>{{ $product_lang->title }} <span class="property-badge">{{ trans('statuses.condition.'.$product_lang->product->condition) }}</span></h2>
          <span>
            <a href="#location" class="listing-address">
              <i class="fa fa-map-marker"></i> {{ $product_lang->characteristic }}
            </a>
          </span>
        </div>

        <div class="property-pricing">
          <div class="property-price">{{ $product_lang->price_total }}₸</div>
          <div class="sub-price">{{ $product_lang->price }}₸</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content -->
<div class="container">

  @include('partials.notifications')

  <div class="row margin-bottom-50">
    <div class="col-md-12">
    
      <!-- Slider -->
      <div class="property-slider default">
        @if ($product_lang->product->images != '')
          <?php $images = unserialize($product_lang->product->images); ?>
          @foreach ($images as $k => $image)
            <a href="/img/products/{{ $product_lang->product->path.'/'.$images[$k]['image'] }}" data-background-image="/img/products/{{ $product_lang->product->path.'/'.$images[$k]['image'] }}" class="item mfp-gallery"></a>
          @endforeach
        @else
          <a href="/images/single-property-02.jpg" data-background-image="images/single-property-02.jpg" class="item mfp-gallery"></a>
        @endif
      </div>

      <!-- Slider Thumbs -->
      <div class="property-slider-nav">
        @if ($product_lang->product->images != '')
          @foreach ($images as $k => $image)
            <div class="item"><img src="/img/products/{{ $product_lang->product->path.'/'.$images[$k]['present_image'] }}" alt="{{ $product_lang->title }}"></div>
          @endforeach
        @else
          <div class="item"><img src="/images/single-property-02.jpg" alt=""></div>
        @endif
      </div>

    </div>
  </div>
</div>


<div class="container margin-bottom-50">
  <div class="row">

    <!-- Property Description -->
    <div class="col-lg-8 col-md-7 sp-content">
      <div class="property-description">

        <!-- Main Features -->
        <ul class="property-main-features">
          @foreach ($product_lang->product->options as $option)
            <?php $data = unserialize($option->data); ?>
            @unless (in_array($data[$lang]['data'], ['Год постройки', 'Year of construction']))
              <?php $titles = unserialize($option->title); ?>
              <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
            @endunless
          @endforeach
        </ul>

        <!-- Details -->
        <h3 class="desc-headline">{{ __('Details') }}</h3>
        <ul class="property-features margin-top-0 padding-h-30">
          <li>{{ __('Number of Object') }}: <span>{{ $product_lang->product->barcode }}</span></li>
          <li>{{ __('Region') }}: <span>@foreach ($product_lang->product->categories->where('lang', $lang) as $category) {{ $category->title }} @endforeach</span></li>
          <li>{{ __('Company') }}:<br> <span>{{ $product_lang->product->company->title }}</span></li>
          <li>{{ __('Area Total') }}: <span>{{ $product_lang->product->capacity }}</span></li>
          <li>{{ __('Area') }}: <span>{{ $product_lang->product->area }}</span></li>
        </ul>

        <!-- Description -->
        @if ($product_lang->description != NULL)
          <h3 class="desc-headline">{{ __('Description') }}</h3>
          <div class="show-more">
            {!! $product_lang->description !!}
            <a href="#" class="show-more-button">{{ __('Show More') }} <i class="fa fa-angle-down"></i></a>
          </div>
        @endif

        <!-- Similar Listings Container -->
        @if ($products->isNotEmpty())
          <h3 class="desc-headline no-border margin-bottom-35 margin-top-60">{{ __('Similar Properties') }}</h3>
          <div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
          <div class="listings-container list-layout">

            <!-- Listing Item -->
            @foreach($products as $product_similar)
              <div class="listing-item">
                <a href="/{{ $lang }}/p/{{ $product_similar->slug }}" class="listing-img-container">
                  <div class="listing-badges">
                    <span>{{ trans('statuses.condition.'.$product_similar->product->condition) }}</span>
                  </div>
                  <div class="listing-img-content">
                    <span class="listing-price">{{ $product_similar->price }}{{ $currency->symbol }}</span>
                    <span class="like-icon"></span>
                  </div>
                  <img src="/img/products/{{ $product_similar->product->path.'/'.$product_similar->product->image }}" alt="{{ $product_similar->title }}">
                </a>
                <div class="listing-content">
                  <div class="listing-title">
                    <h4><a href="/{{ $lang }}/p/{{ $product_similar->slug }}">{{ $product_similar->title }}</a></h4>
                    <i class="fa fa-map-marker"></i> {{ $product_lang->characteristic }}
                    <a href="/{{ $lang }}/p/{{ $product_similar->slug }}" class="details button border">{{ __('Details') }}</a>
                  </div>

                  <ul class="listing-details">
                    @foreach ($product_similar->product->options as $option)
                      <?php $data = unserialize($option->data); ?>
                      @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms']))
                        <?php $titles = unserialize($option->title); ?>
                        <li>{{ $data[$lang]['data'] }}: <span>{{ $titles[$lang]['title'] }}</span></li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              </div>
            @endforeach
          </div>
        @endif

      </div>
    </div>


    <!-- Sidebar -->
    <div class="col-lg-4 col-md-5 sp-sidebar">
      <div class="sidebar sticky right">

        <!-- Widget -->
        <div class="widget">
          <div class="agent-widget">
            <form action="/{{ $lang }}/send-app" name="contact" method="post">
              @csrf
              <h3>{{ __('Booking form') }}</h3>
              <input type="email" name="email" id="email" placeholder="{{ __('Your Email') }}" required>
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
              <textarea name="message" autocomplete="off" required>{{ __('Text form') }} {{ $product_lang->product->barcode }}]</textarea>
              <button class="button fullwidth margin-top-5">{{ __('Send Message') }}</button>
            </form>
          </div>
        </div>

        <!-- Widget -->
        <div class="widget margin-bottom-30">
          <button class="widget-button with-tip" data-tip-content="Print"><i class="sl sl-icon-printer"></i></button>
          <button class="widget-button with-tip" data-tip-content="Add to Bookmarks"><i class="fa fa-star-o"></i></button>
          <div class="clearfix"></div>
        </div>

      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')

@endsection
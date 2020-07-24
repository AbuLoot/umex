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
          <div class="property-price">{{ number_format($product_lang->price_total, 0, ' ', ' ') }}₸</div>
          @if($product_lang->price > 0)
            <div class="sub-price">{{ number_format($product_lang->price, 0, ' ', ' ') }}₸</div>
          @endif
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
        </ul><br>

        <!-- Details -->
        <h3 class="desc-headline- margin-bottom-30">{{ __('Details') }}</h3>
        <table class="table table-striped">
          <tbody>
            <tr>
              <th scope="row">{{ __('Number of Object') }}: </th>
              <td><span>{{ $product_lang->product->barcode }}</span></td>
            </tr>
            <tr>
              <th scope="row">{{ __('Region') }}: </th>
              <td><span>@foreach ($product_lang->product->categories->where('lang', $lang) as $category) {{ $category->title }} @endforeach</span></td>
            </tr>
            @unless($product_lang->product->company->slug == 'no-name')
            <tr>
              <th scope="row">{{ __('Company') }}:</th>
              <td> <span>{{ $product_lang->product->company->title }}</span></td>
            </tr>
            @endunless
            @if(!empty($product_lang->product->capacity))
              <tr>
                <th scope="row">{{ __('Area Total') }}: </th>
                <td><span>{{ $product_lang->product->capacity }}</span></td>
              </tr>
            @endif
            <tr>
              <th scope="row">{{ __('Area') }}:</th>
              <td><span>{{ $product_lang->product->area }}</span></td>
            </tr>
          </tbody>
        </table>

        <!-- Description -->
        @if ($product_lang->description != NULL)
          <h3 class="desc-headline">{{ __('Description') }}</h3>

          {!! $product_lang->description !!}
          <!-- <div class="show-more">
            <a href="#" class="show-more-button">{{ __('Show More') }} <i class="fa fa-angle-down"></i></a>
          </div> -->
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
              <input type="name" name="name" id="name" placeholder="{{ __('Your Name') }}" required>
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
@extends('layout')

@section('meta_title', $category->meta_title ?? $category->title)

@section('meta_description', $category->meta_description ?? $category->title)

@section('head')

@endsection

@section('content')

<!-- Titlebar -->
<div class="parallax titlebar margin-bottom-50"
  data-background="/file-manager/{{ $category->image }}"
  data-color="#333333"
  data-color-opacity="0.7"
  data-img-width="800"
  data-img-height="505">

  <div id="titlebar">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <h2>{{ $category->title }}</h2>
          <span>{{ __('Properties').': '.$category->products->count() }}</span>
          
          <!-- Breadcrumbs -->
          <nav id="breadcrumbs">
            <ul>
              <li><a href="/{{ $lang }}">{{ __('Main') }}</a></li>
              @if ($category->ancestors->count())
                <li><a href="/{{ $lang }}/i/{{ $category->parent->slug }}">{{ $category->parent->title }}</a></li>
              @endif
              <li>{{ $category->title }}</li>
            </ul>
          </nav>

        </div>
      </div>
    </div>
  </div>
</div>


<!-- Content -->
<div class="container margin-bottom-50">
  <div class="row sticky-wrapper">

    <div class="col-md-8">

      <!-- Sorting / Layout Switcher -->
      <!-- <div class="row margin-bottom-15">

        <div class="col-md-6">
          <div class="sort-by">
            <label>{{ __('Sort by') }}:</label>

            <div class="sort-by-select">
              <select data-placeholder="Default order" class="chosen-select-no-single" id="actions">
                @foreach(trans('data.sort_by') as $key => $value)
                  <option value="{{ $key }}" @if($key == session('action')) selected @endif>{{ $value }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div> -->

      <!-- Similar Listings Container -->
      @if ($products->isNotEmpty())
        <div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
        <div class="listings-container list-layout">

          <!-- Listing Item -->
          @foreach($products as $product)
          <?php dd($product); ?>
            <?php $product_lang = $product->products_lang->firstWhere('lang', $lang); ?>
            <div class="listing-item">
              <a href="/{{ $lang }}/p/{{ $product->slug }}" class="listing-img-container">
                <div class="listing-badges">
                  <span>{{ trans('statuses.condition.'.$product->condition) }}</span>
                </div>
                <div class="listing-img-content">
                  <span class="listing-price">{{ $product_lang['price'] }}₸</span>
                  <span class="like-icon"></span>
                </div>
                <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product_lang['title'] }}">
              </a>
              <div class="listing-content">
                <div class="listing-title">
                  <h4><a href="/{{ $lang }}/p/{{ $product_lang['slug'] }}">{{ $product_lang['title'] }}</a></h4>
                  <i class="fa fa-map-marker"></i>
                  @foreach ($product_lang->product->categories->where('lang', $lang) as $category)
                    {{ $category->title }},
                  @endforeach
                  {{ $product_lang['characteristic'] }}
                  <a href="/{{ $lang }}/p/{{ $product_lang['slug'] }}" class="details button border">{{ __('Details') }}</a>
                </div>

                <ul class="listing-details">
                  @foreach ($product->options as $option)
                    <?php $data = unserialize($option->data); ?>
                    @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms']))
                      <?php $titles = unserialize($option->title); ?>
                      <li>{{ $data[$lang]['data'] }}: <span>{{ $titles[$lang]['title'] }}</span></li>
                    @endif
                  @endforeach
                </ul>

                <!-- <div class="listing-footer">
                  <a href="#"><i class="fa fa-bank"></i> {{ $product->company->title }}</a>
                  <span><i class="fa fa-calendar-o"></i> 4 days ago</span>
                </div> -->
              </div>
            </div>
          @endforeach
        </div>
      @endif

      
      <!-- Pagination -->
      <div class="pagination-container margin-top-20">
        {{ $products->links() }}
      </div>

    </div>

    <!-- Widget -->
    <div class="col-md-4">
      <div class="sidebar left">
        <div class="my-account-nav-container">
          <ul class="my-account-nav">
            <li class="sub-nav-title">{{ __('Regions') }}</li>
            @foreach ($categories as $key => $category)
              <li><a href="/{{ $lang }}/c/{{ $category->slug.'/'.$category->id }}" class="current">{{ $category->title }}</a> {{ $category->products->count() }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
  <script>
    // Actions
    $('#actions').change(function() {

      var action = $(this).val();
      var page = $(location).attr('href').split('catalog')[1];
      var slug = page.split('?')[0];

      console.log(page, slug);
      return true;

      $.ajax({
        type: "get",
        url: '/{{ $lang }}/catalog'.page,
        dataType: "json",
        data: {
          "action": action
        },
        success: function(data) {
          $('#products').html(data);
          // location.reload();
        }
      });
    });
  </script>
@endsection
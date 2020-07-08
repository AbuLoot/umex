@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

@section('head')

@endsection

@section('content')

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
  <div class="row fullwidth-layout">

    <div class="col-md-12 margin-bottom-25">
      <a href="/{{ $lang }}/i/catalog/1" class="button @if(!Request::is($lang.'/i/catalog/1')) border @endif">{{ __('Rent') }}</a>
      <a href="/{{ $lang }}/i/catalog/2" class="button @if(!Request::is($lang.'/i/catalog/2')) border @endif">{{ __('Sale') }}</a>
    </div>

    <div class="col-md-12">
      <!-- Sorting / Layout Switcher -->
      <!-- <div class="row margin-bottom-15-">
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

        <div class="col-md-6">
          <div class="layout-switcher">
            <a href="#" class="grid-three"><i class="fa fa-th"></i></a>
            <a href="#" class="list"><i class="fa fa-th-list"></i></a>
          </div>
        </div>
      </div> -->

      <!-- Listings -->
      <div class="listings-container grid-layout-three">

        <?php $i = 1; ?>
        <?php $condition = last(explode('/', Request::path())); ?>
        @foreach($products_lang as $product_lang)

          @continue($condition == $product_lang->product->condition)

          <div class="listing-item">
            <a href="/{{ $lang }}/p/{{ $product_lang->slug }}" class="listing-img-container">
              <div class="listing-badges">
                <span>{{ trans('statuses.condition.'.$product_lang->product->condition) }}</span>
              </div>
              <div class="listing-img-content">
                <span class="listing-price">{{ $product_lang->price_total }}₸</span>
                <!-- <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span> -->
              </div>
              <img src="/img/products/{{ $product_lang->product->path.'/'.$product_lang->product->image }}" alt="{{ $product_lang->title }}">
            </a>

            <div class="listing-content">
              <div class="listing-title">
                <h4><a href="/{{ $lang }}/p/{{ $product_lang->slug }}">{{ $product_lang->title }}</a></h4>
                <a href="#" class="listing-address popup-gmaps">
                  <i class="fa fa-map-marker"></i> {{ $product_lang->characteristic }}
                </a>
              </div>
              <ul class="listing-features">
                @foreach ($product_lang->product->options as $option)
                  <?php $data = unserialize($option->data); ?>
                  @if (in_array($data[$lang]['data'], ['Тип обьекта', 'Type of property', 'Количество комнат', 'Number of rooms', 'Комнаты', 'Rooms']))
                    <?php $titles = unserialize($option->title); ?>
                    <li>{{ $data[$lang]['data'] }} <span>{{ $titles[$lang]['title'] }}</span></li>
                  @endif
                @endforeach
              </ul>
              <div class="listing-footer">
                <a href="#"><i class="fa fa-bank"></i> {{ $product_lang->product->company->title }}</a>
              </div>
            </div>
          </div>
          <?php if ($i++ == 3) : $i = 1; ?>
            <div class="clearfix"></div>
          <?php endif; ?>
        @endforeach
      </div>

      <div class="clearfix"></div>
      <div class="pagination-container margin-top-20">
        {{ $products_lang->links() }}
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
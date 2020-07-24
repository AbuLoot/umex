  <div class="listings-container grid-layout-three">
    @foreach($products_lang as $product_lang)
      <div class="listing-item">
        <a href="/{{ $lang }}/p/{{ $product_lang->slug }}" class="listing-img-container">
          <div class="listing-badges">
            <span>{{ trans('statuses.condition.'.$product_lang->product->condition) }}</span>
          </div>
          <div class="listing-img-content">
            <span class="listing-price">{{ number_format($product_lang->price_total, 0, ' ', ' ') }}₸</span>
            <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>
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
        </div>
      </div>
    @endforeach
  </div>

  <div class="clearfix"></div>
  <div class="pagination-container margin-top-20">
    {{ $products_lang->links() }}
  </div>
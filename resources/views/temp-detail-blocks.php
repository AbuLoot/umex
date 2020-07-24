
        <div class="property-main-features padding-top-30">
          <table class="table table-striped">
            <tbody>
              @foreach ($product_lang->product->options as $option)
                <?php $data = unserialize($option->data); ?>
                @unless (in_array($data[$lang]['data'], ['Год постройки', 'Year of construction']))
                  <?php $titles = unserialize($option->title); ?>
                  <tr>
                    <th scope="row">{{ $data[$lang]['data'] }}</th>
                    <td>{{ $titles[$lang]['title'] }}</td>
                  </tr>
                @endunless
              @endforeach
            </tbody>
          </table>
        </div>

        
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

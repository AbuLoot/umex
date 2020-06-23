
    <!-- Most Popular Places -->
    @if ($categories->isNotEmpty())
      <section class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="headline centered margin-bottom-25">{{ __('Popolar City') }}</h2>
          </div>

          @foreach ($categories as $key => $category)
            <div class="col-sm-6 col-md-6">
              <a href="/{{ $lang }}/c/{{ $category->slug.'/'.$category->id }}" class="img-box" data-background-image="/file-manager/{{ $category->image }}">
                <div class="listing-badges">
                  <span class="featured">{{ trans('statuses.category.'.$category->status) }}</span>
                </div>
                <div class="img-box-content visible">
                  <h4>{{ $category->title }}</h4>
                  <span>{{ __('Properties').': '.$category->products->count() }}</span>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </section>
    @endif
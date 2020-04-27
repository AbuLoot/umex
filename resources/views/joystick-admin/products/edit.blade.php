@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li role="presentation" @if ($language->slug == $product_lang->lang) class="active" @endif><a href="/{{ $language->slug }}/admin/products/{{ $product->id }}/edit">{{ $language->title }}</a></li>
        @endforeach
        <li role="presentation"><a href="/{{ $lang }}/admin/products/{{ $product->id }}/comments">Коментарии</a></li>
      </ul>
    </div>
    <div class="col-md-6">
      <p class="text-right">
        <a href="/{{ $lang }}/admin/products" class="btn btn-primary btn-sm">Назад</a>
      </p>
    </div>
  </div><br>

  <form action="/{{ $lang }}/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $product_lang->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $product_lang->slug }}">
    </div>
    <div class="form-group">
      <label for="meta_title">Мета заголовок</label>
      <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ (old('meta_title')) ? old('meta_title') : $product_lang->meta_title }}">
    </div>
    <div class="form-group">
      <label for="meta_description">Мета описание</label>
      <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $product_lang->meta_description }}">
    </div>
    <div class="form-group">
      <label for="description">Описание</label>
      <textarea class="form-control" name="description" rows="6" maxlength="2000">{{ (old('description')) ? old('description') : $product_lang->description }}</textarea>
    </div>
    <div class="form-group">
      <label for="characteristic">Адрес</label>
      <input type="text" class="form-control" id="characteristic" name="characteristic" minlength="2" maxlength="80" value="{{ (old('characteristic')) ? old('characteristic') : $product_lang->characteristic }}">
    </div>

    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $product->sort_id }}">
    </div>
    <div class="form-group">
      <label for="company_id">Компания</label>
      <select id="company_id" name="company_id" class="form-control">
        <option value=""></option>
        @foreach($companies as $company)
          @if ($company->id == $product->company_id)
            <option value="{{ $company->id }}" selected>{{ $company->title }}</option>
          @else
            <option value="{{ $company->id }}">{{ $company->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <p><b>Категории</b></p>
    <div class="panel panel-default">
      <div class="panel-body" style="max-height: 250px; overflow-y: auto;">
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $product) { ?>
          <?php foreach ($nodes as $node) : ?>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="categories_id[]" value="{{ $node->id }}" <?php if ($product->categories->contains($node->id)) echo "checked"; ?>> {{ PHP_EOL.$prefix.' '.$node->title }}
              </label>
            </div>
            <?php $traverse($node->children, $prefix.'___'); ?>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($categories); ?>
      </div>
    </div>
    <p><b>Опции</b></p>
    <div class="panel panel-default">
      <div class="panel-body" style="max-height: 250px; overflow-y: auto;">
        <?php $grouped = $options->groupBy('data'); ?>
        @forelse ($grouped as $data => $group)
          <?php $data = unserialize($data); ?>
          <p><b>{{ $data[$lang]['data'] }}</b></p>
          @foreach ($group as $option)
            <?php $titles = unserialize($option->title); ?>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="options_id[]" value="{{ $option->id }}" @if ($product->options->contains($option->id)) checked @endif> {{ $titles[$lang]['title'] }}
              </label>
            </div>
          @endforeach
        @endforeach
      </div>
    </div>
    <div class="form-group">
      <label for="barcode">Артикул</label>
      <input type="text" class="form-control" id="barcode" name="barcode" value="{{ (old('barcode')) ? old('barcode') : $product->barcode }}">
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="area">Площадь (участок)</label>
          <input type="text" class="form-control" id="area" name="area" maxlength="10" value="{{ (old('area')) ? old('area') : $product->area }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="area_total">Площадь (общая)</label>
          <input type="text" class="form-control" id="area_total" name="area_total" maxlength="10" value="{{ (old('area_total')) ? old('area_total') : $product->capacity }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="price">Цена за кв. м.</label>
          <div class="input-group">
            <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ (old('price')) ? old('price') : $product_lang->price }}">
            <div class="input-group-addon">{{ $currency->symbol }}</div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="price_total">Цена</label>
          <div class="input-group">
            <input type="text" class="form-control" id="price_total" name="price_total" maxlength="10" value="{{ (old('price_total')) ? old('price_total') : $product_lang->price_total }}">
            <div class="input-group-addon">{{ $currency->symbol }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="count">Количество</label>
      <input type="number" class="form-control" id="count" name="count" minlength="5" maxlength="80" value="{{ (old('count')) ? old('count') : $product->count }}">
    </div>
    <div class="form-group">
      <label for="condition">Условие</label><br>
      <label class="radio-inline">
        <input type="radio" name="condition" value="1" @if ($product->condition == '1') checked @endif> Продажа
      </label>
      <label class="radio-inline">
        <input type="radio" name="condition" value="2" @if ($product->condition == '2') checked @endif> Аренда
      </label>
    </div>
    <div class="form-group" id="gallery">
      <label>Галерея</label><br>
      <?php $images = ($product->images == true) ? unserialize($product->images) : []; ?>
      <?php $key_last = array_key_last($images); ?>
      @for ($i = 0; $i <= (($key_last >= 6) ? $key_last : 5); $i++)
        @if(array_key_exists($i, $images))
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
              <img src="/img/products/{{ $product->path.'/'.$images[$i]['present_image'] }}">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
            <div>
              <span class="btn btn-default btn-sm btn-file">
                <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                <input type="file" name="images[]" accept="image/*">
              </span>
              <label>
                <input type="checkbox" name="remove_images[]" value="{{ $i }}"> Удалить
              </label>
              <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
            </div>
          </div>
        @else
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
            <div>
              <span class="btn btn-default btn-sm btn-file">
                <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                <input type="file" name="images[]" accept="image/*">
              </span>
              <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
            </div>
          </div>
        @endif
      @endfor
    </div>
    <div>
      <button type="button" class="btn btn-success" onclick="addFileinput(this);">Добавить загрузчик</button>
    </div>
    <br>
    <p><b>Режимы</b></p>
    <div class="panel panel-default">
      <div class="panel-body" style="max-height: 150px; overflow-y: auto;">
        @foreach($modes as $mode)
          <?php $titles = unserialize($mode->title); ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="modes_id[]" value="{{ $mode->id }}" <?php if ($product->modes->contains($mode->id)) echo "checked"; ?>> {{ $titles[$lang]['title'] }}
            </label>
          </div>
        @endforeach
      </div>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        @foreach($languages as $language)
          @if ($language->slug == $product_lang->lang)
            <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
          @else
            <option value="{{ $language->slug }}">{{ $language->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="status">Статус</label>
      @foreach(trans('statuses.data') as $num => $status)
        <br>
        <label>
          <input type="radio" id="status" name="status" value="{{ $num }}" @if ($num == $product->status) checked @endif> {{ $status }}
        </label>
      @endforeach
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
  <script src='https://cdn.tiny.cloud/1/s9hqkvt9a9gdfym5yyaz2pgllizccjq8p71rxv2s5gp714p4/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      height: 300,
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table directionality emoticons template paste'
      ],
      content_css: ['/css/style.css', '/css/custom.css'],
      menubar: 'file edit view insert format tools table help',
      toolbar: 'insertfile undo redo | formatselect fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media | code',
      font_formats: 'Playfair Display; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva;'

    });
  </script>
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
  <script>
    function addFileinput(i) {
      var fileinput = 
        '<div class="fileinput fileinput-new" data-provides="fileinput">' +
            '<div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>' +
            '<div>' +
              '<span class="btn btn-default btn-sm btn-file">' +
                '<span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>' +
                '<span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>' +
                '<input type="file" name="images[]" accept="image/*">' +
              '</span>' +
              '<a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>' +
            '</div>' +
          '</div>';

      $('#gallery').append(fileinput);
    }
  </script>
@endsection

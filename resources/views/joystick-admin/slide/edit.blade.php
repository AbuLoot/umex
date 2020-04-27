@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/{{ $lang }}/admin/slide" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('slide.update', [$lang, $item->id]) }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}
    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $item->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $item->slug }}">
    </div>
    <div class="form-group">
      <label for="marketing">Маркетинг</label>
      <input type="text" class="form-control" id="marketing" name="marketing" minlength="2" maxlength="80" value="{{ (old('marketing')) ? old('marketing') : $item->marketing }}">
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="color">Цвет текста</label><br>
        <input type="color" class="form-control" id="color" name="color" minlength="2" maxlength="80" value="{{ (old('color')) ? old('color') : $item->color }}">
      </div>
      <div class="form-group col-md-6">
        <label for="direction">Позиция текста</label><br>
        <label class="radio-inline">
          <input type="radio" name="direction" value="left"  @if($item->direction == 'left') checked @endif> По левой стороне
        </label>
        <!-- <label class="radio-inline">
          <input type="radio" name="direction" value="center" @if($item->direction == 'center') checked @endif> По центру
        </label> -->
        <label class="radio-inline">
          <input type="radio" name="direction" value="right" @if($item->direction == 'right') checked @endif> По правой стороне
        </label>
      </div>
    </div>
    <div class="form-group">
      <label for="sort_id">Позиция фона в процентах</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $item->sort_id }}">
    </div>
    <div class="form-group">
      <label for="link">Ссылка на продукт</label>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon3"><?= $_SERVER['SERVER_NAME'] ?></span>
        <input type="text" name="link" class="form-control" id="link" aria-describedby="basic-addon3" maxlength="255" value="{{ (old('link')) ? old('link') : $item->link }}">
      </div>
    </div>
    <div class="form-group">
      <label for="image">Фон</label><br>
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail" style="width:100%;height:auto;">
          <img src="/img/slide/{{ $item->image }}">
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail" style="width:100%;height:auto;"></div>
        <div>
          <span class="btn btn-default btn-sm btn-file">
            <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
            <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
            <input type="file" name="image" accept="image/*">
          </span>
          <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($item->lang == $language->slug)
            <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
          @else
            <option value="{{ $language->slug }}">{{ $language->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="status">Статус:</label>
      <label>
        <input type="checkbox" id="status" name="status" @if ($item->status == 1) checked @endif> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
@endsection

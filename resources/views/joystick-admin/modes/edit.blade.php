@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li role="presentation" @if ($language->slug == $lang) class="active" @endif><a href="/{{ $language->slug }}/admin/modes/{{ $mode->id }}/edit">{{ $language->title }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6">
      <p class="text-right">
        <a href="/{{ $lang }}/admin/modes" class="btn btn-primary btn-sm">Назад</a>
      </p>
    </div>
  </div><br>

  <form action="{{ route('modes.update', [$lang, $mode->id]) }}" method="post">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Название</label>
      <?php $titles = unserialize($mode->title); ?>
      <input type="text" class="form-control" id="title" name="title" maxlength="80" value="{{ (old('title')) ? old('title') : $titles[$lang]['title'] }}">
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ (old('slug')) ? old('slug') : $mode->slug }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ (old('sort_id')) ? old('sort_id') : $mode->sort_id }}">
    </div>
    <div class="form-group">
      <label for="data">Данные</label>
      <input type="text" class="form-control" id="data" name="data" value="{{ (old('data')) ? old('data') : $mode->data }}">
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($language->slug == $lang)
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
        <input type="checkbox" id="status" name="status" @if ($mode->status == 1) checked @endif> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection

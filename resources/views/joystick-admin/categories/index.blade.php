@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Категории</h2>

  @include('joystick-admin.partials.alerts')

  <div class="text-right">
    <div class="btn-group">
      <button type="button" id="submit" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Функции <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-right" id="actions">
        @foreach(trans('statuses.category') as $num => $status)
          <li><a data-action="{{ $num }}" href="#">Статус {{ $status }}</a></li>
        @endforeach
      </ul>
    </div>
    <a href="/{{ $lang }}/admin/categories/create" class="btn btn-success btn-sm">Добавить</a>
  </div><br>
  <div class="table-responsive">
    <table class="table table-condensed table-hover">
      <thead>
        <tr class="active">
          <td><input type="checkbox" onclick="toggleCheckbox(this)" class="checkbox-ids"></td>
          <td>№</td>
          <td>Название</td>
          <td>URI</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $lang, &$i) { ?>
          <?php foreach ($nodes as $node) : ?>
            <tr>
              <td><input type="checkbox" name="categories_id[]" value="{{ $node->id }}" class="checkbox-ids"></td>
              <td>{{ $i++ }}</td>
              <td>{{ PHP_EOL.$prefix.' '.$node->title }}</td>
              <td>{{ $node->slug }}</td>
              <td>{{ $node->sort_id }}</td>
              <td>{{ $node->lang }}</td>
              <td class="text-info">{{ trans('statuses.category.'.$node->status) }}</td>
              <td class="text-right">
                <a class="btn btn-link btn-xs" href="{{ route('categories.edit', [$lang, $node->id]) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
                <form method="POST" action="{{ route('categories.destroy', [$lang, $node->id]) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
                </form>
              </td>
              <?php $traverse($node->children, $prefix.'___'); ?>
            </tr>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($categories); ?>
      </tbody>
    </table>
  </div>
@endsection

@section('scripts')
  <script>
    // Submit button click
    $("#actions > li > a").click(function() {

      var action = $(this).data("action");
      var categoriesId = new Array();

      $('input[name="categories_id[]"]:checked').each(function() {
        categoriesId.push($(this).val());
      });

      if (categoriesId.length > 0) {
        $.ajax({
          type: "get",
          url: '/{{ $lang }}/admin/categories-actions',
          dataType: "json",
          data: {
            "action": action,
            "categories_id": categoriesId
          },
          success: function(data) {
            console.log(data);
            location.reload();
          }
        });
      }
    });

    // Toggle checkbox
    function toggleCheckbox(source) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
          checkboxes[i].checked = source.checked;
      }
    }
  </script>
@endsection
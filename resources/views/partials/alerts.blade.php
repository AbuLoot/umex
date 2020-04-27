
  @if (session('info'))
    <div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session('info') }}
    </div>
  @endif

  @if (session('warning'))
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session('warning') }}
    </div>
  @endif

	@if (session('status'))
	  <div class="alert alert-success">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    {{ session('status') }}
	  </div>
	@endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

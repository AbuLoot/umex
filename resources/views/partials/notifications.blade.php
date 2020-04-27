  @if (session('info'))
    <div class="notification notice closeable">
      <p>{{ session('info') }}</p>
      <a class="close" href="#"></a>
    </div>
  @endif

  @if (session('warning'))
    <div class="notification warning closeable">
      <p>{{ session('warning') }}</p>
      <a class="close" href="#"></a>
    </div>
  @endif

	@if (session('status'))
    <div class="notification success closeable">
	    <p>{{ session('message') }}</p>
      <a class="close" href="#"></a>
	  </div>
	@endif

  @if ($errors->any())
    <div class="notification error closeable">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <a class="close" href="#"></a>
    </div>
  @endif

@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

@section('head')

@endsection

@section('content')

<!-- Titlebar -->
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


<!-- Container / Start -->
<div class="container margin-top-50 margin-bottom-50">

  <div class="row">

    <!-- Contact Details -->
    <div class="col-md-4">

      <h4 class="headline margin-bottom-30">{{ __('Contact Us') }}</h4>

      <?php
        $contacts = $section->firstWhere('slug', 'contacts');
        $data_phones = unserialize($contacts->data_1);
        $phones = explode('/', $data_phones['value']);
        $data_email = unserialize($contacts->data_2);
        $data_address = unserialize($contacts->data_3);
      ?>

      <!-- Contact Details -->
      <div class="sidebar-textbox">
        <p>{{ $data_address['value'] }}</p>

        <ul class="contact-details">
          <li><i class="im im-icon-Phone-2"></i>
            <strong>{{ $data_phones['key'] }}:</strong>
            @foreach ($phones as $phone)
              <span><a href="tel:{{ $phone }}">{{ $phone }}</a></span><br>
            @endforeach 
          </li>
          <li><i class="im im-icon-Globe"></i> <strong>Web:</strong> <span><a href="http://umex.kz">www.umex.kz</a></span></li>
          <li><i class="im im-icon-Envelope"></i> <strong>E-Mail:</strong> <span><a href="mailto:{{ $data_email['value'] }}">{{ $data_email['value'] }}</a></span></li>
        </ul>
      </div>

    </div>

    <!-- Contact Form -->
    <div class="col-md-8">

      <section id="contact">
        <h4 class="headline margin-bottom-35">{{ __('Contact Form') }}</h4>

        <div id="contact-message"></div> 

          <form method="post" action="/{{ $lang }}/send-app" name="contactform" id="contactform" autocomplete="on">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div>
                  <input name="name" type="text" id="name" placeholder="{{ __('Your Name') }}" required="required" />
                </div>
              </div>

              <div class="col-md-6">
                <div>
                  <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="{{ __('Your Phone') }}" required>
                </div>
              </div>
            </div>

            <div>
              <input name="email" type="email" id="email" placeholder="{{ __('Your Email') }}" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
            </div>

            <div>
              <textarea name="comments" cols="40" rows="3" id="comments" placeholder="{{ __('Your Message') }}" spellcheck="true" required="required"></textarea>
            </div>

            <input type="submit" class="submit button" id="submit" value="{{ __('Send Message') }}" />

          </form>
      </section>
    </div>

  </div>

</div>

@endsection

@section('scripts')

@endsection
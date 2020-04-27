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

      <h4 class="headline margin-bottom-30">Find Us There</h4>

      <!-- Contact Details -->
      <div class="sidebar-textbox">
        <p>Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services.</p>

        <ul class="contact-details">
          <li><i class="im im-icon-Phone-2"></i> <strong>Phone:</strong> <span>(123) 123-456 </span></li>
          <li><i class="im im-icon-Fax"></i> <strong>Fax:</strong> <span>(123) 123-456 </span></li>
          <li><i class="im im-icon-Globe"></i> <strong>Web:</strong> <span><a href="#">www.example.com</a></span></li>
          <li><i class="im im-icon-Envelope"></i> <strong>E-Mail:</strong> <span><a href="#">office@example.com</a></span></li>
        </ul>
      </div>

    </div>

    <!-- Contact Form -->
    <div class="col-md-8">

      <section id="contact">
        <h4 class="headline margin-bottom-35">Contact Form</h4>

        <div id="contact-message"></div> 

          <form method="post" action="contact.php" name="contactform" id="contactform" autocomplete="on">

            <div class="row">
              <div class="col-md-6">
                <div>
                  <input name="name" type="text" id="name" placeholder="Your Name" required="required" />
                </div>
              </div>

              <div class="col-md-6">
                <div>
                  <input name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
                </div>
              </div>
            </div>

            <div>
              <input name="subject" type="text" id="subject" placeholder="Subject" required="required" />
            </div>

            <div>
              <textarea name="comments" cols="40" rows="3" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
            </div>

            <input type="submit" class="submit button" id="submit" value="Submit Message" />

          </form>
      </section>
    </div>

  </div>

</div>

@endsection

@section('scripts')

@endsection
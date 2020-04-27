<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <link rel="icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <title>@yield('meta_title', 'Residential rental &mdash; «UMEX Real Estate» Agency')</title>
  <meta name="description" content="@yield('meta_description', 'UMEX Real Estate Agancy и Meta Keywords:Residential Rental Almaty, Rent Apartment Almaty, Rent House Almaty. Best Services Almaty, Real Estate Agency Almaty')">
  <meta name="author" content="issayev.adilet@gmail.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/color.css">
  <link rel="stylesheet" href="/css/custom.css">
  @yield('head')

  <?php echo $section_codes->firstWhere('slug', 'header-code')->content; ?>
</head>
<body>
  <div id="wrapper">

    <header id="header-container">
      <div id="top-bar">
        <div class="container">

          <div class="left-side">
            <ul class="top-bar-menu">
              <li><a href="/ru"><img src="/img/russia.png"> Русский</a></li>
              <li><a href="/en"><img src="/img/kingdom.png"> English</a></li>
            </ul>
          </div>
          <?php
            $contacts = $section->firstWhere('slug', 'contacts');
            $data_phones = unserialize($contacts->data_1);
            $phones = explode('/', $data_phones['value']);
            $data_email = unserialize($contacts->data_2);
            $data_address = unserialize($contacts->data_3);
          ?>
          <div class="right-side">
            <!-- Top bar -->
            <ul class="top-bar-menu text-right">
              <li>
                <div class="top-bar-dropdown">
                  <span><i class="fa fa-phone"></i> {{ $phones[0] }}</span>
                  <ul class="options text-nowrap">
                    <li><div class="arrow"></div></li>
                    @foreach ($phones as $phone)
                      <li><a href="tel:{{ $phone }}">{{ $phone }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </li>
              <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $data_email['value'] }}">{{ $data_email['value'] }}</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <!-- Header -->
      <div id="header">
        <div class="container">
          
          <div class="left-side-">
            <div id="logo">
              <a href="/{{ $lang }}"><img src="/img/logo.png" alt="UMEX"></a>
            </div>

            <!-- Mobile Navigation -->
            <div class="mmenu-trigger">
              <button class="hamburger hamburger--collapse" type="button">
                <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
                </span>
              </button>
            </div>

            <nav id="navigation" class="style-1">
              <ul id="responsive">
                <?php $traverse = function ($pages) use (&$traverse, $lang) { ?>
                  <?php foreach ($pages as $page) : ?>
                    <?php if ($page->isRoot() && $page->descendants->count() > 0) : ?>
                      <li>
                        <a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a>
                        <ul>
                          <?php $traverse($page->children, $page->slug.'/'); ?>
                        </ul>
                      </li>
                    <?php else : ?>
                      <li><a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($pages); ?>
              </ul>
            </nav>
            <div class="clearfix"></div>
          </div>

          <div class="right-side">
            <!-- <div class="user-menu-container header-widget">
              <div class="user-menu">
                <div class="user-name"><i class="sl sl-icon-call-in"></i> +7 (727) 313 10 60</div>
                <ul class="text-nowrap">
                  <li><a href="#">+7 (727) 313 10 60</a></li>
                  <li><a href="#">+7 (727) 313 10 55</a></li>
                  <li><a href="#">+7 (727) 272 57 57</a></li>
                  <li><a href="#">(EN) +7 707 599 00 93</a></li>
                </ul>
              </div>
            </div> -->
            <!-- <div class="header-widget">
              <a href="login-register.html" class="sign-in"><i class="fa fa-user"></i> Log In / Register</a>
            </div> -->
          </div>

        </div>
      </div>
    </header>

    <div class="clearfix"></div>


    <!-- Content -->
    @yield('content')

    <!-- Widget contact buttons -->
    <div class="material-button-anim">
      <ul class="list-inline" id="options">
        <li class="option">
          <button class="material-button option2 bg-whatsapp" type="button">
            <a href="whatsapp://send?phone={{ $phones[0] }}" target="_blank">
              <!-- <span class="fa fa-whatsapp" aria-hidden="true"></span> -->
              <img src="/img/whatsapp.png">
            </a>
          </button>
        </li>
        <li class="option">
          <button class="material-button option3 bg-ripple" type="button">
            <a href="tel:{{ $phones[0] }}" target="_blank"><span class="fa fa-phone" aria-hidden="true"></span></a>
          </button>
        </li>
        <li class="option">
          <button class="material-button option4" type="button">
            <a href="mailto:{{ $data_email['value'] }}" target="_blank"><span class="fa fa-envelope" aria-hidden="true"></span></a>
          </button>
        </li>
      </ul>
      <button class="material-button material-button-toggle btnBg" type="button">
        <span class="fa fa-user" aria-hidden="true"></span>
        <span class="ripple btnBg"></span>
        <span class="ripple btnBg"></span>
        <span class="ripple btnBg"></span>
      </button>
    </div>

    <!-- Footer -->
    <div id="footer" class="sticky-footer-">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-12">
            <img class="footer-logo" src="/img/logo.png" alt="">
            <br><br>
            <?php $copyright = $section->firstWhere('slug', 'copyright'); ?>
            <p>{{ $copyright->content }}</p>
          </div>

          <div class="col-md-4 col-sm-6 ">
            <h4>{{ __('Pages') }}</h4>
            <ul class="footer-links">
              <?php $traverse = function ($pages) use (&$traverse, $lang) { ?>
                <?php foreach ($pages as $page) : ?>
                  <?php if ($page->isRoot() && $page->descendants->count() > 0) : ?>
                    <li>
                      <a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a>
                      <ul>
                        <?php $traverse($page->children, $page->slug.'/'); ?>
                      </ul>
                    </li>
                  <?php else : ?>
                    <li><a href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverse($pages); ?>
            </ul>

            <div class="clearfix"></div>
          </div>    

          <div class="col-md-4 col-sm-6">
            <h4>{{ __('Contact Us') }}</h4>
            <div class="text-widget">
              <p><span>{{ $data_address['value'] }}</span></p>
              <p>
                {{ $data_phones['key'] }}:<br>
                @foreach ($phones as $phone)
                  <span><a href="tel:{{ $phone }}">{{ $phone }}</a></span><br>
                @endforeach

                {{ $data_email['key'] }}: <span><a href="mailto:{{ $data_email['value'] }}">{{ $data_email['value'] }}</a></span>
              </p>
            </div>
          </div>
        </div>
        
        <!-- Copyright -->
        <div class="row">
          <div class="col-md-12">
            <div class="copyrights">© 1998—{{ date('Y') }} UMEX Real Estate</div>
          </div>
        </div>

      </div>

    </div>


    <!-- Back To Top Button -->
    <div id="backtotop"><a href="#"></a></div>


    <!-- Scripts -->
    <script type="text/javascript" src="/scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery-migrate-3.1.0.min.js"></script>
    <script type="text/javascript" src="/scripts/chosen.min.js"></script>
    <script type="text/javascript" src="/scripts/magnific-popup.min.js"></script>
    <script type="text/javascript" src="/scripts/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/scripts/rangeSlider.js"></script>
    <script type="text/javascript" src="/scripts/sticky-kit.min.js"></script>
    <script type="text/javascript" src="/scripts/slick.min.js"></script>
    <script type="text/javascript" src="/scripts/masonry.min.js"></script>
    <script type="text/javascript" src="/scripts/mmenu.min.js"></script>
    <script type="text/javascript" src="/scripts/tooltips.min.js"></script>
    <script type="text/javascript" src="/scripts/custom.js"></script>
    @yield('scripts')

    <?php echo $section_codes->firstWhere('slug', 'footer-code')->content; ?>
  </div>
</body>
</html>
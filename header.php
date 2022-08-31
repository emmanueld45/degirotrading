  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
      var Tawk_API = Tawk_API || {},
          Tawk_LoadStart = new Date();
      (function() {
          var s1 = document.createElement("script"),
              s0 = document.getElementsByTagName("script")[0];
          s1.async = true;
          s1.src = 'https://embed.tawk.to/62d3a7e4b0d10b6f3e7cb696/1g85cfmli';
          s1.charset = 'UTF-8';
          s1.setAttribute('crossorigin', '*');
          s0.parentNode.insertBefore(s1, s0);
      })();
  </script>
  <!--End of Tawk.to Script-->
  <!-- <script type="text/javascript">
      window.$crisp = [];
      window.CRISP_WEBSITE_ID = "ca50e4f4-d620-4a52-aced-af07bb537f2a";
      (function() {
          d = document;
          s = d.createElement("script");
          s.src = "https://client.crisp.chat/l.js";
          s.async = 1;
          d.getElementsByTagName("head")[0].appendChild(s);
      })();
  </script> -->
  <!-- <script src="//code.tidio.co/d1gbescxc81uc0urqerp8zhwsndjd8et.js" async></script> -->
  <!-- Smartsupp Live Chat script -->
  <!-- <script type="text/javascript">
      var _smartsupp = _smartsupp || {};
      _smartsupp.key = '58cf3f1b1bbc297fc7c47caaece725a16a57d2d2';
      window.smartsupp || (function(d) {
          var s, c, o = smartsupp = function() {
              o._.push(arguments)
          };
          o._ = [];
          s = d.getElementsByTagName('script')[0];
          c = d.createElement('script');
          c.type = 'text/javascript';
          c.charset = 'utf-8';
          c.async = true;
          c.src = 'https://www.smartsuppchat.com/loader.js?';
          s.parentNode.insertBefore(c, s);
      })(document);
  </script> -->
  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
          <div class="contact-info d-flex align-items-center">
              <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:<?php echo $admin->getDetail($admin->admin_id, "email"); ?>"><?php echo $admin->getDetail($admin->admin_id, "email"); ?></a></i>
              <i class="bi bi-phone d-flex align-items-center ms-4"><span><?php echo $admin->getDetail($admin->admin_id, "phone"); ?></span></i>
          </div>
          <!-- <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div> -->
      </div>
  </section>

  <header id="header" class="d-flex align-items-center">

      <div class="container d-flex align-items-center justify-content-between">

          <!-- <h1 class="logo"><a href="./">Degirotrading<span>.</span></a></h1> -->
          <!-- Uncomment below if you prefer to use an image logo -->
          <a href="./" class="logo"><img src="assets/img/new/3.jpg" alt=""></a>

          <nav id="navbar" class="navbar">
              <ul>
                  <li><a class="nav-link scrollto active" href="./">Home</a></li>
                  <li><a class="nav-link scrollto" href="about">About</a></li>
                  <li><a class="nav-link scrollto" href="login">Login</a></li>

                  <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
                      <ul>
                          <li><a href="#">Drop Down 1</a></li>
                          <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                              <ul>
                                  <li><a href="#">Deep Drop Down 1</a></li>
                                  <li><a href="#">Deep Drop Down 2</a></li>
                                  <li><a href="#">Deep Drop Down 3</a></li>
                                  <li><a href="#">Deep Drop Down 4</a></li>
                                  <li><a href="#">Deep Drop Down 5</a></li>
                              </ul>
                          </li>
                          <li><a href="#">Drop Down 2</a></li>
                          <li><a href="#">Drop Down 3</a></li>
                          <li><a href="#">Drop Down 4</a></li>
                      </ul>
                  </li> -->
                  <li><a class="nav-link scrollto" href="contact">Contact</a></li>
              </ul>
              <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

      </div>
  </header>
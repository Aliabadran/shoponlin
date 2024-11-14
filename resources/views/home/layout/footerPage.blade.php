      <!-- footer section -->
      <footer class="footer_section">
        <div class="container">
           <div class="row">
              <div class="col-md-4 footer-col">
                 <div class="footer_contact">
                    <h4>
                       Reach at..
                    </h4>
                    <div class="contact_link_box">
                       <a href="">
                       <i class="fa fa-map-marker" aria-hidden="true"></i>
                       <span>
                       Location
                       </span>
                       </a>
                       <a href="">
                       <i class="fa fa-phone" aria-hidden="true"></i>
                       <span>
                       Call +01 1234567890
                       </span>
                       </a>
                       <a href="">
                       <i class="fa fa-envelope" aria-hidden="true"></i>
                       <span>
                       aloosh@gmail.com
                       </span>
                       </a>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 footer-col">
                 <div class="footer_detail">
                    <a href="{{ url('/') }}" class="footer-logo">
                    Famms
                    </a>
                    <p>
                        Essential, making this the first real generator on the internet. It uses products containing more than 200 products, coupled with
                      </p>
                    <div class="footer_social">
                       <a href="">
                       <i class="fa fa-facebook" aria-hidden="true"></i>
                       </a>
                       <a href="">
                       <i class="fa fa-twitter" aria-hidden="true"></i>
                       </a>
                       <a href="">
                       <i class="fa fa-linkedin" aria-hidden="true"></i>
                       </a>
                       <a href="">
                       <i class="fa fa-instagram" aria-hidden="true"></i>
                       </a>
                       <a href="">
                       <i class="fa fa-pinterest" aria-hidden="true"></i>
                       </a>
                    </div>
                 </div>
              </div>
              <div class="col-md-4 footer-col">
                 <div class="map_container">
                    <div class="map">
                       <div id="googleMap"></div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="footer-info">
              <div class="col-lg-7 mx-auto px-0">
                 <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/">ALIA Badran</a><br>


                 </p>
              </div>
           </div>
        </div>
     </footer>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <!-- footer section -->
     <!-- jQery -->
     <script src="{{ asset("js/jquery-3.4.1.min.js") }}"></script>
     <!-- popper js -->
     <script src="{{ asset('js/popper.min.js') }}"></script>
     <!-- bootstrap js -->
     <script src="{{asset ('js/bootstrap.js') }}"></script>
     <!-- custom js -->
     <script src="{{ asset('js/custom.js') }}"></script>
     <script src="{{ asset('vendor/mckenziearts/notify/js/notify.js') }}"></script>
     <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
  </body>
</html>

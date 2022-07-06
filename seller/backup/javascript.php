<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="seller/js/bootstrap.min.js" ></script>
<script src="seller/js/owl.carousel.min.js"></script>
<script src="seller/js/lazysizes.min.js"></script>



<script>
$(document).ready(function () {
 
			// Sticky Header Js
			var header = $(".main-header");
			var linkNav  = $(".navbar-nav li .nav-link");
  
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            header.addClass("headerbg");
			linkNav.css('color', '#000');
        } else {
            header.removeClass("headerbg");
			linkNav.css('color', '#000');
        }
    });// Sticky Header Js End
	

//============Mobile Toggle Js================//
              (function () {
  var toggle = document.querySelector('.nav-toggle');
  
  toggle.addEventListener('click', function(e) {
    this.classList.toggle('opened');
  });
})();
			
			
						
});
</script>

<script>
            $(document).ready(function() {
              $('#clientsOwlCraousel').owlCarousel({
                loop: true,
				nav:true,
				dots:false,
				autoplay: true,
                autoplayTimeout:5000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 2,
                    nav: false,
                    dots:true,
                    margin: 10
                  },
              
                  600: {
                    items: 4,
                    nav: false,
                    dots:true,
                    margin: 10
                  },
              
                  1000: {
                    items:5,
                    nav:false,
                    loop: true,
					dots:true,
                    margin:20
                  },
                  
                  1200: {
                    items:5,
                    nav:false,
                    loop: true,
					dots:true,
                    margin:20
                  }
                  
                }
              });
			  
			 
			  
			  
			   $('.owl-carousel').owlCarousel({
                loop: true,
				nav:true,
				dots:false,
				autoplay: true,
                autoplayTimeout:5000,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 2,
                    nav: true,
                    dots:true,
                    margin: 10
                  },
              
                  600: {
                    items: 2,
                    nav: true,
                    dots:true,
                    margin: 10
                  },
              
                  1000: {
                      items:4,
                    nav:true,
                    loop: true,
					    navText: [
        '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>',
        '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>'
    ],
					dots:false,
                    margin:20
                  },
                  
                    1200: {
                    items:4,
                    nav:true,
                    loop: true,
					    navText: [
       '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>',
        '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>'
    ],
					dots:false,
                    margin:20
                  }
                  
                }
              })
			  
			  
            })
          </script>


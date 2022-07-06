<footer class="w-100 position-relative footer-main-laoyout">
	<div class="middle-footer-layout">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
					<div class="footer-card-main">
						<div class="footer-title">
							<h4>Quick links</h4>
						</div>
						<div class="footer-links-item">
							<ul>
								<li><a href="about"> About Us</a></li>
								<li><a href="faq">Faq's</a></li>
								<li><a href="fee-structure">Fee Structure</a></li>
								<li><a href="seller-policy">Seller Policy</a></li>
								<li><a href="learning-guides">Learning Guides</a></li>
								<li><a href="merchant-penalties">Merchant Penalties</a></li>
							</ul>
							<div class="social-media-links">
								<ul>
									<li><a href="https://www.facebook.com/24sadar/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="https://twitter.com/Sadar_24" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="https://www.youtube.com/channel/UCMGvmWs2jz0PUbun-CCN-KQ" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
									<li><a href="https://www.instagram.com/sadar.24/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
								</ul>
							</div>
							<p>Copyright 2021 © Sadar24. All Rights Reserved.</p>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
					<div class="footer-card-main custom-mt-phone">
						<div class="footer-title">
							<h4>ADDRESS</h4>
						</div>
						<div class="address-column">
							<p>Sadar24 </p>
						</div>
						<div class="phone-column mt-2">
							<a href="tel:+917800708708"><i class="fa fa-phone" aria-hidden="true"></i> +91 7800-708-708</a>    
						</div>
						<div class="email-column">
							<a href="email:info@sadar24.com"><i class="fa fa-envelope" aria-hidden="true"></i> info@sadar24.com</a>    
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- The Modal -->
<div class="modal fade" id="myModal">
	<div class="modal-dialog topPush">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header-custom">
				<h4>Grow your business faster by<br> selling on Sadar24</h4>
				<p>India's largest Reselling platform with lowest commission rates</p>
				<button type="button" class="close closeCustome" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="contact-form-panel">
					<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
						<div class="row">
							<div class="col-md-8 col-sm-12 col-12">
								<div class="form-group">
									<input type="tel" name="phone_number" pattern="^\d{10}$"
										required="required" class="form-control search-input" id="phone_number SearchLawyers" placeholder="Enter your mobile number">
								</div>
							</div>
							<div class="col-md-4 col-sm-12 col-12 padding-left">
								<input type="submit" name="Ssubmit" class="btn-saecrh-bar" value="Start Selling" /> 
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="seller/js/bootstrap.min.js" ></script>
<script src="seller/js/owl.carousel.min.js"></script>
<script src="seller/js/lazysizes.min.js"></script>


<script>
	$(document).ready(function () {
		// Sticky Header Js
		var header = $(".main-header");
		var linkNav = $(".navbar-nav li .nav-link");
		$(window).scroll(function () {
			var scroll = $(window).scrollTop();
			if (scroll >= 50) {
				header.addClass("headerbg");
				linkNav.css('color', '#000');
			} else {
				header.removeClass("headerbg");
				linkNav.css('color', '#000');
			}
		}); // Sticky Header Js End

		//============Mobile Toggle Js================//
		(function () {
			var toggle = document.querySelector('.nav-toggle');

			toggle.addEventListener('click', function (e) {
				this.classList.toggle('opened');
			});
		})();
	});
</script>
<script>
            $(document).ready(function() {

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
                    items: 1,
                    nav: true,
                    dots:true,
                    margin: 10
                  },
              
                  600: {
                    items: 1,
                    nav: true,
                    dots:true,
                    margin: 10
                  },
              
                  1000: {
                      items:1,
                    nav:false,
                    loop: true,
					dots:true,
                    margin:20
                  },
                  
                    1200: {
                    items:1,
                    nav:false,
                    loop: true,
					dots:true,
                    margin:20
                  }
                  
                }
              })
			  
			  
            })
          </script>


		
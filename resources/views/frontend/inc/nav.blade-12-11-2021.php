@if(get_setting('topbar_banner') != null)
<div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">
    <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">
        <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="w-100 mw-100 h-50px h-lg-auto img-fit">
    </a>
    <button class="btn text-white absolute-top-right set-session" data-key="top-banner" data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">
        <i class="la la-close la-2x"></i>
    </button>
</div>
@endif
<link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
    />

<nav class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif navbar navbar-expand-lg navbar-dark  d-none d-lg-block p-2" style="background-color: #131921;">
    <div class="w-100">
      <div class="row">
        <div class="col-2 m-auto">
           <div class="row">
              <div class="col-12 text-center text-light my-auto">
				<a class="d-block mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px " >
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px " >
                        @endif
                </a>
                
              </div>
              
           </div>
        </div>
        <div class="col-6 mt-2 my-auto ms-auto">
         <!-- <div class="input-group my-auto'">
             <span class=" input-group-text bg-light">
              <div class="dropdown">
              <small class="dropdown-toggle text-dark" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                All
              </small>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </div></span>  
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            <button id="basic-addon1" style="" class=" input-group-text btn-primary"><i class="fas fa-search"></i></button>
          </div>-->
		  <div class="position-relative flex-grow-1">
			<form action="{{ route('search') }}" method="GET" class="stop-propagation">
				<div class="d-flex position-relative align-items-center">
					<div class="d-lg-none" data-toggle="class-toggle" data-bs-target=".front-header-search">
						<button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
					</div>
					<div class="input-group">
						<input type="text" class="form-control" id="search" name="keyword" @isset($query)
							value="{{ $query }}"
						@endisset placeholder="{{translate('I am shopping for...')}}" style="border-radius: 0;border-end-start-radius: 5px;border-start-start-radius: 5px;" autocomplete="off">
						<button id="basic-addon1" type="submit" class=" input-group-text btn-primary" style="border-radius: 0;border-end-end-radius: 5px;border-start-end-radius: 5px;"><i class="fas fa-search"></i></button>
						
					</div>
				</div>
			</form>
			<div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
				<div class="search-preloader absolute-top-center">
					<div class="dot-loader"><div></div><div></div><div></div></div>
				</div>
				<div class="search-nothing d-none p-3 text-center fs-16">

				</div>
				<div id="search-content" class="text-left">

				</div>
			</div>
		</div>
        </div>
        <div class="col-4 p-0 my-auto">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="container-fluid p-0">
              <div style="width: 100%;" class="row ml-0">
                <div class="col-3 text-light text-center p-2 ps-0 my-auto">
                  <div class="">
                    <p class=" m-0">
                      <img src="https://24sadar.com/public/uploads/all/indian-flag.jpg" alt="Indian Flag" class="mw-100 h-30px " >
                    </p>
                  </div>
                </div>
                <div class="col-md-3 text-light my-auto">
                  <div class="" id="compare">
                        @include('frontend.partials.myaccount')
                    </div>
                </div>
                <div class="col-md-3 text-light p-1  my-auto">
                  <div class="" id="wishlist">
                        @include('frontend.partials.becameaseller')
                    </div>
                </div>
                <div class="col-md-3 text-light mt-2 p-1 my-auto">
                  <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>
              </div>
            </div>
		  </div>
        </div>

      </div>
    </div>
  </nav>
<style>
  #down-menu li{
    font-size: 13px;
    margin: auto !important;
    padding: 0 !important;
    cursor: pointer;
  }
</style>

  <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block pt-0 pb-0" style="background-color: #232F3E;">
     <div class="w-100 p-0">
      <ul class="list-group list-group-horizontal" id="down-menu">
        <li class="list-group-item text-light border-0" style="background-color: #232F3E;">                <div
          onclick="openNav()"
        >
        <small>&#9776; All</small>
        </div></li>
		@if ( get_setting('header_menu_labels') !=  null )
			@foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
				<li class="list-group-item text-light border-0" style="background-color: #232F3E;"><a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" class="fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-100 text-reset">
                          <small>  {{ translate($value) }} </small>
                        </a></li>
			@endforeach
		@endif
        
      </ul>
     </div>
  </nav>


  <nav class=" navbar-expand-lg navbar-dark d-lg-none" style="color:whitesmoke; background-color: #131921;">
      <div class="w-100">
        <div class="row m-0">
          <div class="col-md-7 col-sm-6 col-4 text-light pl-4">
             <div class="row" style="height: 100%;">
               <div class="col-4 my-auto">
              <div onclick="openNav()">
                   <h5 style="margin-bottom: 0;">☰</h5>
              </div>
        </div>
              <div class="col-8 p-0 my-auto">
                <a class="d-block ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px " >
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px " >
                        @endif
                </a>
              </div>
             </div>
          </div>
          <div class="col-md-5 col-sm-6 col-8 pl-0 pr-4 my-auto">
            <div style="width: 100%;" class="row ml-0">
                <div class="col-3 text-light text-center p-2 ps-0 my-auto">
                  <!-- <div class="">
                    <p class=" m-0">
                      <img src="https://24sadar.com/public/uploads/all/indian-flag.jpg" alt="Indian Flag" class="mw-100 h-30px " >
                    </p>
                  </div> -->
                </div>
                <div class="col-3 p-0 text-light my-auto">
                  <div class="" id="compare">
                        @include('frontend.partials.myaccount')
                    </div>
                </div>
                <div class="col-3 text-light   my-auto">
                  <div class="" id="wishlist">
                        @include('frontend.partials.becameaseller')
                    </div>
                </div>
                <div class="col-3 text-light mt-2 my-auto">
                  <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>
              </div>
        </div>
      </div>
	  </div>
  </nav>
  <nav class="navbar navbar-expand-lg navbar-dark d-lg-none" style="color:whitesmoke;background-color: #131921;">
      <div class="w-100">
      <div class="row ">
        <div class="col-12 ps-4 pe-4">
          <div class="input-group">
            <form action="{{ route('search') }}" method="GET" class="stop-propagation" style="width:100%;">
				<div class="d-flex position-relative align-items-center">
					<div class="d-none" data-toggle="class-toggle" data-bs-target=".front-header-search">
						<button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
					</div>
					<div class="input-group">
						<input type="text" class="form-control" id="search" name="keyword" @isset($query)
							value="{{ $query }}"
						@endisset placeholder="{{translate('I am shopping for...')}}" style="border-radius: 0;border-end-start-radius: 5px;border-start-start-radius: 5px;" autocomplete="off">
						<button id="basic-addon1" type="submit" class=" input-group-text btn-primary" style="border-radius: 0;border-end-end-radius: 5px;border-start-end-radius: 5px;"><i class="fas fa-search"></i></button>
						
					</div>
				</div>
			</form>
			<div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
				<div class="search-preloader absolute-top-center">
					<div class="dot-loader"><div></div><div></div><div></div></div>
				</div>
				<div class="search-nothing d-none p-3 text-center fs-16">

				</div>
				<div id="search-content" class="text-left">

				</div>
			</div>
          </div>
        </div>
      </div>
	  </div>
    </nav>
<!--<div class="container-fluid p-0 d-lg-none">
  <div class="row"  style="color:whitesmoke;">
     <div class="col-12 ps-4 pe-4 p-1 text-center" style="background-color: #232F3E;">
      <i class="fas fa-map-marker-alt"></i> <span> <small> Select a location to see product availability</small></span>
     </div>
  </div>
</div> -->



<style>
  
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Arial";
}

body{
  overflow-x: hidden;
}

#whole-flex {
  position: absolute;
  flex-direction: column;
  text-align: center;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: -10;
}

/* NavBar */
.sidenav {
  max-width: 380px;
  width: 85%;
  overflow-x: hidden;
  overflow-y: hidden;
  height: 100%;
  position: fixed;
  z-index: 100;
  top: 0;
  left: 0;
  background-color: white;
  transform-origin: left center;
  transform: translateX(-380px);
}

.sidenavHeader {
  color: white;
  font-weight: bold;
  background-color: rgb(35, 47, 62);
  padding: 10px 0px 10px 30px;
  font-size: 23px;
}

.sidenavContentHeader {
  margin-top: 5px;
  padding: 15px 0px 15px 25px;
  font-size: 20px;
  font-weight: bold;
}

.sidenavContent {
  padding: 15px 0px 15px 25px;
}

.sidenavContent:hover {
  background-color: #eaeded;
}

hr {
  height: 1px;
  border: 0;
  color: gray;
  background-color: gray;
  margin: 15px auto 10px auto;
}

.sidenavRow {
  display: flex;
  width: 100%;
  justify-content: space-between;
  padding: 15px 25px 15px 25px;
}

.sidenavRow:hover {
  background-color: #eaeded;
}

.sidenavRow:hover i {
  color: #111111 !important;
}

#closeBtn {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-left: 390px;
  color: white;
  font-size: 50px;
  cursor: pointer;
  z-index: 9999;
  transform: translateY(-5px);
  transition: visibility 0.5s;
}

a,
a:link,
a:visited,
a:hover,
a:active {
  text-decoration: none;
  
}

/* animation */
@keyframes collapse {
  0% {
    z-index: 100;
    transform: translateX(0px);
  }
  100% {
    transform: translateX(-380px);
  }
}

@keyframes expand {
  0% {
    z-index: 100;
    transform: translateX(-380px);
  }
  100% {
    transform: translateX(0px);
  }
}

@keyframes show {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@keyframes hide {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

/* Overlay */
#overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 50;
  background-color: rgba(0, 0, 0, 0.7);
}

/* Dropdown */
.sidenavContainer hr {
  width: 85%;
}

.sidenavRowDropdown {
  display: flex;
  width: 100%;
  justify-content: start;
  align-items: center;
  padding: 15px 25px 15px 25px;
  cursor: pointer;
}

.sidenavRowDropdown:hover {
  background-color: #eaeded;
}

.sidenavRowDropdown:hover i {
  color: #111111 !important;
}

.sidenavContainer {
  display: none;
  height: 0px;
  opacity: 0;
  transform: scaleY(0);
  transform-origin: center top;
}

@keyframes expandDropDown {
  0% {
    transform: scaleY(0);
    opacity: 0;
  }
  100% {
    transform: scaleY(1);
    opacity: 1;
  }
}

@keyframes collapseDropDown {
  0% {
    transform: scaleY(1);
    opacity: 1;
  }
  100% {
    transform: scaleY(0);
    opacity: 0;
  }
}

/* Container part */
#main-container {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow-y: scroll;
}

@keyframes mainAway {
  0% {
    transform: translateX(0px);
  }
  100% {
    transform: translateX(-380px);
  }
}

@keyframes mainBack {
  0% {
    transform: translateX(-380px);
  }
  100% {
    transform: translateX(0px);
  }
}

#sub-container {
  position: absolute;
  width: 100%;
  height: 100%;
  overflow-y: scroll;
  background-color: white;
  transform: translateX(380px);
}

@keyframes subBack {
  0% {
    transform: translateX(380px);
  }
  100% {
    transform: translateX(0px);
  }
}

@keyframes subPush {
  0% {
    transform: translateX(0px);
  }
  100% {
    transform: translateX(380px);
  }
}

#mainMenu {
  margin-top: 5px;
  padding: 15px 0px 15px 25px;
  font-weight: bold;
}

#mainMenu:hover {
  background-color: #eaeded;
  cursor: pointer;
}
@media screen and (max-width: 450px) {
  #closeBtn {
	  margin-left: 90%;
	}
}

</style>




  <div id="overlay" onclick="closeNav()"></div>

  <div id="closeBtn" onclick="closeNav()">&times;</div>
  <div class="sidenav" id="mySidenav" style="z-index: 1111;">
  
	@include('frontend.partials.category_menu')
	
  </div>






	

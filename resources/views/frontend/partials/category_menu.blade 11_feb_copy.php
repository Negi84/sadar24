<div class="sidenavHeader">
    {{ translate('Categories') }}
    <a href="{{ route('categories.all') }}" class="text-reset pr-2" style="float: right;">
        <span class="d-none d-lg-inline-block">{{ translate('See All') }} ></span>
    </a>
</div>
<!--Below SideNavHeader-->
<div id="main-container">
    @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11)
    as $key => $category)
        <div class="sidenavContentHeader"><a href="{{ route('products.category', $category->slug) }}"
                class="text-truncate text-reset d-block">
                <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                    data-src="{{ uploaded_asset($category->icon) }}" width="16"
                    alt="{{ $category->getTranslation('name') }}"
                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                <span class="cat-name">{{ $category->getTranslation('name') }}</span>
            </a>
        </div>
        <a href="#" onclick="function_{{ $category->id }}()">
            <div class="sidenavRow " data-id="{{ $category->id }}">
                <div>See More</div>
                <i class="fas fa-chevron-right" style="color: #8e9090"></i>
            </div>
        </a>
        @if (count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id)) > 0)
            <script>
                function function_{{ $category->id }}() {
                    document.getElementById("sub-container-content").innerHTML = '' +

                        '<div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4"><div class="c-preloader text-center absolute-center"><i class="las la-spinner la-spin la-3x opacity-70"></i></div></div>';
                }
            </script>
        @endif
        <hr />
    @endforeach
    <div class="sidenavContentHeader"><a href="https://24sadar.com/category/books"
            class="text-truncate text-reset d-block" style="visibility:hidden">
            <img class="cat-image mr-2 opacity-60 ls-is-cached lazyloaded"
                src="https://24sadar.com/public/assets/img/placeholder.jpg" data-src="" alt="Books"
                onerror="this.onerror=null;this.src='https://24sadar.com/public/assets/img/placeholder.jpg';"
                width="16">
            <span class="cat-name">Books</span>
        </a>
    </div>
    <a href="#" style="visibility:hidden">

    </a>

</div>
<!--End of first container-->

<div id="sub-container">
    <div id="mainMenu">
        <i class="fas fa-chevron-left" style="color: #8e9090"></i> MAIN MENU
    </div>
    <hr />
    <div id="sub-container-content" class="p-3">
        <!-- <div class="sidenavContentHeader">Prime Video</div>
        <a href="#"><div class="sidenavContent">All Videos</div></a> -->
    </div>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.animation = "expand 0.3s forwards";
        //closeBtn
        document.getElementById("closeBtn").style.display = "block";
        document.getElementById("closeBtn").style.animation = "show 0.3s";
        //Overlay
        document.getElementById("overlay").style.display = "block";
        document.getElementById("overlay").style.animation = "show 0.3s";

    }

    function closeNav() {
        document.getElementById("mySidenav").style.animation = "collapse 0.3s forwards";
        //closeBtn
        document.getElementById("closeBtn").style.animation = "hide 0.3s";
        //Overlay
        document.getElementById("overlay").style.animation = "hide 0.3s";

        setTimeout(() => {
            document.getElementById("closeBtn").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            //Reset Menus
            document.getElementById("main-container").style.animation = "";
            document.getElementById("main-container").style.transform = "translateX(0px)";
            document.getElementById("sub-container").style.animation = "";
            document.getElementById("sub-container").style.transform = "translateX(380px)";
        }, 300)
    }

    let firstDropdownOpen = false;

    function firstDropDown() {
        firstDropdownOpen = !firstDropdownOpen;
        if (firstDropdownOpen) {
            document.querySelector("#firstDropDown i").setAttribute("class", "fas fa-chevron-up");
            document.querySelector("#firstDropDown div").innerHTML = "See Less";
            //Handle Container
            document.getElementById("firstContainer").style.display = "block";
            document.getElementById("firstContainer").style.animation = "expandDropDown 0.3s forwards";
            document.getElementById("firstContainer").style.transition = "height 0.3s";
            document.getElementById("firstContainer").style.height = "410px";
        } else {
            document.querySelector("#firstDropDown i").setAttribute("class", "fas fa-chevron-down");
            document.querySelector("#firstDropDown div").innerHTML = "See More";
            //Handle Container
            document.getElementById("firstContainer").style.animation = "collapseDropDown 0.2s forwards";
            document.getElementById("firstContainer").style.transition = "height 0.2s";
            document.getElementById("firstContainer").style.height = "0px";
            setTimeout(() => {
                document.getElementById("firstContainer").style.display = "none";
            }, 200)

        }
    }

    let secondDropDownOpen = false;

    function secondDropDown() {
        secondDropDownOpen = !secondDropDownOpen;

        if (secondDropDownOpen) {
            document.querySelector("#secondDropDown i").setAttribute("class", "fas fa-chevron-up");
            document.querySelector("#secondDropDown div").innerHTML = "See Less";
            //Handle Container
            document.getElementById("secondContainer").style.display = "block";
            document.getElementById("secondContainer").style.animation = "expandDropDown 0.3s forwards";
            document.getElementById("secondContainer").style.transition = "height 0.3s";
            document.getElementById("secondContainer").style.height = "260px";
        } else {
            document.querySelector("#secondDropDown i").setAttribute("class", "fas fa-chevron-down");
            document.querySelector("#secondDropDown div").innerHTML = "See More";
            //Handle Container
            document.getElementById("secondContainer").style.animation = "collapseDropDown 0.2s forwards";
            document.getElementById("secondContainer").style.transition = "height 0.2s";
            document.getElementById("secondContainer").style.height = "0px";
            setTimeout(() => {
                document.getElementById("secondContainer").style.display = "none";
            }, 200)

        }
    }

    document.querySelectorAll(".sidenavRow").forEach(row => {
        row.addEventListener("click", () => {
            document.getElementById("main-container").style.animation = "mainAway 0.3s forwards";
            document.getElementById("sub-container").style.animation = "subBack 0.3s forwards";
        });
    });

    document.getElementById("mainMenu").addEventListener("click", () => {
        document.getElementById("main-container").style.animation = "mainBack 0.3s forwards";
        document.getElementById("sub-container").style.animation = "subPush 0.3s forwards";
    })

    //subNavContent

    function openPrimeVideo() {
        document.getElementById("sub-container-content").innerHTML =
            '<div class="sidenavContentHeader">Prime Video</div>' +
            '<a href="#"><div class="sidenavContent">All Videos</div></a>';
    }

    function openAmazonMusic() {
        document.getElementById("sub-container-content").innerHTML =
            '<div class="sidenavContentHeader">Amazon Music</div>' +
            '<a href="#"><div class="sidenavContent">All Music</div></a>';
    }
</script>

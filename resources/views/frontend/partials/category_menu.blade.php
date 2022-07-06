<style>
    /* Custom style */
    /* .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
        transform: scale(.7) !important;
    }

    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='%23333' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' d='M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z' clip-rule='evenodd'/%3e%3c/svg%3e");
    } */

    .accordion-body {
        padding: 0rem;
    }

    .accordion-item {
        border-top: 0.25rem;
        border-bottom: 0.25rem;
        border-right: 0.25rem;
        border-left: 0.25rem;
    }

    .accordion-header {
        border-bottom: 0.25px solid #e7e7e7;
        /* border-top: 0.25px solid #e7e7e7; */
    }

    .res-but {
        border: 0px solid !important;
        outline: 0 !important;
        box-shadow: none !important;
        background-color: white;
    }

    .res-but:hover,
    .res-but:active {
        border: 0px solid !important;
        outline: 0 !important;
        box-shadow: none !important;
        background-color: #bcccff;
        /* color:#e62e04; */
    }
    .li-hov-ef:hover{
        font-size:16px;
        font-weight:500;

    }
</style>
@php
function recursive_array_search($needle, $haystack)
{
 
    foreach ($haystack as $key => $value) {       
        $current_key = $key;
        if ($needle === $value->id) {
            // print_r()
            return true;
        }
        else{
            return false;
        }
    }
    // return false;
}
@endphp
<div class="sidenavHeader">
    {{ translate('Categories') }}
    <a href="{{ route('categories.all') }}" class="text-reset pr-2" style="float: right;">
        <span class="d-none d-lg-inline-block">{{ translate('See All') }} ></span>
    </a>
</div>
{{-- New Side Nav --}}
<div id="main-container" class="container-fluid mx-0 px-0">
    <div class="row mx-0 px-0">
        <div class="col-12 mx-0 px-0">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                @php
                    $no = 1;
                    $categories = DB::table('categories')->where('level', '=', 0)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                    $sub_categories = DB::table('categories')->where('level', '=', 1)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                    $sub_sub_categories = DB::table('categories')->where('level', '=', 2)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                @endphp
                @foreach ($categories as $category)
                    <div class="accordion-item">
                        <h5 class="accordion-header row w-100" id="{{ $category->slug }}">
                            <a href="{{ route('products.category', $category->slug) }}" style="color: rgb(0, 0, 0);"
                                class="category-name col align-self-center li-hov-ef">{{ $category->name }}</a>
                            {{-- @if (!recursive_array_search($category->id,$sub_categories)) --}}
                                <button class="accordion-button collapsed col-auto w-auto float-right res-but"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $category->slug }}-{{ $category->id }}"
                                    aria-expanded="false"
                                    aria-controls="{{ $category->slug }}-{{ $category->id }}"></button>
                            {{-- @endif --}}

                        </h5>
                        <div id="{{ $category->slug }}-{{ $category->id }}" class="accordion-collapse collapse"
                            aria-labelledby="{{ $category->slug }}">
                            @foreach ($sub_categories as $sub_cat)
                                @if ($sub_cat->parent_id === $category->id)
                                    <div class="accordion-body">
                                        <div class="accordion" id="accordionPanelsStayOpenExample">
                                            <div class="accordion-item">
                                                <h5 class="accordion-header row w-100" id="{{ $sub_cat->slug }}"
                                                    style="padding-left: 15px;">
                                                    <a href="{{ route('products.category', $sub_cat->slug) }}"
                                                        style="color: rgb(0, 0, 0); "
                                                        class="category-name col align-self-center li-hov-ef">{{ $sub_cat->name }}</a>
                                                    {{-- @if (recursive_array_search($sub_cat->id,$sub_sub_categories)) --}}
                                                        <button
                                                            class="accordion-button collapsed  col-auto w-auto float-right res-but"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#{{ $sub_cat->slug }}-{{ $sub_cat->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="{{ $sub_cat->slug }}-{{ $sub_cat->id }}">
                                                        </button>
                                                    {{-- @endif --}}
                                                </h5>
                                                <div id="{{ $sub_cat->slug }}-{{ $sub_cat->id }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="{{ $sub_cat->slug }}">
                                                    @foreach ($sub_sub_categories as $sub_sub_cat)
                                                        @if ($sub_sub_cat->parent_id === $sub_cat->id)
                                                            <div class="accordion-body">
                                                                <h5 class="accordion-header row w-100 py-3"
                                                                    id="{{ $sub_sub_cat->slug }}"
                                                                    style="padding-left: 15px;">
                                                                    <a href="{{ route('products.category', $sub_sub_cat->slug) }}"
                                                                        style="color: rgb(0, 0, 0);"
                                                                        class="category-name col align-self-center li-hov-ef pl-4">{{ $sub_sub_cat->name }}</a>
                                                                </h5>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
                {{-- {{ dump($categories) }} --}}
            </div>
        </div>
    </div>
</div>
{{-- New Side Nav --}}
<!--Below SideNavHeader-->
{{-- <div id="main-container">
    @foreach (\App\Category::where('level', 0)->orderBy('order_level', 'ASC')->get()->take(11)
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

</div> --}}
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

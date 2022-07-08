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
<?php
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
?>
<div class="sidenavHeader">
    <?php echo e(translate('Categories')); ?>

    <a href="<?php echo e(route('categories.all')); ?>" class="text-reset pr-2" style="float: right;">
        <span class="d-none d-lg-inline-block"><?php echo e(translate('See All')); ?> ></span>
    </a>
</div>

<div id="main-container" class="container-fluid mx-0 px-0">
    <div class="row mx-0 px-0">
        <div class="col-12 mx-0 px-0">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <?php
                    $no = 1;
                    $categories = DB::table('categories')->where('level', '=', 0)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                    $sub_categories = DB::table('categories')->where('level', '=', 1)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                    $sub_sub_categories = DB::table('categories')->where('level', '=', 2)->select('name','parent_id','level','id','slug')->orderBy('order_level','ASC')->get();
                ?>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h5 class="accordion-header row w-100" id="<?php echo e($category->slug); ?>">
                            <a href="<?php echo e(route('products.category', $category->slug)); ?>" style="color: rgb(0, 0, 0);"
                                class="category-name col align-self-center li-hov-ef"><?php echo e($category->name); ?></a>
                            
                                <button class="accordion-button collapsed col-auto w-auto float-right res-but"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#<?php echo e($category->slug); ?>-<?php echo e($category->id); ?>"
                                    aria-expanded="false"
                                    aria-controls="<?php echo e($category->slug); ?>-<?php echo e($category->id); ?>"></button>
                            

                        </h5>
                        <div id="<?php echo e($category->slug); ?>-<?php echo e($category->id); ?>" class="accordion-collapse collapse"
                            aria-labelledby="<?php echo e($category->slug); ?>">
                            <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($sub_cat->parent_id === $category->id): ?>
                                    <div class="accordion-body">
                                        <div class="accordion" id="accordionPanelsStayOpenExample">
                                            <div class="accordion-item">
                                                <h5 class="accordion-header row w-100" id="<?php echo e($sub_cat->slug); ?>"
                                                    style="padding-left: 15px;">
                                                    <a href="<?php echo e(route('products.category', $sub_cat->slug)); ?>"
                                                        style="color: rgb(0, 0, 0); "
                                                        class="category-name col align-self-center li-hov-ef"><?php echo e($sub_cat->name); ?></a>
                                                    
                                                        <button
                                                            class="accordion-button collapsed  col-auto w-auto float-right res-but"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#<?php echo e($sub_cat->slug); ?>-<?php echo e($sub_cat->id); ?>"
                                                            aria-expanded="false"
                                                            aria-controls="<?php echo e($sub_cat->slug); ?>-<?php echo e($sub_cat->id); ?>">
                                                        </button>
                                                    
                                                </h5>
                                                <div id="<?php echo e($sub_cat->slug); ?>-<?php echo e($sub_cat->id); ?>"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="<?php echo e($sub_cat->slug); ?>">
                                                    <?php $__currentLoopData = $sub_sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_sub_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($sub_sub_cat->parent_id === $sub_cat->id): ?>
                                                            <div class="accordion-body">
                                                                <h5 class="accordion-header row w-100 py-3"
                                                                    id="<?php echo e($sub_sub_cat->slug); ?>"
                                                                    style="padding-left: 15px;">
                                                                    <a href="<?php echo e(route('products.category', $sub_sub_cat->slug)); ?>"
                                                                        style="color: rgb(0, 0, 0);"
                                                                        class="category-name col align-self-center li-hov-ef pl-4"><?php echo e($sub_sub_cat->name); ?></a>
                                                                </h5>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </div>
    </div>
</div>

<!--Below SideNavHeader-->

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
<?php /**PATH C:\xampp\htdocs\sadar24\resources\views/frontend/partials/category_menu.blade.php ENDPATH**/ ?>
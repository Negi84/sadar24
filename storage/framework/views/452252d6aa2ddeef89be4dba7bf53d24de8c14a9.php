<?php if(auth::check()): ?>
<a class="d-flex align-items-center text-reset border-md-right pr-3 border-left-0">
    
    <?php
        $user = auth::user();
    ?>
    <span class="flex-grow-1 ml-1">      
        <span class="nav-box-text d-block d-xl-block d-md-none"><?php echo e($user->name); ?></span>
    </span>
</a>
<?php else: ?>
<a href="<?php echo e(route('shops.create')); ?>" class="d-flex align-items-center text-reset border-md-right pr-3 border-left-0">
    <i class="las la-truck-loading la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">      
        <span class="nav-box-text d-block d-xl-block d-md-none"><?php echo e(translate('Sell on Sadar24')); ?></span>
    </span>
</a>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sadar24\resources\views/frontend/partials/becameaseller.blade.php ENDPATH**/ ?>
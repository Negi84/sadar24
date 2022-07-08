				<ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(isAdmin()): ?>
                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-reset d-inline-block py-2"><?php echo e(translate('My Panel')); ?></a>
                            </li>
                        <?php else: ?>

                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0 dropdown">
                                <a class="dropdown-toggle no-arrow text-reset" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="">
                                        <span class="position-relative d-inline-block">
                                            <i class="las la-bell fs-18"></i>
                                            <?php if(count(Auth::user()->unreadNotifications) > 0): ?>
                                                <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                            <?php endif; ?>
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                    <div class="p-3 bg-light border-bottom">
                                        <h6 class="mb-0"><?php echo e(translate('Notifications')); ?></h6>
                                    </div>
                                    <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                        <ul class="list-group list-group-flush" >
                                            <?php $__empty_1 = true; $__currentLoopData = Auth::user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <li class="list-group-item">
                                                    <?php if($notification->type == 'App\Notifications\OrderNotification'): ?>
                                                        <?php if(Auth::user()->user_type == 'customer'): ?>
                                                        <a href="javascript:void(0)" onclick="show_purchase_history_details(<?php echo e($notification->data['order_id']); ?>)" class="text-reset">
                                                            <span class="ml-2">
                                                                <?php echo e(translate('Order code: ')); ?> <?php echo e($notification->data['order_code']); ?> <?php echo e(translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))); ?>

                                                            </span>
                                                        </a>
                                                        <?php elseif(Auth::user()->user_type == 'seller'): ?>
                                                            <?php if(Auth::user()->id == $notification->data['user_id']): ?>
                                                                <a href="javascript:void(0)" onclick="show_purchase_history_details(<?php echo e($notification->data['order_id']); ?>)" class="text-reset">
                                                                    <span class="ml-2">
                                                                        <?php echo e(translate('Order code: ')); ?> <?php echo e($notification->data['order_code']); ?> <?php echo e(translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))); ?>

                                                                    </span>
                                                                </a>
                                                            <?php else: ?>
                                                                <a href="javascript:void(0)" onclick="show_order_details(<?php echo e($notification->data['order_id']); ?>)" class="text-reset">
                                                                    <span class="ml-2">
                                                                        <?php echo e(translate('Order code: ')); ?> <?php echo e($notification->data['order_code']); ?> <?php echo e(translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))); ?>

                                                                    </span>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <li class="list-group-item">
                                                    <div class="py-4 text-center fs-16">
                                                        <?php echo e(translate('No notification found')); ?>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="text-center border-top">
                                        <a href="<?php echo e(route('all-notifications')); ?>" class="text-reset d-block py-2">
                                            <?php echo e(translate('View All Notifications')); ?>

                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="<?php echo e(route('dashboard')); ?>" class="text-reset d-inline-block py-2"><?php echo e(translate('My Panel')); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('logout')); ?>" class="text-reset d-inline-block py-2"><?php echo e(translate('Logout')); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="list-inline-item border-right border-left-0 pr-3 pl-0">
                          <a href="<?php echo e(route('user.otplogin')); ?>" class="d-flex align-items-center text-reset">
								<i class="la la-user la-2x opacity-80"></i>
								<span class="flex-grow-1 ml-1">      
									<span class="nav-box-text d-none d-xl-block"><?php echo e(translate('Profile')); ?></span>
								</span>
							</a>
                        </li>                       
                    <?php endif; ?>
                </ul>
            <?php /**PATH C:\xampp\htdocs\sadar24\resources\views/frontend/partials/myaccount.blade.php ENDPATH**/ ?>
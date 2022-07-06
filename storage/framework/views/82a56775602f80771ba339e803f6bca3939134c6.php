<?php $__env->startSection('content'); ?>
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                        <div class="card">
                            <div class="text-center pt-4">
                                <h1 class="h4 fw-600">
                                    <?php echo e(translate('Enter OTP Number to Login.')); ?>

                                </h1>
                            </div>

                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form class="form-default" role="form" action="<?php echo e(route('user.otp')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        
                                            <div class="form-group phone-form-group mb-1">
                                                
												<input id="phone" type="hidden" class="form-control" name="phone" value="<?php echo e($phone); ?>" required autofocus>
												<input id="session_id" type="hidden" class="form-control" name="session_id" value="<?php echo e($session_id); ?>" required autofocus>
												<input id="otp" type="text" class="form-control" name="otp" value="<?php echo e(old('otp')); ?>" placeholder="Enter OTP Number" required autofocus>
												<?php if(session('errors')): ?>
												<div class="alert alert-error">
													<p><?php echo e(session('errors')); ?></p>
												</div>
												<?php endif; ?>
                                            </div>

                                            

                                        <div class="mb-5">
                                            <button type="submit" class="btn btn-primary btn-block fw-600"><?php echo e(translate('Submit')); ?></button>
                                        </div>
                                    </form>

                                    <?php if(env("DEMO_MODE") == "On"): ?>
                                        <div class="mb-5">
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo e(translate('Seller Account')); ?></td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm" onclick="autoFillSeller()"><?php echo e(translate('Copy credentials')); ?></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo e(translate('Customer Account')); ?></td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm" onclick="autoFillCustomer()"><?php echo e(translate('Copy credentials')); ?></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo e(translate('Delivery Boy Account')); ?></td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm" onclick="autoFillDeliveryBoy()"><?php echo e(translate('Copy credentials')); ?></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1): ?>
                                        <div class="separator mb-3">
                                            <span class="bg-white px-3 opacity-60"><?php echo e(translate('Or Login With')); ?></span>
                                        </div>
                                        <ul class="list-inline social colored text-center mb-5">
                                            <?php if(get_setting('facebook_login') == 1): ?>
                                                <li class="list-inline-item">
                                                    <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>" class="facebook">
                                                        <i class="lab la-facebook-f"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(get_setting('google_login') == 1): ?>
                                                <li class="list-inline-item">
                                                    <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>" class="google">
                                                        <i class="lab la-google"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(get_setting('twitter_login') == 1): ?>
                                                <li class="list-inline-item">
                                                    <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>" class="twitter">
                                                        <i class="lab la-twitter"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center">
                                    <p class="text-muted mb-0"><?php echo e(translate('Dont have an account?')); ?></p>
                                    <a href="<?php echo e(route('user.registration')); ?>"><?php echo e(translate('Register Now')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/frontend/otp.blade.php ENDPATH**/ ?>
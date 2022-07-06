<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6"><?php echo e(translate('Edit Seller Information')); ?></h5>
</div>


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><?php echo e(translate('Seller Information')); ?></h5>
        </div>
        <div class="card-body">
             <form action="<?php echo e(route('sellers.update', $seller->id)); ?>" method="POST">
                <input name="_method" type="hidden" value="PATCH">
            	<?php echo csrf_field(); ?>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-from-label" for="name"><?php echo e(translate('Name')); ?> <span class="text-danger">*</span></label>							
							<input type="text" placeholder="<?php echo e(translate('Name')); ?>" id="name" name="name" class="form-control" value="<?php echo e($seller->user->name); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-from-label" for="email"><?php echo e(translate('Email Address')); ?> <span class="text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Email Address')); ?>" id="email" name="email" value="<?php echo e($seller->user->email); ?>" class="form-control" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-from-label" for="phone"><?php echo e(translate('Phone')); ?> <span class="text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Phone')); ?>" id="phone" name="phone" value="<?php echo e($seller->user->phone); ?>" class="form-control" required>
						</div>
					</div>					
				</div>	
				<h5 class="pt-3 h6"><?php echo e(translate('Company Information')); ?></h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Company Name')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Company Name')); ?>" id="company" class="form-control" name="company" value="<?php echo e($seller->user->shop->name); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Types of business')); ?> <span class="text-danger text-danger">*</span></label>
							<select id="types_of_business" class="form-control" name="types_of_business" required>
								<option value="">Select Your Account Type</option>
								<option value="Sole Proprietorship">Sole Proprietorship</option>
								<option value="Partnership">Partnership</option>
								<option value="LLP">LLP</option>
								<option value="Private Limited">Private Limited</option>
							</select>							
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('GST Number')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('GST Number')); ?>" id="gst_number" class="form-control" name="gst_number" value="<?php echo e($seller->user->shop->gst_number); ?>" required>
						</div>
					</div>
					
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('PAN Card Number')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('PAN Card Number')); ?>" id="pan_number" class="form-control" name="pan_number" value="<?php echo e($seller->user->shop->pan_number); ?>" required>
						</div>
					</div>
				</div>
				
				
				<h5 class="pt-3 h6"><?php echo e(translate('Company Address')); ?></h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Address')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Address')); ?>" id="address" class="form-control mb-3" name="address" value="<?php echo e($seller->user->shop->address); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('State')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('State')); ?>" id="state" class="form-control mb-3" name="state" value="<?php echo e($seller->user->shop->state); ?>" required>
						</div>
					</div>
					
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('City')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('City')); ?>" id="city" class="form-control mb-3" name="city" value="<?php echo e($seller->user->shop->city); ?>" required>
						</div>
					</div>
					
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Pincode')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('pincode')); ?>" id="postal_code" class="form-control mb-3" name="postal_code" value="<?php echo e($seller->user->shop->postal_code); ?>" required>
						</div>
					</div>						
				</div>
				
				<h5 class="pt-3 h6"><?php echo e(translate('Bank Information')); ?></h5>
				<hr>
				<br/>				
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label"><?php echo e(translate('bank_name')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('bank_name')); ?>" id="bank_name" class="form-control" name="bank_name" value="<?php echo e($seller->user->seller->bank_name); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('bank_acc_name')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('bank_acc_name')); ?>" id="bank_acc_name" class="form-control" name="bank_acc_name" value="<?php echo e($seller->user->seller->bank_acc_name); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Bank Account number')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Bank Account number')); ?>" id="bank_acc_no" class="form-control mb-3" name="bank_acc_no" value="<?php echo e($seller->user->seller->bank_acc_no); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Account Type')); ?> <span class="text-danger text-danger">*</span></label>
							<select id="account_type" class="form-control" name="account_type" required>
								<option value="">Select Your Account Type</option>
								<option value="Savings">Savings</option>
								<option value="Current">Current</option>
							</select>							
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('IFSC Code')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('IFSC Code')); ?>" id="ifsc_code" class="form-control" name="ifsc_code" value="<?php echo e($seller->user->seller->ifsc_code); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
							<label class="col-form-label"><?php echo e(translate('Branch')); ?> <span class="text-danger text-danger">*</span></label>
							<input type="text" placeholder="<?php echo e(translate('Branch')); ?>" id="branch" class="form-control mb-3" name="branch" value="<?php echo e($seller->user->seller->branch); ?>" required>
						</div>
					</div>						
				</div>				
				
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary"><?php echo e(translate('Save')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sadar24_aws/resources/views/backend/sellers/edit.blade.php ENDPATH**/ ?>
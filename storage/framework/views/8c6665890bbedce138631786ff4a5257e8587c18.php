<!-- delete Modal -->
<div id="cancel-modal" class="modal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6"><?php echo e(translate('Order Cancel Confirmation')); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1"><?php echo e(translate('Are you sure to cancel this Order?')); ?></p>
                <button type="button" class="btn btn-link mt-2" data-bs-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                <a href="" id="cancel-link" class="btn btn-primary mt-2"><?php echo e(translate('Cancel')); ?></a>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<?php /**PATH /var/www/sadar24_aws/resources/views/modals/cancel_modal.blade.php ENDPATH**/ ?>
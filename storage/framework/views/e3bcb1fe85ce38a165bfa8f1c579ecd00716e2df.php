<!-- delete Modal -->
<div id="delete-modal" class="modal">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6"><?php echo e(translate('Delete Confirmation')); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1"><?php echo e(translate('Are you sure to delete this?')); ?></p>
                <button type="button" class="btn btn-link mt-2" data-bs-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                <a href="" id="delete-link" class="btn btn-primary mt-2"><?php echo e(translate('Delete')); ?></a>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<?php /**PATH /var/www/sadar24_aws/resources/views/modals/delete_modal.blade.php ENDPATH**/ ?>
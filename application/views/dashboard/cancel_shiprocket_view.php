<div class="modal-body">
    <div class="row tracking-number-container">
        <div class="col-sm-12">


            <div class="form-group">
                <?php if (!empty($cancel_response)) : ?>
                    <p><?php echo $cancel_response ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-md btn-default" onClick="window.location.reload();" data-dismiss="modal"><?php echo trans("close"); ?></button>
</div>
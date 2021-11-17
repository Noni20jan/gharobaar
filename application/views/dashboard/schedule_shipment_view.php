<?php if ($pickup_location_matched != 0) : ?>

    <div class="modal-header">
        <!-- <?php echo json_encode($products); ?> -->
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true"><i class="icon-close"></i> </span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row tracking-number-container">
            <div class="col-sm-12">


                <div class="form-group">
                    You can not schedule selected products for shipment together as their pickup location is different.
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>

    </div>
<?php elseif ($delivery_partner_matched > 0) : ?>
    <div class="modal-header">
        <!-- <?php echo json_encode($products); ?> -->
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true"><i class="icon-close"></i> </span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row tracking-number-container">
            <div class="col-sm-12">


                <div class="form-group">
                    You can not schedule selected products for shipment because both products delivery partners are different.
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>

    </div>
<?php elseif ($pickup_location_matched == 0 && $delivery_partner_matched == 0) : ?>

    <?php if ($order_items[0]->product_delivery_partner == "SHIPROCKET") : ?>
        <div class="modal-header">
            <h5 class="modal-title">Update Dimensions of Product</h5>
            <p>The given dimensions and weight is approx.Please make sure thet you will put the actual dimenstions of your package after packaging of selected items</p>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true"><i class="icon-close"></i> </span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row tracking-number-container">
                <div class="col-sm-12">


                    <div class="form-group">

                        <label class="control-label">Total Length(cm)</label>
                        <input type="text" class="form-control" id="total_length" required name="total_length" value="<?php echo $total_length; ?>" />

                    </div>
                    <div class="form-group">

                        <label class="control-label">Total Height(cm)</label>
                        <input type="text" class="form-control" id="total_height" required name="total_height" value="<?php echo $total_height; ?>" />

                    </div>
                    <div class="form-group">

                        <label class="control-label">Total Width(cm)</label>
                        <input type="text" class="form-control" id="total_width" required name="total_width" value="<?php echo $total_width; ?>" />

                    </div>
                    <div class="form-group">

                        <label class="control-label">Total Weight(grams)</label>
                        <input type="text" class="form-control" id="total_weight" required name="total_weight" value="<?php echo $total_weight; ?>" />

                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>

            <button type="button" onclick="wrapper_multiple_product(<?php echo htmlspecialchars(json_encode($products), ENT_QUOTES); ?>,<?php echo htmlspecialchars(json_encode($order_items), ENT_QUOTES); ?>);" class="btn btn-md btn-primary">Update</button>
        </div>
    <?php elseif ($order_items[0]->product_delivery_partner == "NOW-BIKES") : ?>
        <div class="modal-header">
            <h5 class="modal-title">Are you sure you want to continue?</h5>
            <p></p>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true"><i class="icon-close"></i> </span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row tracking-number-container">
                <div class="col-sm-12">

                    <div class="form-group">

                        <label class="control-label">Total price</label>
                        <input type="text" class="form-control" id="total_sell_price" readonly required name="total__sell_price" value="<?php echo $sale_total_price; ?>" />

                    </div>


                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>

            <button type="button" onclick="nowBike_multiple_create_order(<?php echo htmlspecialchars(json_encode($order_items), ENT_QUOTES); ?>,<?php echo $sale_total_price; ?>);" class="btn btn-md btn-primary">Schedule</button>
        </div>
    <?php elseif ($order_items[0]->product_delivery_partner == "SELF") : ?>
        <?php echo form_open_multipart('add-shipping-tracking-number-post'); ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars(json_encode($item_ids), ENT_QUOTES); ?>">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo trans("add_shipping_tracking_number"); ?></h5>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true"><i class="icon-close"></i> </span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row tracking-number-container">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?= trans("tracking_number"); ?></label>
                        <input type="text" name="shipping_tracking_number" class="form-control form-input" placeholder="<?= trans("tracking_number"); ?>">
                    </div>
                    <div class="form-group">
                        <label>Courier Service</label>
                        <input type="text" name="courier_service" class="form-control form-input" placeholder="Courier Service Name">
                    </div>
                    <div class="form-group">
                        <label><?= trans("url"); ?></label>
                        <input type="text" name="shipping_tracking_url" class="form-control form-input" placeholder="<?= trans("url"); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
            <button type="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
        </div>
        <?php echo form_close(); ?>
    <?php endif; ?>
<?php endif; ?>
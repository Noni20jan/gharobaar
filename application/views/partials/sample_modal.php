<?php defined('BASEPATH') or exit('No direct script access allowed');
$products_available=get_user_barter_products($user->id);
var_dump($products_available);
?>
<!-- Send Message Modal -->

<?php if ($this->auth_check) : ?>
    <div class="modal fade" id="sampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-send-message" role="document">
            <div class="modal-content">
                <!-- form start -->
                <form id="form_choose_barter" novalidate="novalidate">


                    <div class="modal-header">
                        <h4 class="title">Select Product For Barter</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="send-message-result"></div>

                                <div class="form-group">
                                    <label class="control-label">Select Your Product</label>
                                    <select name="state" class="form-control">
                                        <option value="">--- Select Product ---</option>
                                        <?php
                                      
                                        foreach ($products_available as $product) {
                                            $p_name=get_product_details_by_id($product->id);
                                            echo "<option value='" . $product->id . "'>" .$p_name->title . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><i class="icon-times"></i>&nbsp;<?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-custom"><i class="icon-right"></i>&nbsp;<?php echo trans("save_changes"); ?></button>
                    </div>
                </form>
                <!-- form end -->
            </div>
        </div>
    </div>
<?php endif; ?>
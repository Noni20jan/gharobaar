<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .table-responsive>.barter-requests {
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    .table-responsive>.barter-requests>tbody>tr>td {
        padding: 1px;
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);

    }

    .table-responsive>.barter-requests>thead>tr>th:first-child {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    .table-responsive>.barter-requests>thead>tr>th:last-child {
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }

    .table-responsive>.barter-requests>tbody>tr>td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .table-responsive>.barter-requests>tbody>tr>td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .table-responsive>.barter-requests>thead>tr>th {
        padding: 10px;
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);
    }

    .btn-table-option {
        margin-bottom: 3px;
    }
    .filter_color{
        background-color: #DF911E !important;
        border-radius: 20px !important;
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= html_escape($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open(current_url(), ['method' => 'GET']); ?>
                            <div class="item-table-filter">
                                <label><?php echo trans("status"); ?></label>
                                <select name="status" class="form-control custom-select">
                                    <option value="" selected><?php echo trans("all"); ?></option>
                                    <option value="new_barter_request" <?= input_get('status') == 'new_barter_request' ? 'selected' : ''; ?>>New Barter Request</option>
                                    <option value="pending_barter" <?= input_get('status') == 'pending_barter' ? 'selected' : ''; ?>>Pending Request</option>
                                    <option value="barter_reviewed" <?= input_get('status') == 'barter_reviewed' ? 'selected' : ''; ?>> Request Reviewed</option>
                                    <option value="deal_cancelled" <?= input_get('status') == 'deal_cancelled' ? 'selected' : ''; ?>> Deal Cancel</option>
                                    <option value="barter_accepted" <?= input_get('status') == 'barter_accepted' ? 'selected' : ''; ?>>Barter Request Accepted</option>
                                    <option value="rejected_barter" <?= input_get('status') == 'rejected_barter' ? 'selected' : ''; ?>>Rejected Request</option>
                                    <option value="closed_by_buyer" <?= input_get('status') == 'closed_by_buyer' ? 'selected' : ''; ?>><?php echo trans("closed"); ?></option>
                                    <option value="closed_by_seller" <?= input_get('status') == 'closed_by_seller' ? 'selected' : ''; ?>><?php echo trans("closed"); ?></option>
                                    <option value="completed" <?= input_get('status') == 'completed' ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
                                </select>
                            </div>

                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?= input_get('q'); ?>">
                            </div>

                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="filter_color btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <table class="barter-requests" role="grid">
                        <thead>
                            <tr role="row" class="rock">
                                <th scope="col">Barter</th>
                                <th scope="col">My Barter Product</th>
                                <th scope="col">Requested Product For barter</th>
                                <th scope="col">Request Raised By</th>
                                <th scope="col"><?php echo trans('status'); ?></th>
                                <th scope="col"><?php echo trans('updated'); ?></th>
                                <th scope="col"><?php echo trans('date'); ?></th>
                                <th class="max-width-120"><?php echo trans('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($quote_requests as $item) : ?>
                                <tr>
                                    <td>#<?php echo $item->id; ?></td>
                                    <td>
                                        <?php $product = get_product($item->product_id);
                                        if (!empty($product)) : ?>
                                            <div class="table-item-product">
                                                <div class="left">
                                                    <div class="img-table">
                                                        <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                            <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                        <h3 class="table-product-title"><?php echo $item->product_title; ?></h3>
                                                    </a>
                                                    <?php echo trans("quantity") . ": " . $item->product_quantity; ?>
                                                    <?php echo "Price" . ": " . price_formatted(get_product($item->product_id)->price, $item->price_currency); ?>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <h3 class="table-product-title"><?php echo $item->product_title; ?></h3>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $product = get_product($item->barter_product_id);
                                        if (!empty($product)) : ?>
                                            <div class="table-item-product">
                                                <div class="left">
                                                    <div class="img-table">
                                                        <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                            <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                        <h3 class="table-product-title"><?php echo get_product_details_by_id($item->barter_product_id)->title; ?></h3>
                                                    </a>
                                                    <?php echo trans("quantity") . ": " . $item->product_quantity; ?>
                                                    <?php echo "Price" . ": " . price_formatted(get_product($item->barter_product_id)->price, $item->price_currency); ?>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <h3 class="table-product-title"><?php echo get_product_details_by_id($item->barter_product_id)->title; ?></h3>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php $seller = get_user($item->buyer_id);
                                        if (!empty($seller)) : ?>
                                            <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="font-600">
                                                <?= get_shop_name($seller); ?>
                                            </a>
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <?php if ($item->status == "new_barter_request") : ?>
                                            <label class="label label-success"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "pending_barter") : ?>
                                            <label class="label label-warning"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "barter_reviewed") : ?>
                                            <label class="label label-warning"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "barter_accepted") : ?>
                                            <label class="label label-info"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "rejected_barter") : ?>
                                            <label class="label label-danger"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "deal_cancelled") : ?>
                                            <label class="label label-danger"><?= trans($item->status); ?></label>
                                        <?php elseif ($item->status == "closed_by_seller") : ?>
                                            <label class="label label-default">Closed </label>
                                        <?php elseif ($item->status == "closed_by_buyer") : ?>
                                            <label class="label label-default">Closed </label>
                                        <?php elseif ($item->status == "completed") : ?>
                                            <label class="label label-primary"><?= trans($item->status); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td>
                                        <?php if ($item->status != 'new_barter_request' && $item->price_offered != 0) : ?>
                                            <div class="table-seller-bid">
                                                <p><b><?php echo trans("price"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->price_offered, $item->price_currency); ?></strong></p>
                                                <?php if (!empty($product) && $product->product_type == 'digital') : ?>
                                                    <p><b><?php echo trans("shipping"); ?>:&nbsp;</b><strong><?php echo trans("no_shipping"); ?></strong></p>
                                                <?php else : ?>
                                                    <p><b><?php echo trans("shipping"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->shipping_cost, $item->price_currency); ?></strong></p>
                                                <?php endif; ?>
                                                <p><b><?php echo trans("total"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->price_offered + $item->shipping_cost, $item->price_currency); ?></strong></p>
                                            </div>
                                        <?php endif; ?>
                                    </td> -->
                                    <td><?php echo time_ago($item->updated_at); ?></td>
                                    <td><?php echo formatted_date($item->created_at); ?></td>
                                    <!-- <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <?php if ($item->status == 'new_barter_request') : ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-plus option-icon"></i>Submit Barter</a>
                                                    </li>
                                                <?php elseif ($item->status == 'pending_barter') : ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i>Update Barter</a>
                                                    </li>
                                                <?php elseif ($item->status == 'rejected_barter') : ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-refresh option-icon"></i>Submit a new barter</a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_barter_request(<?php echo $item->id; ?>,'<?php echo trans($confirm_quote_request) ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td> -->
                                    <td>

                                        <?php if ($item->status == 'new_barter_request' || $item->status == 'barter_reviewed') : ?>

                                            <?php echo form_open('review-barter-post'); ?>

                                            <input type="hidden" name="barter_product_id" class="form-control" value="<?php echo $barter_product_id; ?>">
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <!-- <a href="<?php echo generate_product_url($p); ?>" target="_blank"> -->
                                            <button type="submit" class="btn btn-sm btn-custom btn-table-option btn-delete-quote">Review Barter</button>
                                            <!-- </a> -->
                                            <?php echo form_close(); ?>

                                            <button type="submit" class="btn btn-sm btn-info btn-table-option" onclick="accept_barter_request(<?php echo $item->id; ?>,'Are you sure you want to accept this barter request?');">Accept Barter</button>

                                            <br>

                                            <button type="button" class="btn btn-sm btn-secondary btn-table-option" onclick="reject_barter_request(<?php echo $item->id; ?>,'Are you sure you want to reject this barter request?');">Reject Barter</button>

                                            <br>

                                            <!-- <?php echo form_open('add-to-cart-barter'); ?> -->
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <button data-toggle="modal" data-target="#messageModal" class="btn btn-sm btn-info btn-table-option"><i class="icon-cart"></i>&nbsp;Connect with Supplier</button>
                                            <!-- <?php echo form_close(); ?> -->
                                            <br>

                                        <?php elseif ($item->status == 'completed' || $item->status == 'closed_by_buyer') : ?>
                                            <br><?php echo form_open('close-barter-post'); ?>
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger btn-table-option">Close Barter</button>
                                            <?php echo form_close(); ?>
                                            <button type="button" class="btn btn-sm btn-danger btn-table-option">Schedule Payment</button>
                                        <?php elseif ($item->status == 'closed_by_seller') : ?>
                                            <button class="btn btn-sm btn-danger btn-table-option">Closed</button>
                                        <?php elseif ($item->status == 'deal_cancelled') : ?>
                                            <button class="btn btn-sm btn-danger btn-table-option">Deal Cancelled</button>
                                        <?php else : ?>
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <button data-toggle="modal" data-target="#messageModal" class="btn btn-sm btn-info btn-table-option"><i class="icon-cart"></i>&nbsp;Connect with Supplier</button>
                                            <br><?php echo form_open('complete-barter-post'); ?>
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <button type="submit" class="btn btn-sm btn-success btn-table-option">Complete Barter</button>
                                            <?php echo form_close(); ?>
                                            <?php echo form_open('deal-cancel-barter-post'); ?>
                                            <input type="hidden" name="id" class="form-control" value="<?php echo $item->id; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger btn-table-option">Deal Cancel</button>
                                            <?php echo form_close(); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $this->load->view("partials/_modal_send_barter_message", ["item" => $item->buyer_id]); ?>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
                <?php if (empty($quote_requests)) : ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($quote_requests)) : ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>



<!-- Modal -->
<?php if (!empty($quote_requests)) :
    foreach ($quote_requests as $quote_request) :
        $quote_product = get_product($quote_request->product_id); ?>
        <div class="modal fade" id="modalSubmitQuote<?php echo $quote_request->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('submit-barter-post'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Submit a barter</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('price'); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                <input type="text" name="price" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" data-item-id="<?php echo $quote_request->id; ?>" data-product-quantity="<?php echo $quote_request->product_quantity; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                            </div>
                        </div>
                        <?php if (!empty($quote_product) && $quote_product->product_type == 'digital') : ?>
                            <input type="hidden" name="shipping_cost" value="0">
                            <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                        <?php else : ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('shipping_cost'); ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                    <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                    <input type="text" name="shipping_cost" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <p class="calculated-price">
                                <strong><?php echo trans("unit_price"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;
                                    <span id="unit_price_<?php echo $quote_request->id; ?>" class="earned-price">
                                        <?php echo number_format(0, 2, '.', ''); ?>
                                    </span>
                                </strong><br>
                                <strong><?php echo trans("you_will_earn"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;
                                    <span id="earned_price_<?php echo $quote_request->id; ?>" class="earned-price">
                                        <?php $earned_price = $quote_product->price - (($quote_product->price * $this->general_settings->commission_rate) / 100);
                                        $earned_price = number_format($earned_price, 2, '.', '');
                                        echo get_price($earned_price, 'input'); ?>
                                    </span>
                                </strong>&nbsp;&nbsp;&nbsp;
                                <small> (<?php echo trans("commission_rate"); ?>:&nbsp;&nbsp;<?php echo $this->general_settings->commission_rate; ?>%)</small>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- form end -->
                </div>
            </div>
        </div>
<?php endforeach;
endif; ?>


<script>
    //calculate product earned value
    var thousands_separator = '<?php echo $this->thousands_separator; ?>';
    var commission_rate = '<?php echo $this->general_settings->commission_rate; ?>';
    $(document).on("input keyup paste change", ".price-input", function() {
        var input_val = $(this).val();
        var data_item_id = $(this).attr('data-item-id');
        var data_product_quantity = $(this).attr('data-product-quantity');
        input_val = input_val.replace(',', '.');
        var price = parseFloat(input_val);
        commission_rate = parseInt(commission_rate);
        //calculate earned price
        if (!Number.isNaN(price)) {
            var earned_price = price - ((price * commission_rate) / 100);
            earned_price = earned_price.toFixed(2);
            if (thousands_separator == ',') {
                earned_price = earned_price.replace('.', ',');
            }
        } else {
            earned_price = '0' + thousands_separator + '00';
        }

        //calculate unit price
        if (!Number.isNaN(price)) {
            var unit_price = price / data_product_quantity;
            unit_price = unit_price.toFixed(2);
            if (thousands_separator == ',') {
                unit_price = unit_price.replace('.', ',');
            }
        } else {
            unit_price = '0' + thousands_separator + '00';
        }

        $("#earned_price_" + data_item_id).html(earned_price);
        $("#unit_price_" + data_item_id).html(unit_price);
    });

    $(document).on("click", ".btn_submit_quote", function() {
        $('.modal-title').text("Submit Barter");
    });
    $(document).on("click", ".btn_update_quote", function() {
        $('.modal-title').text("Update Barter");
    });
</script>

<?php if (!empty($this->session->userdata('mds_send_email_data'))) : ?>
    <script>
        $(document).ready(function() {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data")); ?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                data["sys_lang_id"] = sys_lang_id;
                $.ajax({
                    type: "POST",
                    url: base_url + "send-email-post",
                    data: data,
                    success: function(response) {}
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>
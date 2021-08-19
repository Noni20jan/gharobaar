<?php defined('BASEPATH') or exit('No direct script access allowed');
//var_dump($quote_requests);
?>
<style>
    .table-responsive>.quote_requests {
        border-collapse: separate;
        border-spacing: 0px 16px;
    }

    .quote_requests>thead>tr>th {
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);
        padding: 10px;
    }

    .quote_requests>thead>tr>th:first-child {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    .quote_requests>thead>tr>th:last-child {
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }

    .quote_requests>tbody>tr>td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .quote_requests>tbody>tr>td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .quote_requests>tbody>tr>td {
        padding: 13px;
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <div class="table-responsive">
                            <table class="quote_requests ">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col"><?php echo trans("product"); ?></th>
                                        <th scope="col"><?php echo trans("seller"); ?></th>
                                        <th scope="col">My product for barter</th>
                                        <th scope="col"><?php echo trans("status"); ?></th>

                                        <th scope="col"><?php echo trans("updated"); ?></th>
                                        <th scope="col"><?php echo trans("options"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($quote_requests)) : ?>
                                        <?php foreach ($quote_requests as $quote_request) : ?>
                                            <tr>
                                                <td>#<?php echo $quote_request->id; ?></td>
                                                <td>
                                                    <?php $product = get_product($quote_request->product_id);
                                                    if (!empty($product)) : ?>
                                                        <div class="table-item-product">
                                                            <div class="left">
                                                                <div class="img-table">
                                                                    <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                        <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="right" style="display: table-cell;vertical-align: top;padding-left: 10px;padding-top: 8%;">
                                                                <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                    <h3 class="table-product-title"><?php echo $quote_request->product_title; ?></h3>
                                                                </a>
                                                                <?php echo trans("quantity") . ": " . $quote_request->product_quantity; ?>
                                                                <?php echo "Price" . ": " . price_formatted(get_product($quote_request->product_id)->price, $quote_request->price_currency); ?>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <h3 class="table-product-title"><?php echo $quote_request->product_title; ?></h3>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="padding-bottom: 2%;">
                                                    <?php $seller = get_user($quote_request->seller_id);
                                                    if (!empty($seller)) : ?>
                                                        <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="font-600">
                                                            <?= get_shop_name($seller); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php $product = get_product($quote_request->barter_product_id);
                                                    if (!empty($product)) : ?>
                                                        <div class="table-item-product">
                                                            <div class="left">
                                                                <div class="img-table">
                                                                    <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                        <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="right" style="display: table-cell;vertical-align: top;padding-left: 10px;padding-top: 8%;">
                                                                <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                    <h3 class="table-product-title"><?php echo get_product_details_by_id($quote_request->barter_product_id)->title; ?></h3>
                                                                </a>
                                                                <?php echo trans("quantity") . ": " . $quote_request->product_quantity; ?>
                                                                <?php echo "Price" . ": " . price_formatted(get_product($quote_request->barter_product_id)->price, $quote_request->price_currency); ?>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <h3 class="table-product-title"><?php echo get_product_details_by_id($quote_request->barter_product_id)->title; ?></h3>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="padding-bottom: 2%;"><?php echo trans($quote_request->status); ?></td>
                                                <!-- <td>
                                                <?php if ($quote_request->status != 'new_quote_request' && $quote_request->price_offered != 0) : ?>
                                                    <div class="table-seller-bid">
                                                        <p><b><?php echo trans("price"); ?>:&nbsp;</b><strong><?php echo price_formatted($quote_request->price_offered, $quote_request->price_currency); ?></strong></p>
                                                        <p><b><?php echo trans("shipping"); ?>:&nbsp;</b><strong><?php echo price_formatted($quote_request->shipping_cost, $quote_request->price_currency); ?></strong></p>
                                                        <p><b><?php echo trans("total"); ?>:&nbsp;</b><strong><?php echo price_formatted($quote_request->price_offered + $quote_request->shipping_cost, $quote_request->price_currency); ?></strong></p>
                                                    </div>
                                                <?php endif; ?>
                                            </td> -->
                                                <td style="padding-bottom: 2%;"><?php echo time_ago($quote_request->updated_at); ?></td>
                                                <td style="padding-bottom: 2%;">
                                                    <?php if ($quote_request->status == 'new_barter_request' || $quote_request->status == 'pending_barter' || $quote_request->status == 'barter_reviewed') : ?>

                                                        <button type="button" class="btn btn-sm btn-danger btn-table-option btn-delete-quote" onclick="delete_barter_request(<?php echo $quote_request->id; ?>,'Are you sure you want to delete this barter request?');">Delete Barter</button>
                                                    <?php elseif ($quote_request->status == 'barter_accepted') : ?>
                                                        <?php echo form_open('deal-cancel-barter-post'); ?>
                                                        <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger btn-table-option">Deal Cancel</button>
                                                        <?php echo form_close(); ?>


                                                    <?php elseif ($quote_request->status == 'closed_by_buyer') : ?>
                                                        <button class="btn btn-sm btn-danger btn-table-option">&nbsp;Barter Closed</button>
                                                    <?php elseif ($quote_request->status == 'deal_cancelled') : ?>
                                                        <button class="btn btn-sm btn-danger btn-table-option">&nbsp;Deal Cancelled</button>
                                                    <?php else : ?>
                                                        <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                        <button data-toggle="modal" data-target="#messageModal" class="btn btn-sm btn-info btn-table-option"><i class="icon-cart"></i>&nbsp;Connect with Supplier</button>
                                                        <?php echo form_open('close-barter-buyer-post'); ?>
                                                        <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger btn-table-option">Close Barter</button>
                                                        <?php echo form_close(); ?>
                                                    <?php endif; ?>

                                                </td>
                                            </tr>

                                            <?php $this->load->view("partials/_modal_send_barter_message",  ["item" => $quote_request->seller_id]); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
    </div>
</div>
<!-- Wrapper End-->
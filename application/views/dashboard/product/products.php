<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* #boxbg {
        background-position: center;
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-image: url('../assets/img/cart_bg.png');

    } */

    .font-size-mobile {
        font-size: 12px;
    }

    table-responsive>.navy {
        border-collapse: collapse;
        width: 100%;
        background-color: #fdfdfda4;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 20px;
        padding: 20px
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 1em;
        border-radius: 6px;
        -moz-border-radius: 6px;
    }




    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {

        /* Force table to not be like tables anymore */
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            margin: 0 0 1rem 0;
        }

        tr:nth-child(odd) {
            /* background: #ccc; */
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 0;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }

        td:nth-of-type(1):before {
            content: "Id";
        }

        td:nth-of-type(2):before {
            content: "product";
        }

        td:nth-of-type(3):before {
            content: "SKU";
        }

        td:nth-of-type(4):before {
            content: "Product Type";
        }

        td:nth-of-type(5):before {
            content: "Category";
        }

        td:nth-of-type(6):before {
            content: "Purchased Plan";
        }

        td:nth-of-type(7):before {
            content: "Stock";
        }

        td:nth-of-type(8):before {
            content: "Page Views";
        }

        td:nth-of-type(9):before {
            content: "Date";
        }

        td:nth-of-type(10):before {
            content: "Options";
        }

        .apporved-products-mobile-view td:nth-of-type(11):before {
            content: "Id";
        }

        .apporved-products-mobile-view td:nth-of-type(12):before {
            content: "Product";
        }

        .apporved-products-mobile-view td:nth-of-type(13):before {
            content: "SKU";
        }

        .apporved-products-mobile-view td:nth-of-type(14):before {
            content: "Product Type";
        }

        .apporved-products-mobile-view td:nth-of-type(15):before {
            content: "Category";
        }

        .apporved-products-mobile-view td:nth-of-type(16):before {
            content: "Purchased Plan";
        }

        .apporved-products-mobile-view td:nth-of-type(17):before {
            content: "Stock";
        }

        .apporved-products-mobile-view td:nth-of-type(18):before {
            content: "Page Views";
        }

        .apporved-products-mobile-view td:nth-of-type(19):before {
            content: "Date";
        }

        .apporved-products-mobile-view td:nth-of-type(20):before {
            content: "Options";
        }

    }

    .item-table-filter select,
    .item-table-filter input {
        display: block;
        width: 172px;
        border-radius: 20px;
        margin-top: 30px;
        background-color: #fdfdfda4;
        max-width: 100%;
        border-radius: 20px;
        margin: 0 auto;
        margin-top: 10px;
        border: 1px solid #f5f5f5;
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

                <?php $this->load->view('dashboard/product/_filter_products'); ?>
                <div class="row new-view">
                    <table class="even table table-striped table-products" role="grid">
                        <thead>
                            <tr>
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th><?php echo trans('product'); ?></th>
                                <th><?php echo trans('sku'); ?></th>
                                <th><?php echo trans('product_type'); ?></th>
                                <th><?php echo trans('category'); ?></th>
                                <?php if ($this->general_settings->promoted_products == 1) : ?>
                                    <!-- disabled promotion of products -->
                                    <!-- <th><?php //echo trans('purchased_plan'); 
                                                ?></th> -->
                                <?php endif; ?>
                                <th><?php echo trans('stock'); ?></th>
                                <th><?php echo trans('page_views'); ?></th>
                                <th><?php echo trans('date'); ?></th>
                                <th><?php echo trans('options'); ?></th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)) :
                                foreach ($products as $item) :
                                    $remarks = $this->product_admin_model->get_remarks($item->id);
                            ?>
                                    <tr class="apporved-products-mobile-view">
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td class="td-product">
                                            <?php if ($item->is_promoted == 1) : ?>
                                                <label class="label label-success"><?php echo trans("featured"); ?></label>
                                            <?php endif; ?>
                                            <div class="img-table">
                                                <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                                    <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                </a>
                                            </div>
                                            <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title"><br />
                                                <?php echo get_product_title($item); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $item->sku; ?></td>
                                        <td><?php echo $item->supplier_product_type; ?></td>
                                        <td>
                                            <?php $categories = get_parent_categories_tree($item->category_id, false);
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    echo html_escape($category->name) . "<br>";
                                                }
                                            } ?>
                                        </td>
                                        <!-- disabled promotion of products -->
                                        <!-- <?php //if ($this->general_settings->promoted_products == 1) : 
                                                ?>
                                            <td>
                                                <?php //if ($item->is_draft != 1) :
                                                //if ($item->is_promoted == 1 && $item->promote_plan != "none") :
                                                //  echo $item->promote_plan;
                                                //else : 
                                                ?>
                                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalPricing" onclick="$('.pricing_product_id').val(<?= $item->id; ?>);"><i class="fa fa-plus"></i>&nbsp;<?= trans("promote"); ?></button>
                                                <?php //endif;
                                                //endif; 
                                                ?>
                                            </td>
                                        <?php //endif; 
                                        ?> -->
                                        <td class="white-space-nowrap">
                                            <?php if ($item->product_type == "digital" && $item->add_meet == "Made to stock") : ?>
                                                <span class="text-success"><?php echo trans("in_stock"); ?></span>
                                            <?php elseif ($item->add_meet == "Made to order") : ?>
                                                <span class="text-success font-size-mobile">Available in <?php echo $item->lead_days; ?> Days <?php echo $item->lead_time; ?> Hours </span>
                                                <?php else :
                                                if ($item->stock < 1) : ?>
                                                    <span class="text-danger font-size-mobile"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                                <?php else : ?>
                                                    <span class="text-success font-size-mobile"><?php echo trans("in_stock"); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? "(" . $item->stock . ")" : ''; ?></span>
                                                <?php endif; ?>


                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $item->pageviews; ?></td>
                                        <td><?php echo formatted_date($item->created_at); ?></td>
                                        <td>
                                            <div class="dropdown" style="float:none;">
                                                <button class="btn  dropdown-toggle btn-select-option btn-custom" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo generate_dash_url("edit_product") . "/" . $item->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_product(<?php echo $item->id; ?>,'<?php echo trans('confirm_product'); ?>')">
                                                        <i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>

                                                    <?php if ($item->visibility == 1) : ?>

                                                    <li>
                                                      <a href="javascript:void(0)" style="margin-left: 9px;" onclick="hide_product('Dashboard_controller/hide_products',<?php echo $item->id; ?>,'<?php echo trans('confirm_hide_products'); ?>');"><i class="fa fa-eye-slash"></i><?php echo trans('hide_product'); ?></a>
                                                    </li>
                                                    <?php else : ?>
                                                    <li>
                                                        <a href="javascript:void(0)" style="margin-left: 9px;" onclick="unhide_product('Dashboard_controller/unhide_products','<?php echo $item->id; ?>','<?php echo trans('confirm_unhide_products'); ?>');"><i class="fa fa-eye-slash"></i><?php echo trans('unhide_product'); ?></a>
                                                    </li>
                                                    <?php endif; ?>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                        <td><?php if ($remarks != "") {
                                                echo html_escape($remarks->remark);
                                            } ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($products)) : ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($products)) : ?>
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

<?php $this->load->view('dashboard/product/_modal_pricing'); ?> </div>
</div>
</div><!-- /.box-body -->
</div>

<?php $this->load->view('dashboard/product/_modal_pricing'); ?>
<script>
    function hide_product(url, id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                var data = {
                    'id': id,
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + url,
                    data: data,
                    success: function(response) {
                        location.reload();
                        console.log(response)
                    }
                });
            }
        });
    };

    function unhide_product(url, id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                var data = {
                    'id': id,
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + url,
                    data: data,
                    success: function(response) {
                        location.reload();
                        console.log(response)
                    }
                });
            }
        });
    };
</script>
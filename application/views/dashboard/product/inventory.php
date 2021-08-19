<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    #boxbg {
        background-position: center;
        width: 100%;
        height: 100%;
        object-fit: cover;

    }

    .item-table-filter select,
    .item-table-filter input {
        display: block;
        width: 180px;
        border-radius: 20px;
        margin-top: 30px;
        background-color: #fdfdfda4;
        max-width: 100%;
        border-radius: 20px;
        margin: 0 auto;
        margin-top: 30px;
        border: 1px solid #f5f5f5;
    }

    @media only screen and (max-width: 700px) {
        .ewa {
            border-collapse: separate;
            border-spacing: 0 25px;
        }

        tr {
            padding-left: 20px;
        }
    }

    tr th {
        padding: 10px;
    }

    @media only screen and (max-width: 700px) {
        tr th {
            padding: 20px;
        }
    }

    tr td {
        padding: 5px;
    }

    @media only screen and (max-width: 700px) {
        tr td {
            padding: 20px;
        }
    }

    tr.rock th {
        background-color: #fdfdfda4;
    }

    tr.rock th:first-child {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;

    }

    tr.rock th:last-child {
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;

    }

    tr.exit td {
        background-color: #fdfdfda4;

    }

    tr.exit td:first-child {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    tr.exit td:last-child {
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }

    .inventory_margin {
        margin-right: 15%;
    }
</style>
<div id="wrapper">
    <div class="box">
        <div class="box-header with-border">
            <div class="left">
                <h3 class="box-title"><?= html_escape($title); ?></h3>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="even table table-striped table-products">
                            <thead>
                                <tr class="rock">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('product'); ?></th>
                                    <th><?php echo trans('sku'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)) :
                                    foreach ($products as $item) : ?>
                                        <tr>
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


                                        <td class="white-space-nowrap">
                                            <?php if ($item->product_type == "digital" && $item->add_meet == "Made to stock") : ?>
                                                <span class="text-success"><?php echo trans("in_stock"); ?></span>
                                            <?php elseif ($item->add_meet == "Made to order") : ?>
                                                <span class="text-success">Available in <?php echo $item->lead_days; ?> Days <?php echo $item->lead_time; ?> Hours </span>
                                                <?php else :
                                                if ($item->stock < 1) : ?>
                                                    <span class="text-danger"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                                <?php else : ?>
                                                    <span class="text-success"><?php echo trans("in_stock"); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? "(" . $item->stock . ")" : ''; ?></span>
                                                <?php endif; ?>


                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php echo form_open('update-stock-post'); ?>
                                            <input type="hidden" name="id" value="<?php echo $item->id; ?>">

                                            <div>
                                                <div style="float:left;">
                                                    <input type="number" name="stock" class="form-control form-input max-perc-50" min="0" max="999999999" value="" placeholder="<?php echo trans("stock"); ?>" required>
                                                </div>
                                                <div style="float:left;">
                                                    <button type="submit" class="btn btn-md btn-success"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></button>
                                                </div>
                                            </div>
                                            




                                                <?php echo form_close(); ?>
                                            </td>
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
</div>

<div class="modal fade" id="updateStockModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->
            <?php echo form_open('update-stock-post'); ?>
            <input type="hidden" name="id" id="stock_id">
            <div class="modal-header">
                <h5 class="modal-title">Update Product Stock</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('stock'); ?></label>
                            <input type="number" name="stock" class="form-control form-input max-perc-50" min="0" max="999999999" value="" placeholder="<?php echo trans("stock"); ?>" required>

                        </div>
                    </div>
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

<?php $this->load->view('dashboard/product/_modal_pricing'); ?>
<script>
    $(".passingID").click(function() {
        var ids = $(this).attr('data-id');
        $("#stock_id").val(ids);

    });
</script>
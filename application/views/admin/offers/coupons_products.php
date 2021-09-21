<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<style>
    .pull-right{
        float:left !important;
    }
        .nxt-cancel-btns {
        text-align: center;

        position: relative;
        top: 50px;
    }
     .nxt-cancel-styls {
        width: 100px;
        background: #185d8c;
        border-color: #185d8c;
        color: white;
        float: right;
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Coupons</h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form id="submit_val">
                    <input id='my_match' type='hidden' name='all_selected_check' />
                    <label>Choose a coupon:<label>

                    <select name="form-control" id="offer_id">
                        <?php foreach ($coupons as $coupon) : ?>

                            <option value="<?php echo $coupon->id ?>"><?php echo $coupon->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive" style="overflow-x:hidden !important;">
                    <table id="example" class="table table-bordered table-striped" role="grid">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th><?php echo trans('product'); ?></th>
                                <th><?php echo trans('sku'); ?></th>
                                <th><?php echo trans('product_type'); ?></th>
                        
                                <th class="max-width-120"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
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
                                            <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                                <?php echo get_product_title($item); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $item->sku; ?></td>
                                        <td><?php echo trans($item->product_type); ?></td>
                                       
                                        <td>
                                            <input type="checkbox" name="selected_id" id="product_checkbox" value="<?php echo $item->id; ?> ">
                                           
                                        </td>
                                    </tr>

                            <?php endforeach;
                            endif; ?>

                        </tbody>
                    </table>

                    <?php if (empty($products)) : ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                            <button type="button" id="submit_val_button" class="nxt-cancel-styls">Done</button>

                            </div> 
                            <?php if (count($products) > 0) : ?>
                                <div class="pull-left">
                                    <!-- <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button> -->
                                </div>
                            <?php endif; ?>
                            </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open('product_controller/add_remove_featured_products'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('add_to_featured'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?php echo trans('day_count'); ?></label>
                    <input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
                    <input type="hidden" class="form-control" name="is_ajax" value="0">
                    <input type="number" class="form-control" name="day_count" placeholder="<?php echo trans('day_count'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo trans("submit"); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
            </div>
            <?php echo form_close(); ?>
            <!-- form end -->
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

            'columnDefs': [{
                'targets': 0,
                "bPaginate": false,
                "bFilter": false,
                'searchable': true,
                'orderable': false,
                'className': 'dt-body-center',

            }],
            'order': [1, 'asc']
        });
      


        // Handle click on "Select all" control
        $('#example-select-all').on('click', function() {
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('#product_checkbox', rows).prop('checked', this.checked);
        });
        

        // Handle click on checkbox to set state of "Select all" control

    });
</script>

<script>
    $('#submit_val_button').click(function() {
        var arr = [];
        $('input:checked[name=selected_id]').each(function() {
            arr.push($(this).val());
        });

        $('#my_match').val(arr.join(':'));
        alert($('#my_match').val());

        console.log(typeof(($('#my_match').val())));

        var source_id = ($('#my_match').val());
        var z = source_id.trim();

        var arr_source_id = (z.split(':'));
        var split_arr = arr_source_id.map(s => s.trim())

        var offer_id = ($('#offer_id').val());
        console.log(offer_id);
        var data = {
            'source_type': 'Product',
            'source_id': split_arr,
            'offer_id': offer_id
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "add-product-coupon",

            data: data,

            success: function(data) {
                alert(data);
            },
            error: function() {
                alert("error"); //error occurs
            }
        });
        return false;
    });
</script>
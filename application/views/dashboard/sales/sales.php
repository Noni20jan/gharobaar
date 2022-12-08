<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    /* .row-new-view>.even {
        border-collapse: separate;
        border-spacing: 0 35px;
    } */

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

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 43%;
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
            content: "sale";
        }

        td:nth-of-type(2):before {
            content: "total";
        }

        td:nth-of-type(3):before {
            content: "payment";
        }

        td:nth-of-type(4):before {
            content: "status";
        }

        td:nth-of-type(5):before {
            content: "date";
        }

        td:nth-of-type(6):before {
            content: "options";
        }

    }


    .label-rejected {
        color: #fff !important;
        background-color: red !important;
        box-shadow: none !important;
    }

    .filter_color {
        background-color: black !important;
    }

    .row-custom {
        padding-right: 15px;
        padding-left: 15px;
    }
</style>

<?php $shipping_value=10000;?>
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
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open($page_url, ['method' => 'GET']); ?>
                            <div class="item-table-filter">
                                <label><?php echo trans("payment_status"); ?></label>
                                <select name="payment_status" class="form-control custom-select">
                                    <option value="" selected><?php echo trans("all"); ?></option>
                                    <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                                    <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
                                </select>
                            </div>

                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo str_slug(html_escape($this->input->get('q', true))); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>

                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="filter_color btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div class="row-new-view">
                        <table class="even table table-striped table-products">
                            <thead>
                                <tr>
                                    <th scope="col"><?php echo trans("sale"); ?></th>
                                    <th scope="col"><?php echo trans("total"); ?></th>
                                    <!-- <th scope="col"><?php echo trans("payment"); ?></th> -->
                                    <th scope="col"><?php echo trans("status"); ?></th>
                                    <th scope="col"><?php echo trans("date"); ?></th>
                                    <th scope="col"><?php echo trans("options"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sales)) : ?>
                                    <?php foreach ($sales as $sale) :
                                        $total = $this->order_model->get_seller_total_price($sale->id);
                                        $ct = $this->order_model->supplier_count($sale->id);
                                        $price = $this->order_model->get_order_price($sale->id);
                                        $i = 0;
                                        foreach ($ct as $count) {
                                            $seller_count[$i] = $ct[0]->seller_id;
                                            ++$i;
                                        }
                                        $op = $this->order_model->order_price($sale->id); 
                                        if (!empty($sale)) : ?>
                                            <tr>
                                                <td>#<?php echo $sale->order_number; ?></td>
                                                <?php if ($op[0]->price_total<$this->general_settings->min_ship_cart_total) :?>
                                                <td><?php echo price_formatted($total+(10000/$i), $sale->price_currency); ?>/-</td>
                                                <?php else:?>
                                                    <td><?php echo price_formatted($total+(10000/$i), $sale->price_currency); ?>/-</td>
                                                    <?php endif;?>
                                                

                                                <!-- <td>
                                                    <?php if ($sale->payment_status == 'payment_received') :
                                                        echo trans("payment_received");
                                                    else :
                                                        echo trans("awaiting_payment");
                                                    endif; ?>
                                                </td> -->
                                                <td>
                                                    <?php if ($active_page == "sales") : ?>
                                                        <label class="label label-success"><?= trans("order_processing"); ?></label>
                                                    <?php elseif ($active_page == "accepted_sales") : ?>
                                                        <label class="label label-success"><?= trans("order_accepted"); ?></label>
                                                    <?php elseif ($active_page == "rejected_sales") : ?>
                                                        <label class="label label-rejected"><?= trans("order_rejected"); ?></label>
                                                    <?php elseif ($active_page == "awaiting_pickup") : ?>
                                                        <label class="label label-success"><?= trans("awaiting_pickup"); ?></label>
                                                    <?php elseif ($active_page == "shipped") : ?>
                                                        <label class="label label-success"><?= trans("shipped"); ?></label>
                                                    <?php elseif ($active_page == "cancelled_by_user") : ?>
                                                        <label class="label label-rejected"><?= trans("cancelled_by_user"); ?></label>
                                                    <?php elseif ($active_page == "cancelled_by_seller") : ?>
                                                        <label class="label label-rejected"><?= trans("cancelled_by_seller"); ?></label>
                                                    <?php else : ?>
                                                        <label class="label label-default"><?= trans("completed"); ?></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo date("Y-m-d / h:i", strtotime($sale->created_at)); ?></td>
                                                <td>
                                                    <a href="<?= generate_dash_url("sale"); ?>/<?php echo $sale->order_number; ?>" class="btn btn-sm btn-custom btn-details" id="details">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo trans("details"); ?></a>
                                                    <br>

                                                </td>
                                            </tr>
                                    <?php endif;
                                    endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (empty($sales)) : ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($sales)) : ?>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Made to order</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Reject</button>
                <button type="button" class="btn btn-primary">Accept</button>
            </div>
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
    window.onload =
        setTimeout(function() {
            $('#myModal').modal();
        }, 2000);
</script> -->
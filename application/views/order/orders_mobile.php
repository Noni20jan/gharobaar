<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .row-custom {
        padding-right: 15px;
        padding-left: 15px;
    }

    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        td:nth-of-type(1):before {
            content: none;
        }
    }

    .table-item-product .right {
        display: table-cell;
        vertical-align: middle;
        padding-left: 15px;
    }

    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        border-top: none;
    }

    .box-header .left {
        float: none !important;
        text-align: center;
    }

    .content-wrapper {
        background-color: #ebebeb;
    }

    .table-item-product {
        display: table;
        width: 100%;
    }

    .table-item-product .left {
        display: table-cell;
        vertical-align: middle;
    }
</style>

<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box" id="boxbg">
                    <div class="box-header with-border">
                        <div class="left">
                            <h3 class="page-title"><?php echo $title; ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row-custom">
                                <div class="profile-tab-content">
                                    <!-- include message block -->
                                    <?php $this->load->view('partials/_messages'); ?>
                                    <?php if (!empty($orders)) : ?>
                                        <div class="row-new-view">
                                            <table class="even table table-striped table-products">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"><?php echo trans("product"); ?></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orders as $order) : ?>
                                                        <?php $items = $order->order_status; ?>
                                                        <tr>
                                                            <td style="padding-left:0px;background-color: #ebebeb;border-bottom: 1px solid grey;">
                                                                <a href="<?php echo generate_url("order_details") . "/" . get_order($order->order_id)->order_number; ?>">
                                                                    <div class="table-item-product">

                                                                        <div class="left">
                                                                            <div class="img-table">

                                                                                <?php $item = $order->product_id;
                                                                                $product =  get_product($item); ?>
                                                                                <!-- <a href="<?php echo generate_product_url($product); ?>" target="_blank"> -->
                                                                                <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                                                <!-- </a> -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="left">

                                                                            <?php if ($order->order_status == 'completed') : ?>
                                                                                <p style="color: black;">&emsp;Your item is <strong class="font-600">Delivered</strong></p>
                                                                            <?php elseif ($items == "shipped" || $items == "out_for_delivery") : ?>
                                                                                <p style="color: #FF3334;">Your item is <strong class="font-600">on its way</strong></p>
                                                                            <?php elseif ($items == "cancelled_by_seller" || $items == "cancelled_by_user") : ?>
                                                                                <p style="color: red;">Your item is <strong class="font-600">cancelled</strong></p>
                                                                            <?php elseif ($items == "rejected") : ?>
                                                                                <p style="color: red;">Your item is <strong class="font-600">rejected</strong></p>
                                                                            <?php else : ?>
                                                                                <p style="color: #FF3334;">&emsp;Your item is <strong class="font-600">under process</strong></p>
                                                                            <?php endif; ?>





                                                                        </div>
                                                                        <div class="right">
                                                                            <i class="icon-arrow-right" style="color:black;float: right;"></i>
                                                                        </div>

                                                                    </div>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($orders)) : ?>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="box box-primary">
                                                    <div class="box-body">
                                                        <div class="row" style="margin: 10px; padding: 15px;border-radius: 20px;">
                                                            <div class="col-12">
                                                                <!-- form start -->
                                                                <center>
                                                                    <h1> No Orders To Show </h1>
                                                                    <br>
                                                                    <p>
                                                                    <h4>
                                                                        Order section is empty. After placing order, You can track them from here!
                                                                    </h4>
                                                                    </p>
                                                                    <br>
                                                                    <img src="<?php echo base_url() . "/assets/img/order.png" ?>">

                                                                </center>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row-custom m-t-15">
                                <div class="float-right" style="float: right;">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wrapper End-->
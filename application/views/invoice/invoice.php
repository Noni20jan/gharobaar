<?php defined('BASEPATH') or exit('No direct script access allowed');

$inv = $this->order_model->get_seller_invoice_no($order->id);
//var_dump($inv);
//var_dump($invoice);
// var_dump($order_products->seller_id);
$sellers = array();
if ($this->auth_user->role != "admin" && $order->buyer_id != $this->auth_user->id) :
    array_push($sellers, get_seller($this->auth_user->id));
else :
    foreach ($order_products as $order_product) {
        $seller_data = get_seller($order_product->seller_id);
        $exist = false;
        foreach ($sellers as $seller) {
            if ($seller->id == $seller_data->id) {
                $exist = true;
            }
        }
        if (!$exist)
            array_push($sellers, get_seller($order_product->seller_id));
    }
endif;
$ordership = get_order_shipping($order->id);
// var_dump($seller);
function convert_number_to_words($number)
{

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' rupees paisa ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        100000             => 'lakh',
        10000000          => 'crore'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        case $number < 100000:
            $thousands   = ((int) ($number / 1000));
            $remainder = $number % 1000;

            $thousands = convert_number_to_words($thousands);

            $string .= $thousands . ' ' . $dictionary[1000];
            if ($remainder) {
                $string .= $separator . convert_number_to_words($remainder);
            }
            break;
        case $number < 10000000:
            $lakhs   = ((int) ($number / 100000));
            $remainder = $number % 100000;

            $lakhs = convert_number_to_words($lakhs);

            $string = $lakhs . ' ' . $dictionary[100000];
            if ($remainder) {
                $string .= $separator . convert_number_to_words($remainder);
            }
            break;
        case $number < 1000000000:
            $crores   = ((int) ($number / 10000000));
            $remainder = $number % 10000000;

            $crores = convert_number_to_words($crores);

            $string = $crores . ' ' . $dictionary[10000000];
            if ($remainder) {
                $string .= $separator . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        if ($fraction < 21) {
            $string .= $dictionary[$fraction * 10];
        }
        // if ($fraction < 21) {
        //     $string .= $dictionary[$fraction];
        // }
        // foreach (str_split((string) $fraction) as $number) {
        //     $words[] = $dictionary[$number];
        // }
        else {
            $string .= convert_number_to_words($fraction);
        }
    }

    return $string;
}
?>
<style>
    body {
        font-size: 14px !important;
    }

    .table td,
    .table th {
        padding: 5px !important;
    }

    .logo img {
        width: 160px;
        height: auto;
    }

    .sign {
        margin-top: 15px;
        text-align: center;
        border: 1px;
        justify-content: center;
        flex-direction: column;
        background: lavender;
        height: 110px;
    }

    .seller_sign {
        padding-bottom: 15px;
    }

    table {
        border-bottom: 1px solid #dee2e6;
    }

    table th {
        font-size: 14px;
        white-space: nowrap;
    }

    .order-total {
        width: 700px;
        max-width: 100%;
        float: right;
        /* padding: 20px; */
        padding-left: 15px;
        padding-right: 30px;
    }

    .sign_box {
        width: 350px;
        max-width: 100%;
        float: right;
        /* padding: 20px; */
        padding-left: 15px;
        padding-right: 30px !important;
    }


    .order-total .col-left {
        font-weight: 600;
    }

    .order-total .col-right {
        text-align: right;
    }

    #btn_print {
        min-width: 180px;
    }

    @media print {
        .hidden-print {
            display: none !important;
        }
    }
</style>


<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
    <meta name="description" content="<?php echo xss_clean($description); ?>" />
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>" />
    <meta name="author" content="Codingest" />
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>" />
    <meta property="og:locale" content="en-US" />
    <meta property="og:site_name" content="<?php echo xss_clean($this->general_settings->application_name); ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" />
</head>

<body>

    <div class="container">
        <div class="row" style="padding-top: 20px;">
            <div class="col-12">

                <?php //$show_all_products = true;
                //$prefix = "";
                // if ($this->auth_user->role != "admin" && $order->buyer_id != $this->auth_user->id) {
                $show_all_products = false;
                $prefix = "";
                // } 
                ?>
                <?php foreach ($sellers as $sel_array) : ?>
                    <div class="container-invoice">
                        <div id="content" class="card">
                            <div class="card-body invoice p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <h1 style="text-align: center; font-size: 36px;font-weight: 400;margin-top: 20px;"><?= trans("invoice"); ?></h1>
                                    </div>
                                </div>
                                <div class="row" style="padding: 0px 30px;">
                                    <div class="col-6">
                                        <div class="logo">
                                            <img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"><br>
                                            <img src="<?php echo base_url(); ?>assets/img/hc_logo.jpg" alt="logo">
                                        </div>
                                        <small><?php echo trans("date"); ?>: <?php echo $order->created_at ?></small>
                                        <!-- <div>
                                        <?= $this->settings->contact_address; ?>
                                    </div> -->
                                    </div>

                                    <div class="col-md-6">
                                        <div class="float-right" style="padding-right:40px;">

                                            <p class="font-weight-bold mb-1"><span style="display: inline-block;width: 100px;"><?php echo trans("seller_invoice"); ?>: </span><?php echo $inv[0]->invoice_no; ?></p>
                                            <p class="font-weight-bold"><span style="display: inline-block;width: 100px;"><?php echo trans("order_date"); ?>:</span><?php echo helper_date_format($order->created_at); ?></p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row" style="padding: 5px 30px;">
                                    <div class="col-6">
                                        <p class="font-weight-bold mb-3">Seller Information</p>



                                        <?php $seller = $sel_array; ?>
                                        <p class="mb-1"><?= html_escape($seller->first_name); ?>&nbsp;<?= html_escape($seller->last_name); ?></p>
                                        <p class="mb-1"><?= html_escape($seller->shop_name); ?></p>

                                        <p class="mb-1"><?= html_escape($seller->house_no); ?>&nbsp;<?= html_escape($seller->supplier_area); ?></p>
                                        <?php
                                        if (!empty($seller->supplier_city)) : ?>
                                            <p class="mb-1"><?= html_escape($seller->supplier_city); ?>&nbsp;<?= html_escape($seller->supplier_state); ?></p>
                                            <p class="mb-1">India , &nbsp;<?= html_escape($seller->pincode); ?></p>
                                        <?php endif;

                                        if (!empty($seller->phone_number)) : ?>
                                            <p class="mb-1"><?= html_escape($seller->phone_number); ?></p>

                                        <?php endif; ?>

                                    </div>
                                    <div class="col-6">
                                        <div class="float-right">
                                            <p class="font-weight-bold mb-3">Shipping Address</p>
                                            <p class="mb-1"><?= html_escape($ordership->shipping_first_name); ?>&nbsp;<?= html_escape($ordership->shipping_last_name); ?></p>
                                            <p class="mb-1"><?= html_escape($ordership->shipping_area); ?> , <?= html_escape($ordership->shipping_address_1); ?></p>
                                            <p class="mb-1"><?= $ordership->shipping_city ?> , <?= html_escape($ordership->shipping_state); ?></p>


                                            <p class="mb-1"><?= $ordership->shipping_country  ?> , <?= html_escape($ordership->shipping_zip_code); ?></p>

                                            <p class="mb-1"><?= html_escape($ordership->shipping_phone_number); ?></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="padding: 5px 30px;">
                                    <div class="col-6">
                                        <p class="mb-1"><b>PAN Number -</b> <?= html_escape($seller->pan_number); ?></p>
                                        <p class="mb-1"><b>GST Number -</b><?= html_escape($seller->gst_number); ?></p>
                                        <br>
                                        <p class="mb-1"><b>Order Number -</b> <?= html_escape($order->id); ?></p>
                                        <p class="mb-1"><b>Order Date -</b><?php echo helper_date_format($order->created_at); ?></p>
                                        <p class="mb-1" style="margin-top: 10px;"><b>State/UT Code:</b><?= html_escape($ordership->state_code); ?></p>
                                        <p class="mb-1"><b>Place of Supply:</b><?= html_escape($ordership->shipping_state); ?></p>
                                    </div>
                                    <div class="col-6">
                                        <div class="float-right">
                                            <p class="font-weight-bold mb-3">Billing Address</p>
                                            <p class="mb-1"><?= html_escape($ordership->billing_first_name); ?>&nbsp;<?= html_escape($ordership->billing_last_name); ?></p>
                                            <p class="mb-1"><?= html_escape($ordership->billing_area); ?> , <?= html_escape($ordership->billing_address_1); ?></p>
                                            <p class="mb-1"><?= html_escape($ordership->billing_city); ?> , <?= $ordership->billing_state ?></p>
                                            <p class="mb-1"><?= $ordership->billing_country ?> , <?= html_escape($ordership->billing_zip_code); ?></p>
                                            <p class="mb-1"><?= html_escape($ordership->billing_phone_number); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding:20px">
                                    <div class="table-responsive" style="border: solid 1px;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <!-- <th class="border-0 font-weight-bold"><?php echo trans("seller"); ?></th> -->
                                                    <th class="border-0 font-weight-bold">S.No</th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("description"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("hsn_invoice"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("quantity"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("unit_price"); ?></th>
                                                    <!-- <?php if ($this->general_settings->gst_status) : ?>
                                                        <th class="border-0 font-weight-bold"><?php echo trans("vat"); ?></th>
                                                    <?php endif; ?> -->
                                                    <th class="border-0 font-weight-bold">Net Amount</th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("discount"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("gst_excluded_price"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("igst"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("cgst"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("sgst"); ?></th>
                                                    <?php if($order_product->product_total_price<50000){?>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("shipping"); ?></th>
                                                    <?php }?>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("total"); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $shipping_value=0;
                                                if ($show_all_products) {
                                                    $sale_subtotal = $order->price_subtotal;
                                                    $sale_gst = $order->price_gst;
                                                    $sale_shipping = $order->price_shipping;
                                                    $sale_total = $order->price_total;
                                                } else {
                                                    $sale_subtotal = 0;
                                                    $sale_gst = 0;
                                                    $sale_shipping = 0;
                                                    $sale_total = 0;
                                                }

                                                $is_order_has_physical_product = false;

                                                if (!empty($invoice_items) && is_array($invoice_items)) :
                                                    foreach ($invoice_items as $item) :
                                                        $order_product_id = @$item['id'];
                                                        $seller = @$item['seller'];
                                                        $order_product_total_by_seller = 0;
                                                        if (!empty($order_product_id)) :
                                                            $order_product = $this->order_model->get_order_product($order_product_id);

                                                            if (!empty($order_product)) :
                                                                if ($order_product->product_type == 'physical') {
                                                                    $is_order_has_physical_product = true;
                                                                }
                                                                if ($order_product->seller_id == $sel_array->id) :
                                                                    if ($order_product->buyer_id == $this->auth_user->id || $order_product->seller_id == $this->auth_user->id || $this->auth_user->role == "admin") :
                                                                        if ($show_all_products == false) :
                                                                            $sale_subtotal += $order_product->product_unit_price * $order_product->product_quantity;
                                                                            $sale_gst += $order_product->product_gst;
                                                                            $sale_shipping += $order_product->product_shipping_cost;
                                                                            $cod_charges = $order_product->product_cod_charges;
                                                                            $taxes = $order_product->product_tax_charges;
                                                                            $sale_total += $order_product->product_total_price;
                                                                            $sale_seller_total = $sale_total;
                                                                            $gb_total = $order_product->total_shipping_cost + $order_product->total_cod_charges;

                                                                            $sale_shipping = $order_product->product_shipping_cost;
                                                                            $sale_shipping_igst = $order_product->shipping_igst;
                                                                            $sale_shipping_cgst = $order_product->shipping_cgst;
                                                                            $sale_shipping_sgst = $order_product->shipping_sgst;
                                                                            $sale_total_shipping_cost = $order_product->total_shipping_cost;

                                                                            $sale_cod = $order_product->product_cod_charges;
                                                                            $sale_cod_igst = $order_product->cod_igst;
                                                                            $sale_cod_cgst = $order_product->cod_cgst;
                                                                            $sale_cod_sgst = $order_product->cod_sgst;
                                                                            $sale_total_cod_cost = $order_product->total_cod_charges;

                                                                        endif; ?>
                                                                        <tr style="font-size: 15px;">
                                                                            <!-- <td><?php echo html_escape($seller); ?></td> -->
                                                                            <td>1</td>
                                                                            <td><?php echo $order_product->product_title; ?>
                                                                                <span style="font-style:italic"><?php echo trans("bhogan_by_gharobaar"); ?></span>
                                                                            </td>
                                                                            <td><?php echo $order_product->hsn_code; ?></td>
                                                                            <td><?php echo $order_product->product_quantity; ?></td>
                                                                            <td><?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?></td>

                                                                            <!-- <td><?php echo $order_product->product_igst; ?></td> -->
                                                                            <td><?php
                                                                                $net_price = $order_product->product_unit_price * $order_product->product_quantity;
                                                                                echo price_formatted($net_price, $order_product->product_currency); ?></td>
                                                                            <td>-<?php echo price_formatted_without_round($order_product->product_discount_amount * 100 * $order_product->product_quantity, $order_product->product_currency); ?></td>
                                                                            <td><?php echo price_formatted_without_round($order_product->price_excluded_gst, $order_product->product_currency); ?></td>
                                                                            <td><?php echo price_formatted_without_round($order_product->product_igst, $order_product->product_currency); ?></td>
                                                                            <td><?php echo price_formatted_without_round($order_product->product_cgst, $order_product->product_currency); ?></td>
                                                                            <td><?php echo price_formatted_without_round($order_product->product_sgst, $order_product->product_currency); ?></td>
                                                                            <?php if($order_product->product_total_price<50000){?>
                                                                            <td><?php echo price_formatted(10000, $order_product->product_currency); ?></td>
                                                                            <?php }?>
                                                                            <?php if($order_product->product_total_price<50000):
                                                                            $order_product->product_total_price += 10000;
                                                                            endif;?>
                                                                            <td><?php echo price_formatted($order_product->product_total_price, $order_product->product_currency); ?></td>


                                                    <?php endif;
                                                                endif;
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                endif; ?>
                                                                        </tr>

                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b><?php echo trans("total") ?></b></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <?php if($order_product->product_total_price<50000){?>
                                                                            <td></td>
                                                                            <?php }?>
                                                                            <td><b><?php echo price_formatted_without_round($order_product->product_total_price, $order_product->product_currency); ?></b></td>
                                                                        </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-md-8 order-total float-left">
                                            <div class="row" style="padding-left:  30px;">
                                                <b>Amount in words: &nbsp;</b>
                                                <?php if ($show_all_products == false) : ?>
                                                    <?php
                                                    $test = (($order_product->product_total_price) / 100);

                                                    echo convert_number_to_words($test); ?>
                                                <?php else : ?>
                                                    <?php
                                                    $test = (($order->price_total) / 100);

                                                    echo convert_number_to_words($test); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div style="padding: 0px 15px; font-size:12px;">
                                                <p class="font-weight-bold" style="margin-bottom: 0px;"><?php echo trans("payment_details"); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("payment_status"); ?>:</span><?= get_payment_status($order->payment_status); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("payment_method"); ?>:</span><?= get_payment_method($order->payment_method); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("currency"); ?>:</span><?php echo $order->price_currency; ?></p>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6"> -->

                                        <!-- </div> -->
                                        <div class="col-md-4 sign_box ">

                                            <!-- <div class="row mb-2">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("subtotal"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <?php if ($show_all_products == false) : ?>
                                                        <strong class="font-600"><?php echo price_formatted($sale_total, $order_product->product_currency); ?></strong>
                                                    <?php else : ?>
                                                        <strong class="font-600"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></strong>
                                                    <?php endif; ?>
                                                </div>
                                            </div> -->
                                            <!-- <?php if (!empty($sale_gst)) : ?>
                                            <div class="row mb-2">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("vat"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo price_formatted($sale_gst, $order->price_currency); ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?> -->
                                            <!-- <?php if ($is_order_has_physical_product) : ?>
                                                <div class="row mb-2">
                                                    <div class="col-6 col-left">
                                                        <?php echo trans("shipping"); ?>
                                                    </div>
                                                    <div class="col-6 col-right">
                                                        <?php if ($show_all_products == false) : ?>
                                                            <strong class="font-600"><?php echo price_formatted($sale_shipping, $order->price_currency); ?></strong>
                                                        <?php else : ?>
                                                            <strong class="font-600">+ <?php echo price_formatted($order->price_shipping, $order->price_currency); ?></strong>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if (!empty($order->total_cod_charges)) : ?>
                                                    <div class="row mb-2">
                                                        <div class="col-6 col-left">
                                                            <?php echo trans("cod_charges"); ?>
                                                        </div>
                                                        <div class="col-6 col-right">
                                                            <?php if ($show_all_products == false) : ?>
                                                                <strong class="font-600"><?php echo price_formatted($cod_charges, $order->price_currency); ?></strong>
                                                            <?php else : ?>
                                                                <strong class="font-600">+ <?php echo price_formatted($order->total_cod_charges, $order->price_currency); ?></strong>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($order->total_tax_charges)) : ?>
                                                    <div class="row mb-2">
                                                        <div class="col-6 col-left">
                                                            <?php echo trans("taxes"); ?>
                                                        </div>
                                                        <div class="col-6 col-right">
                                                            <?php if ($show_all_products == false) : ?>
                                                                <strong class="font-600"><?php echo price_formatted($taxes, $order->price_currency); ?></strong>
                                                            <?php else : ?>
                                                                <strong class="font-600">+ <?php echo price_formatted($order->total_tax_charges, $order->price_currency); ?></strong>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?> -->
                                            <!-- <div class="row mb-2">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("total"); ?>
                                                </div>

                                                <div class="col-6 col-right">
                                                    <?php if ($show_all_products == false) : ?>
                                                        <strong class="font-600"><?php echo price_formatted($sale_seller_total, $order->price_currency); ?></strong>
                                                    <?php else : ?>
                                                        <strong class="font-600"><?php echo price_formatted($order->price_subtotal + $order->price_shipping + $order->total_cod_charges + $order->total_tax_charges, $order->price_currency); ?></strong>
                                                    <?php endif; ?>
                                                </div>

                                            </div> -->
                                            <div class="row mb-2 sign">
                                                <div class="seller_sign">
                                                    <?php //if (count($sellers) == 1) :
                                                    echo html_escape($sel_array->first_name) . "&nbsp" . html_escape($sel_array->last_name);
                                                    // else :
                                                    //     echo ("gharobaar sign");
                                                    // endif; 
                                                    ?>
                                                </div>
                                                <div>
                                                    <?php echo trans("seller_sign"); ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- Gharobaar invoice format start  -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="padding-left: 30px;">
                                            <div class="float-left">
                                                <p class="font-weight-bold mb-3">Shipping Address</p>
                                                <p class="mb-1"><?= html_escape($ordership->shipping_first_name); ?>&nbsp;<?= html_escape($ordership->shipping_last_name); ?></p>
                                                <p class="mb-1"><?= html_escape($ordership->shipping_area); ?> , <?= html_escape($ordership->shipping_address_1); ?></p>
                                                <p class="mb-1"><?= $ordership->shipping_city ?> , <?= html_escape($ordership->shipping_state); ?> ,<?= $ordership->shipping_country  ?> , <?= html_escape($ordership->shipping_zip_code); ?></p>

                                                <p class="mb-1"><?= html_escape($ordership->shipping_phone_number); ?></p>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-left">
                                                <p class="font-weight-bold mb-3">Billing Address</p>
                                                <p class="mb-1"><?= html_escape($ordership->billing_first_name); ?>&nbsp;<?= html_escape($ordership->billing_last_name); ?></p>
                                                <p class="mb-1"><?= html_escape($ordership->billing_area); ?> , <?= html_escape($ordership->billing_address_1); ?></p>
                                                <p class="mb-1"><?= html_escape($ordership->billing_city); ?> , <?= $ordership->billing_state ?>, <?= $ordership->billing_country ?> , <?= html_escape($ordership->billing_zip_code); ?></p>
                                                <p class="mb-1"><?= html_escape($ordership->billing_phone_number); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding: 20px;">
                                    <p class="font-weight-bold mb-1" style="padding: 5px;"><span><?php echo trans("gb_invoice"); ?>: </span>GB/22-23/395/10005</p>
                                    <div class="table-responsive" style="border: solid 1px;">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="border-0 font-weight-bold">S.No</th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("description"); ?></th>
                                                    <th class="border-0 font-weight-bold">Net Amount(excluding GST)</th>
                                                    <th class="border-0 font-weight-bold">GST %</th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("igst"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("cgst"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("sgst"); ?></th>
                                                    <th class="border-0 font-weight-bold"><?php echo trans("total"); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><?php echo trans("shipping") ?></td>
                                                    <td><?php echo price_formatted($sale_shipping, $order_product->product_currency); ?></td>
                                                    <td>18%</td>
                                                    <td><?php echo price_formatted_without_round($sale_shipping_igst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_shipping_cgst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_shipping_sgst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_total_shipping_cost, $order_product->product_currency); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td><?php echo trans("cod_charges") ?></td>
                                                    <td><?php echo price_formatted($sale_cod, $order_product->product_currency); ?></td>
                                                    <td>18%</td>
                                                    <td><?php echo price_formatted_without_round($sale_cod_igst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_cod_cgst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_cod_sgst, $order_product->product_currency); ?></td>
                                                    <td><?php echo price_formatted_without_round($sale_total_cod_cost, $order_product->product_currency); ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><b><?php echo trans("total") ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b><?php echo price_formatted_without_round($gb_total, $order_product->product_currency); ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Gharobaar invoice format end  -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-md-8 order-total float-left">
                                            <div class="row" style="padding-left:  30px;">
                                                <b>Amount in words: &nbsp;</b>
                                                <?php if ($show_all_products == false) : ?>
                                                    <?php
                                                    $test = (($gb_total) / 100);

                                                    echo convert_number_to_words($test); ?>
                                                <?php else : ?>
                                                    <?php
                                                    $test = (($order->price_total) / 100);

                                                    echo convert_number_to_words($test); ?>
                                                <?php endif; ?>
                                            </div>
                                            <div style="padding: 0px 15px; font-size:12px;">
                                                <p class="font-weight-bold" style="margin-bottom: 0px;"><?php echo trans("payment_details"); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("payment_status"); ?>:</span><?= get_payment_status($order->payment_status); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("payment_method"); ?>:</span><?= get_payment_method($order->payment_method); ?></p>
                                                <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("currency"); ?>:</span><?php echo $order->price_currency; ?></p>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6"> -->

                                        <!-- </div> -->
                                        <div class="col-md-4 sign_box float-right">
                                            <div class="row mb-2 sign">
                                                <div class="seller_sign">
                                                    <?php //if (count($sellers) == 1) :
                                                    echo html_escape("gharobaar");
                                                    // else :
                                                    //     echo ("gharobaar sign");
                                                    // endif; 
                                                    ?>
                                                </div>
                                                <div>
                                                    <?php echo trans("seller_sign"); ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p>&nbsp; <?php echo trans("invoice_footer"); ?></p>
    </div>

    <div class="container" style="margin-bottom: 100px;">
        <div class="row">
            <div class="col-12 text-center mt-3">
                <button id="btn_print" class="btn btn-secondary btn-md hidden-print">
                    <svg id="i-print" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-top: -4px;">
                        <path d="M7 25 L2 25 2 9 30 9 30 25 25 25 M7 19 L7 30 25 30 25 19 Z M25 9 L25 2 7 2 7 9 M22 14 L25 14" />
                    </svg>
                    &nbsp;&nbsp;<?php echo trans("print"); ?></button>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script>
        $(document).on('click', '#btn_print', function() {
            window.print();
        });
    </script>
</body>

</html>
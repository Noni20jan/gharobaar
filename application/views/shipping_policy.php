<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    #wrapper {
        padding-bottom: 5%;
    }

    .shipping_policy {
        text-align: center;
        margin-bottom: 5%;
        margin-top: 5%;
    }

    .shipping-content {
        font-size: 20px;
        font-weight: 500;
        text-align: justify;
    }

    .for-contact {
        color: #0060B6 !important;
        text-decoration: none !important;
    }

    .for-contact:hover,
    .for-contact:active,
    .for-contact:focus {
        color: #00A0C6 !important;
        text-decoration: none;
        cursor: pointer;
    }

    .image7 {
        width: 104.5%;
        margin-left: -30px;
    }

    h3 {
        line-height: 60px;
    }

    @media (max-width: 768px) {
        .svg-fotter {
            position: absolute;
            top: -9%;
            left: 0;
        }

        .image7 {
            width: 106%;
            margin-left: -30px;
        }

        .shipping-content {
            font-size: 18px;
        }
    }
</style>
<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="shipping_policy">
            <h1 style="font-weight:700;">Shipping Policy</h1>
        </div>
        <div class="shipping-content">
            <p>
                We currently deliver across India, and have tied up with a reliable logistics partner that ensures reliable delivery of non-perishable items across cities.
            </p>
            <p>
                For perishable goods, we have another logistics partner that will pick your products from the seller and hand deliver it to you (This service is currently available only within Delhi-NCR). We try our very best to ensure that there are no delays in shipments, but sometimes it's beyond our control.
            </p>
            <h3><u>Shipping Time</u></h3>


            <ul style="list-style-type:disc">
                <li>Since we are working with homepreneurs, a number of products are made to order, and the dispatch time/lead time for every product is different. The same is visible on every product page.</li>
                <li>Once the product is ready for dispatch, a notification is sent to our delivery partner by the seller, and the same is then picked for delivery.</li>
                <li>For delivery of non-perishable items, shipping is done on all days (Monday to Saturday) except Sundays and public holidays.</li>
                <li>For delivery of perishable items, shipping and delivery is done all days of the week on the same day.</li>
            </ul>

            <h3><u>Shipping Charges</u></h3>

            <p><u>For non-perishable items delivered Pan-India</u></p>

            <p>
                Shipping charges would depend on the order value from one single seller, and whether or not the seller offers free shipping on the products.
            </p>
            <p>
                For all products that are not offered for free shipping by the sellers, the shipping charges would be as follows:
            </p>

            <ul style="list-style-type:disc">
                <li>For order value less than Rs. 500 (from one seller), shipping charges would be calculated on actuals depending on the delivery distance and the weight/volumetric weight of the products.</li>
                <li>For order value between Rs. 500 and 2000 (from one seller), a flat shipping fee of Rs. 100* would be levied on prepaid orders. A convenience fee of Rs. 50* would be applied on all COD (Cash on Delivery) orders.</li>
                <li>For order value more than Rs. 2000 (from one seller), shipping would be free for prepaid orders. A convenience fee of Rs. 50* would be applied on all COD (Cash on Delivery) orders.</li>
            </ul>

            <p><u>For perishable items delivery in Delhi-NCR</u></p>
            <ul style="list-style-type:disc">
                <li>
                    Shipping charges would be calculated at the time of checkout depending on the distance and the number of items.
                </li>
            </ul>

            <h3><u>Shipment Delays</u></h3>

            <p>
                In case your shipment is delayed, please send us an email on <a class="for-contact" href="mailto:<?php echo trans('contact_gharobaar');?>"><?php echo trans('contact_gharobaar');?></a> with your order number.
            </p>
            <p>
                In the unfortunate scenario that your shipment has been misplaced or lost enroute, we can either resend the order to you (if the same products are still in stock), or issue a credit note to you, or reimburse the amount completely to you.
            </p>
            <p>
                Kindly ensure that while taking delivery, the package is not tampered with. In case you feel anything is amiss, kindly mention it on the Proof of Delivery given to the courier company. This would help us in providing quick resolutions in case of any dispute.
            </p>



            <p>*Plus applicable taxes</p>
        </div>
    </div>
</div>
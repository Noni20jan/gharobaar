<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .label {
        border: 1px solid #000
    }




    @font-face {
        font-family: 'Glyphicons Halflings';
        src: url(../fonts/glyphicons-halflings-regular.eot);
        src: url(../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'), url(../fonts/glyphicons-halflings-regular.woff2) format('woff2'), url(../fonts/glyphicons-halflings-regular.woff) format('woff'), url(../fonts/glyphicons-halflings-regular.ttf) format('truetype'), url(../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')
    }



    ol,
    ul {
        margin-top: 0;
        margin-bottom: 10px
    }

    ol ol,
    ol ul,
    ul ol,
    ul ul {
        margin-bottom: 0
    }

    .list-unstyled {
        padding-left: 0;
        list-style: none
    }

    .list-inline {
        padding-left: 0;
        margin-left: -5px;
        list-style: none
    }

    .list-inline>li {
        display: inline-block;
        padding-right: 5px;
        padding-left: 5px
    }

    .date_info {
        padding: 0;
        margin-bottom: 74px;
    }

    .date_info li {
        float: left;
        list-style: none;
        margin-right: 3%;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        -webkit-transition: 0.3s;
        color: #555;
    }






    /*Innerpage Css Start*/

    .inner_page .hp_cards {
        margin-top: 42px;
    }

    .inner_page .hp_cards_info h5 {
        font-size: 15px;
        margin: 9px 0 0;
        border-bottom: 1px solid #CFD4D6;
        /*color: #000;*/
        padding-bottom: 21px;
        padding-left: 35px;
        font-weight: 400;
    }

    .inner_page .hp_cards_info {
        padding: 17px 15px 1px;
        background: #fff;
        border-radius: 10px 10px 0px 0px;
        -webkit-border-radius: 10px 10px 0px 0px;
    }



    .inner_page .hp_cards_info h5 a:hover,
    .inner_page .hp_cards_info h5 a:focus {
        text-decoration: none;
        color: #285ddb;
    }

    .inner_page .hp_cards_info .mb-20 {
        margin-top: 20px;
        margin-bottom: 20px;
    }



    .courier_info span,
    .courier_info a {
        display: block;
    }

    .courier_info {
        background: #fff;
        padding: 23px 23px 0px 18px;
    }

    .courier_logo {
        background-color: #ddd;
        background-size: contain;
        -webkit-background-size: contain;
        border-radius: 5px;
        width: 75px;
        height: 65px;
        margin-right: 15px;
    }

    .courier_info span:first-child {
        margin-bottom: 5px;
        margin-top: 9px;
    }

    .tracking_id {
        color: #285ddb;
    }

    .courier_info a,
    .courier_info a:focus,
    .courier_info a:hover {
        text-decoration: none;
        color: #285ddb;
    }

    .delievery_info {
        padding: 0px;
        position: relative;
        background: #fff;
        overflow: hidden;
        border-radius: 0 0 10px 10px;
        -webkit-border-radius: 0 0 10px 10px;
        bottom: 38px;
    }

    .delievery_info ul {
        padding: 0;
        width: 76%;
        float: right;
        margin: 0;
    }

    .delievery_info li {
        list-style: none;
        background: #fff;
        padding: 24px 0px;
        border-bottom: 1px solid #e8e8e8;
        position: relative;
        margin-right: 10px;
    }

    .delievery_info li:last-child {
        margin-bottom: 0;
    }

    .delievery_info li span:first-child {
        display: block;
        margin-bottom: 12px;
    }

    .delievery_info li span span {
        display: inline;
    }

    .status_cont {
        max-width: 90%;
    }

    @media(max-width: 767px) {
        .courier_info {
            padding: 23px 23px 23px 15px;
        }

        .courier_info span,
        .courier_info a {
            font-size: 14px;
        }

        .delievery_info li {
            margin-right: 5px;
            padding: 15px;
        }

        .delievery_info li span:first-child {
            display: block;
            margin-bottom: 5px;
        }

        .delievery_info ul {
            width: 67%;
        }

        .date_info_wrap {
            left: -53%;
            top: 22px;
        }

        .delievery_info li:after {
            left: -14%;
            top: 51px;
        }

        .delievery_info li::before {
            left: -24px;
            top: 21px;
            border-width: 12px;
        }

        .circle_icon {
            top: 34px;
            left: -31px;
        }

        .delievery_info {
            background: #fff;
            border: none;
            border-radius: 0px 0px 10px 10px;
            -webkit-border-radius: 0px 0px 10px 10px;
            padding-left: 8px;
            padding-right: 8px;
            padding-top: 0px;
            margin-bottom: 0;
            padding-bottom: 12px;
        }


        .inner_page .hp_cards {
            margin-top: 20px;
        }

        .inner_page .hp_cards_info {
            padding: 15px 15px 1px;
        }

        .inner_page .hp_cards_info h5,
        .inner_page .hp_cards_info h5 a {
            font-size: 14px;
            padding-bottom: 17px;
        }

        .inner_page .hp_cards_info h5 i.fa-cube,
        .inner_page .hp_cards_info h5 i {
            font-size: 23px;
        }

        /*	.inner_page .hp_cards_info h5 a i,.delievery_status strong{
		font-size: 25px;
	}*/
        /*	.delievery_status strong{
		margin-bottom: 11px;
	}*/

        .delievery_list_wrap {
            max-height: 255px;
            height: auto;
        }


        .courier_logo {
            margin-right: 12px;
        }
    }



    #date_now {
        position: relative;
        right: 99px;
        bottom: 44px;
        color: #434343;
        font-weight: bold;
        font-size: 14px;

    }

    #time_now {
        position: relative;
        right: 108px;
        bottom: 45px;
        text-align: right;
        font-size: 14px;
        font-weight: bold;
    }

    @media(max-width:1024px) {
        #date_now {
            position: relative;
            right: 115px;
            bottom: 44px;
            color: #434343;
            font-weight: bold;
            font-size: 14px;


        }

        #time_now {
            position: relative;
            right: 121px;
            bottom: 46px;
        }
    }

    /*.delievery_info li:before{
	content: '';
	display: inline-block;
	position: absolute;
	left: -25px;
	top: 32px;
	background-image: url(../img/card_arrow.png);
	background-repeat: no-repeat;
	height: 35px;
	width: 33px;
}*/
    .delievery_info li .date_info_wrap span:first-child {
        margin-bottom: 1px;
    }

    .delievery_list_wrap {
        max-height: 220px;
        overflow-y: auto;
    }

    .delievery_info li activity {
        color: #737373;
    }

    .delievery_info li:after {
        content: '';
        height: 100%;
        width: 2px;
        display: block;
        position: absolute;
        left: -36px;
        top: 59px;
        z-index: 9;
        border: 1px dashed #dedede;
    }

    .delievery_info li.active .circle_icon {
        border: 3px solid white;
    }

    .delievery_info li:last-child:after {
        display: none;
    }

    .circle_icon {
        height: 16px;
        width: 16px;
        position: absolute;
        left: 0;
        border: 3px solid white;
        box-shadow: 0 0 2px #a8a8a8;
        display: block;
        left: -33px;
        border-radius: 50%;
        background: #a8a8a8;
        z-index: 9;
        top: 42px;
    }

    .delievery_info li.active .circle_icon {
        background: #18F040;
    }

    .delievery_info li.active span span {
        color: #1EA231;
    }









    .delievery_status span,
    .delievery_status strong {
        display: block;
    }

    .delievery_status span {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 14px;

    }

    .delievery_status .edd_day {
        font-weight: bold;
        font-size: 20px;
    }

    .delievery_status .edd_date {
        font-size: 100px;
        line-height: 100px;
        font-weight: normal;
    }

    .delievery_status .edd_month_new {
        display: inline;
        font-size: 22px;
        padding-left: 5px;
        vertical-align: text-bottom;
    }

    .delievery_status .edd_month {
        font-size: 16px;
    }

    .delievery_status #shipment_status {
        font-size: 20px;
        font-weight: normal;
        position: relative;
        bottom: 13px;
        left: 58px;
    }

    .delievery_status strong+span {
        font-size: 20px;
        color: #000;
    }

    .active_delivery {
        color: #1EA231 !important;
    }

    .red_color {
        color: #c81717 !important;
    }

    .info_color {
        color: #e8ac1a !important;
    }

    .delievery_status {
        border-bottom: 1px solid #CFD4D6;
        padding-bottom: 21px;
        margin-bottom: 0 !important;
    }

    .information_block .hp_cards_info {
        border-radius: 10px;
        -webkit-border-radius: 10px;
        position: relative;
        padding-bottom: 2px;
    }

    .information_block .hp_cards_info span,
    .information_block .hp_cards_info strong {
        font-size: 13px;
    }

    .order_detail_icon {
        width: 25px;
        height: 27px;
        background: url(../img/Box.png) no-repeat;
        display: inline-block;
        position: absolute;
        left: 16px;
        top: 21px;
    }

    .cta_btn_wrap {
        float: left;
        display: block;
        width: 100%;
        /*margin: 16px 0 13px;*/
    }

    .cta_btn_wrap a {
        font-size: 18px;
        color: white;
    }

    .cta_btn_wrap button {
        font-size: 16px;
        width: 100%;
        height: 45px;
        line-height: 45px;
        font-weight: 700;
        padding: 0;
        color: #fff;
        border-radius: 5px;
        border: none;
    }

    .cta_btn_wrap button:hover,
    .cta_btn_wrap button:focus {
        color: #fff;
    }

    .success_icon {
        background: url(../img/spritee.png?v=1) no-repeat;
        background-position: -232px -3px;
        width: 55px;
        height: 64px;
        display: block;
        margin: 0 auto 20px;
    }

    .success_info strong {
        display: block;
        font-size: 38px;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .success_info {
        padding: 81px 20px 83px;
    }

    .success_info span {
        font-size: 16px;
        color: #737373;
    }

    .foot_logo img {
        width: 50%;
        margin-top: 4px;
    }

    #shipment_status_label {
        margin-bottom: -15px;
        margin-top: 10px;
    }

    .nps_pagination .arrow_wrap_pagination {
        width: 507.84px;
        margin: 0 auto;
    }

    .edd_info {
        float: left;
        width: 173px;
        position: relative;
        margin-right: 55px;
    }

    .edd_info:last-child {
        margin-right: 0;
    }

    .divider_date {
        background: #000;
        height: 3px;
        width: 20px;
        display: block;
        position: absolute;
        top: 65%;
        right: -10px;
    }

    .delievery_status span.year_txt {
        display: inline-block;
        line-height: 0px;
        color: #333333;
    }

    .mt-15 {
        margin-top: 15px;
    }

    .db {
        display: block;
    }

    @media(max-width: 506px) {
        .multiple_date .edd_info {
            width: 111px;
            margin-right: 12px;
        }

        .multiple_date .edd_date {
            font-size: 60px;
        }

        .multiple_date .edd_info:last-child {
            margin-right: 0;
        }

        .multiple_date .divider_date {
            top: 60%;
            right: -1px;
        }
    }

    @media (min-width: 768px) {
        .multiple_date .edd_info {
            width: 126px;
            margin-right: 30px;
        }

        .multiple_date .edd_info:last-child {
            margin-right: 0;
        }

        .multiple_date .edd_date {
            font-size: 72px;
        }

        .multiple_date .divider_date {
            right: -16px;
        }

    }

    #order_status {
        padding: 25px 15px 25px;
        position: relative;
        background: #fff;
        overflow: hidden;
        border-radius: 0 0 10px 10px;
        -webkit-border-radius: 0 0 10px 10px;
        margin-bottom: 45px;
    }

    .delievery_status {
        border-bottom: 1px solid #CFD4D6;
        padding-bottom: 21px;
        margin-bottom: 0 !important;
    }
</style>

<?php if ($tracking_status === 1) : ?>

    <div id="wrapper">
        <div class="container">
            <div class="content inner_page">

                <div id='main_cont' class="contai">
                    <div class="row">

                        <!-- tracking card -->
                        <div class="col-sm-6 col-xs-12">
                            <div class="hp_cards">

                                <?php if ($c_status == 'Canceled') : ?>
                                    <p>Order canceled</p>
                                <?php else : ?>
                                    <div class="hp_cards_info">
                                        <div class="clearfix  delievery_status">
                                            <div class="pull-left status_cont">
                                                <!-- <span>Status</span> -->
                                                <!-- Delivered or RTO delivered -->

                                                <span id="shipment_status_label">Status:</span>
                                                <strong id="shipment_status">
                                                    <!-- undelivered -->
                                                    <?php if (!empty($c_status)) : ?>
                                                        <?php echo $c_status ?>
                                                    <?php endif; ?>




                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                            </div>


                            <div class="courier_info clearfix">
                                <div class="pull-left courier_logo" style="background-image: url('https://app.shiprocket.co/post_order/img/courier/thumb/delhivery.jpg');background-repeat: no-repeat;">
                                </div>
                                <div class="pull-left">

                                    <span><b><?php echo $check->courier_company_name ?></b></span>
                                    <!-- <a href="#" class="tracking_id">Support?</a> -->
                                </div>

                                <div class="pull-right" style="float:right !important;position:relative;bottom:88px;">
                                    <span><b>Tracking ID</b> </span>
                                    <?php if (!empty($url)) : ?>
                                        <a href="<?php echo $url ?>">
                                        <?php else : ?>
                                            <a href="#">
                                            <?php endif; ?>
                                            <span class="tracking_id">
                                                <?php echo $check->awb_code ?>
                                            </span>
                                            </a>
                                </div>
                            </div>

                            <div class="delievery_info">
                                <div class="delievery_list_wrap clearfix">


                                    <ul>

                                        <?php foreach ($track_statuses as $stat) : ?>
                                            <li>
                                                <span><b>Activity : </b>
                                                    <activity><?php echo $stat->activity ?></activity>
                                                </span>
                                                <?php if (!is_null($stat->location)) : ?>
                                                    <span><b>Location : </b>

                                                        <activity><?php echo $stat->location ?></activity>
                                                    </span>
                                                <?php else : ?>
                                                    <!-- <span><b>D : </b>
                                                            <activity>Not Available</activity> -->
                                                    </span>
                                                <?php endif; ?>
                                                <div class="date_info_wrap">
                                                    <?php $date_new = $stat->date; ?>
                                                    <span class='date' id="date_now"><?php echo date("d M", strtotime($date_new)) ?> </span>
                                                    <span class='time' id="time_now"><?php echo date("h:i A", strtotime($stat->date)) ?></span>
                                                </div>
                                                <i class="circle_icon"></i>
                                            </li>


                                        <?php endforeach; ?>


                                    </ul>




                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <activity>Tracking data not available</activity>
    <?php endif; ?>

        </div>


    </div>
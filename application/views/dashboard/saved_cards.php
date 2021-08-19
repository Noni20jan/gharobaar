<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $cards = get_user_cards($user->id); ?>
<style>
    /* .ccicon {
        height: 38px;
        position: absolute;
        right: 6px;
        top: calc(50% - 17px);
        width: 60px;
    } */

    /* CREDIT CARD IMAGE STYLING */
    .preload * {
        -webkit-transition: none !important;
        -moz-transition: none !important;
        -ms-transition: none !important;
        -o-transition: none !important;
    }

    .container {
        width: 100%;
        max-width: 400px;
        max-height: 250px;
        height: 54vw;

    }

    /* #ccsingle {
        position: absolute;
        right: 15px;
        top: 20px;
    } */

    #ccsingle svg {
        width: 100px;
        max-height: 60px;
    }

    .creditcard svg#cardfront,
    .creditcard svg#cardback {
        width: 100%;
        -webkit-box-shadow: 1px 5px 6px 0px black;
        box-shadow: 1px 5px 6px 0px black;
        border-radius: 22px;
    }

    #generatecard {
        cursor: pointer;
        float: right;
        font-size: 12px;
        color: #fff;
        padding: 2px 4px;
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    /* CHANGEABLE CARD ELEMENTS */
    .creditcard .lightcolor,
    .creditcard .darkcolor {
        -webkit-transition: fill .5s;
        transition: fill .5s;
    }

    .creditcard .lightblue {
        fill: #03A9F4;
    }

    .creditcard .lightbluedark {
        fill: #0288D1;
    }

    .creditcard .red {
        fill: #ef5350;
    }

    .creditcard .reddark {
        fill: #d32f2f;
    }

    .creditcard .purple {
        fill: #ab47bc;
    }

    .creditcard .purpledark {
        fill: #7b1fa2;
    }

    .creditcard .cyan {
        fill: #26c6da;
    }

    .creditcard .cyandark {
        fill: #0097a7;
    }

    .creditcard .green {
        fill: #66bb6a;
    }

    .creditcard .greendark {
        fill: #388e3c;
    }

    .creditcard .lime {
        fill: #d4e157;
    }

    .creditcard .limedark {
        fill: #afb42b;
    }

    .creditcard .yellow {
        fill: #ffeb3b;
    }

    .creditcard .yellowdark {
        fill: #f9a825;
    }

    .creditcard .orange {
        fill: #ff9800;
    }

    .creditcard .orangedark {
        fill: #ef6c00;
    }

    .creditcard .grey {
        fill: #ffffff78;
    }

    .creditcard .greydark {
        fill: #ffffff78;
    }

    /* FRONT OF CARD */
    #svgname {
        text-transform: uppercase;
    }

    #cardfront .st2 {
        fill: #000;
    }
    #cardfront .st21 {
        fill: #FFF;
    }

    #cardfront .st3 {
        font-family: 'Source Code Pro', monospace;
        font-weight: 600;
    }

    #cardfront .st4 {
        font-size: 54.7817px;
    }

    #cardfront .st5 {
        font-family: 'Source Code Pro', monospace;
        font-weight: 400;
    }

    #cardfront .st6 {
        font-size: 33.1112px;
    }

    #cardfront .st7 {
        opacity: 0.6;
        fill: #000;
    }

    #cardfront .st8 {
        font-size: 24px;
    }

    #cardfront .st9 {
        font-size: 36.5498px;
    }

    #cardfront .st10 {
        font-family: 'Source Code Pro', monospace;
        font-weight: 300;
    }

    #cardfront .st11 {
        font-size: 16.1716px;
    }

    #cardfront .st12 {
        fill: #4C4C4C;
    }

    /* BACK OF CARD */
    #cardback .st0 {
        fill: none;
        stroke: #0F0F0F;
        stroke-miterlimit: 10;
    }

    #cardback .st2 {
        fill: #111111;
    }

    #cardback .st3 {
        fill: #F2F2F2;
    }

    #cardback .st4 {
        fill: #D8D2DB;
    }

    #cardback .st5 {
        fill: #C4C4C4;
    }

    #cardback .st6 {
        font-family: 'Source Code Pro', monospace;
        font-weight: 400;
    }

    #cardback .st7 {
        font-size: 27px;
    }

    #cardback .st8 {
        opacity: 0.6;
    }

    #cardback .st9 {
        fill: #FFFFFF;
    }

    #cardback .st10 {
        font-size: 24px;
    }

    #cardback .st11 {
        fill: #EAEAEA;
    }

    #cardback .st12 {
        font-family: 'Rock Salt', cursive;
    }

    #cardback .st13 {
        font-size: 37.769px;
    }



    .creditcard {
        width: 100%;
        max-width: 400px;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
        transition: -webkit-transform 0.6s;
        -webkit-transition: -webkit-transform 0.6s;
        transition: transform 0.6s;
        transition: transform 0.6s, -webkit-transform 0.6s;
        cursor: pointer;
    }

    .creditcard .front,
    .creditcard .back {
        /* position: absolute; */
        width: 100%;
        max-width: 400px;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-font-smoothing: antialiased;
        color: #47525d;
    }

    .creditcard .back {
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }

    .creditcard.flipped {
        -webkit-transform: rotateY(180deg);
        transform: rotateY(180deg);
    }
</style>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/creditCardValidator.css" />
<script src="<?= base_url(); ?>assets/js/creditCardValidator.js"></script>


<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <a data-toggle="modal" data-target="#addcard-modal" class="btn btn-custom pull-right m-r-5"><i class="glyphicon glyphicon-plus"></i> Add New Card</a>
            </div>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="row">


                    <div class="col-sm-12 col-md-9">
                        <div class="row-custom">
                            <div class="profile-tab-content">
                            
                                <?php if (!empty($cards)) : ?>
                                    <?php foreach ($cards as $card) : ?>
                                        <?php if($card->is_active=='1') :?>
                                        <div class="row">
                                            <div class="col-sm">
                                            
                                                <div class="container preload">
                                                <a class="passingID" onclick="edit_card('<?php echo $card->id; ?>')" data-id="<?php echo $card->id; ?>"><i class="icon-edit"></i> &nbsp;<?php echo trans('edit'); ?></a>
                                                    <a href="javascript:void(0)" onclick="delete_item('dashboard_controller/delete_card','<?php echo $card->id; ?>','Are you sure you want to delete this Card?');"><i class="fa fa-times option-icon"></i><?php echo trans('delete'); ?></a>

                                                    <div class="creditcard">
                                                        <div class="front">
                                                            <div id="ccsingle"></div>
                                                            <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                                                <g id="Front">
                                                                    <g id="CardBackground">
                                                                        <g id="Page-1_1_">
                                                                            <g id="amex_1_">
                                                                                <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
    C0,17.9,17.9,0,40,0z" />
                                                                            </g>
                                                                        </g>
                                                                        <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                                                    </g>
                                                                    <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4"><?php echo $card->card_number; ?></text>
                                                                    <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6"><?php echo $card->card_holder_name; ?></text>
                                                                    <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
                                                                    <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
                                                                    <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
                                                                    <g>
                                                                        <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9"><?php echo $card->card_expiry_date; ?></text>
                                                                        <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
                                                                        <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                                                                        <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                                                                    </g>
                                                                    <g id="cchip">
                                                                        <g>
                                                                            <path class="st21" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                                            </g>
                                                            <g>
                                                                <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                                            </g>
                                                            <g>
                                                                <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
    c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
    C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
    c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
    c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                            </g>
                                                            <g>
                                                                <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                                            </g>
                                                            <g>
                                                                <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>

                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (empty($cards)) : ?>

                        <div class="row" style="background-color: #fefefe85;  margin: 10px; padding: 15px;border-radius: 20px;">
                            <div class="col-md-6">
                                <!-- form start -->
                                <center>
                                    <h2> SAVE YOUR CREDIT/DEBIT CARD </h2>
                                    <br>
                                    <p>
                                        It's convenient to pay with saved cards. Your card information will be secure, we use 128-bit encryption
                                    </p>
                                    <br>

                                    <a data-toggle="modal" data-target="#addcard-modal" class="btn btn-custom m-r-5"><i class="glyphicon glyphicon-plus"></i> Add New Card</a>
                                </center>
                            </div>
                            <div class="col-md-6 mustang" style="padding-right: 0px;">


                                <img src="<?php echo base_url(); ?>assets/img/order.png" />

                            </div>

                        </div>
                    <?php endif; ?>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
</div>
<div id="addcard-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h3>Add New Card</h3>
            </div>
            <div class="modal-body">
                <?php echo form_open('dashboard_controller/save_cards'); ?>
                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                <div class="form-group">
                    <label for="email">Bank Name</label>
                    <input type="text" value="" name="bank_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Card Type</label>

                    <select name="card_type" id="card_type" class="form-control" required>
                        <option value="" disabled selected>Select Account Type</option>
                        <option value="Debit card">Debit card</option>
                        <option value="Credit card">Credit card</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Card Holder Name</label>
                    <input type="text" name="card_holder_name" value="" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Card number</label>
                    <input type="text" autocomplete="off" value="" name="card_number" id="credit-card-number" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Expiry Date</label>
                    <input onkeyup="$cc.expiry.call(this,event)" name="card_expiry_date" class="form-control" maxlength="7" placeholder="mm/yyyy">

                </div>
                <div class="form-group">
                    <label for="email">CVV Number</label>
                    <input type="password" value="" name="cvv_number" class="form-control" maxlength="3">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


                <button type="submit" name="submit" class="btn btn-success">Save Card</button>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
<div id="editcard-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div id="response_edit_card"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // enable spacing for credit card number
    $('#credit-card-number').on('keyup', function(e) {
        var val = $(this).val();
        var newval = '';
        val = val.replace(/\s/g, '');
        for (var i = 0; i < val.length; i++) {
            if (i % 4 == 0 && i > 0) newval = newval.concat(' ');
            newval = newval.concat(val[i]);
        }
        $(this).val(newval);
    });
</script>

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_modal_send_review", ["subject" => null]); ?>
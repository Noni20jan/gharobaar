<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $addresses = get_user_addresses($user->id); ?>
<style>
    #wrapper {
        background: #ffffff00;
    }

    @media(max-width:768px) {
        .scroll-for-mobile {
            overflow-y: scroll;
            height: 90vh;
        }
    }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row" style="justify-content:center;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Your Address</h3>
                </div>
                <div class="box-body">
                    <!-- include message block -->
                    <?php //$this->load->view('admin/includes/_messages'); 
                    ?>
                    <div class="row">
                        <?php if (!empty($addresses)) : ?>
                            <?php foreach ($addresses as $address) : ?>
                                <?php if ($address->is_active == "1") : ?>
                                    <div class="col-md-6" style="margin-bottom:15px;">
                                        <div class="col-sm-12" style="background-color: #fefefe85;border-radius: 20px;">
                                            <div class="col-sm-12" style="padding-top: 10px;">
                                                <!-- <div class="col-md-6" style="background-color: #fefefe85;border-radius: 20px;"> -->
                                                <label id="formlabel2"><?php echo $address->f_name; ?></label><br>
                                                <label id="formlabel2"><?php echo $address->h_no; ?> , <?php echo $address->area; ?></label>
                                                <label id="formlabel2"><?php echo $address->landmark; ?></label><br>
                                                <label id="formlabel2"><?php echo $address->city; ?> , <?php echo $address->state; ?></label>
                                                <br> <label id="formlabel2"><?php echo $address->zip_code; ?></label>
                                                <br> <label id="formlabel2">Phone number: <?php echo $address->ph_number; ?></label>
                                                <br> <label id="formlabel2">Email : <?php echo $address->email; ?></label>
                                                <br> <label id="formlabel2"><?php echo $address->address_type; ?></label>
                                                <br>
                                                <hr> <label id="formlabel2"> <a class="passingID" onclick="edit_address('<?php echo $address->id; ?>')" data-id="<?php echo $address->id; ?>"><i class="icon-edit"></i> &nbsp;<?php echo trans('edit'); ?></a> | <a href="javascript:void(0)" onclick="delete_item('dashboard_controller/delete_address','<?php echo $address->id; ?>','Are you sure you want to delete this address?');"><i class="fa fa-times option-icon"></i>&nbsp;<?php echo trans('delete'); ?></a></label>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (empty($addresses)) : ?>
                            No saved Addresses
                        <?php endif; ?>
                    </div>
                </div>
                <a data-toggle="modal" data-target="#addaddress-modal" class="btn btn-custom pull-right m-r-5"><i class="glyphicon glyphicon-plus"></i> Add Address</a>
            </div>
        </div>
    </div>
</div>
<div id="addaddress-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content scroll-for-mobile">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h3>Add New Address</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo form_open('dashboard_controller/save_addresses'); ?>
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <div class="form-group col-md-6">
                        <label for="email">Full name (First and Last name)</label>
                        <input type="text" value="" name="full_name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="text" value="" name="email" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Mobile number</label>
                        <input type="number" name="mobile_number" maxlength="10" value="" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">PIN code</label>
                        <input type="number" autocomplete="off" value="" name="pin_code" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Flat, House no., Building, Company, Apartment</label>
                        <input name="house_number" class="form-control" required>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Area, Colony, Street, Sector, Village</label>
                        <input type="text" value="" name="area" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Landmark</label>
                        <input type="text" value="" name="landmark" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Town/City</label>
                        <input type="text" value="" name="city" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">State / Province / Region</label>
                        <input type="text" value="" name="state" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Address Type</label>

                        <select name="address_type" id="address_type" class="form-control" required>
                            <option value="" disabled selected>Select Address Type</option>
                            <option value="Home(7 am 9 pm delivery)">Home(7 am 9 pm delivery)</option>
                            <option value="Office/commercial (10 am 6 pm delivery)">Office/commercial (10 am 6 pm delivery)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-custom">Save Address</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="editaddress-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="response_edit_address"></div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('body').on('click', '.passingID', function() {
            var adress_id = $(this).attr('data-id');
            console.log(adress_id);
            // document.getElementById("feed_id").value = $(this).attr('data-id');
            console.log($(this).attr('data-id'));
        });
    });

    function edit_address(address_id) {
        var data = {
            "address_id": address_id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "edit-address",
            type: "post",
            data: data,
            success: function(response) {
                //alert(response);
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_edit_address").innerHTML = obj.html_content;
                }
                setTimeout(
                    function() {
                        $("#editaddress-modal").modal('show');
                    }, 200);
            }
        });
    }
</script>


<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_modal_send_review", ["subject" => null]); ?>
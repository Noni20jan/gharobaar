<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">

            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('edit_user'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('membership_controller/edit_user_post', [
                'id' => 'user_edit_details'
            ]); ?>
            <!-- <form method="POST" enctype="multipart/form-data" id="user_edit_details"> -->


            <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="label label-success"><?php echo $user->role; ?></label>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-profile">
                            <img src="<?php echo html_escape(get_user_avatar($user)); ?>" alt="avatar" class="thumbnail img-responsive img-update" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-profile">
                            <p>
                                <a class="btn btn-success btn-sm btn-file-upload">
                                    <?php echo trans('select_image'); ?>
                                    <input name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));" type="file">
                                </a>
                            </p>
                            <p class='label label-info' id="upload-file-info"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo trans('email'); ?></label>
                    <input type="text" class="form-control auth-form-input" id="textEmail" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="<?php echo trans('email'); ?>" required value="<?php echo html_escape($user->email); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <span class="Validation_error" id="email_valid" style="color: #d43f3a;"></span>

                </div>

                <div class="form-group">
                    <label><?php echo trans('username'); ?></label>
                    <input type="text" class="form-control auth-form-input" name="username" placeholder="<?php echo trans('username'); ?>" required value="<?php echo html_escape($user->username); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans('slug'); ?></label>
                    <input type="text" class="form-control auth-form-input" id="slug" name="slug" pattern="^[a-z](-?[a-z])*$" placeholder="<?php echo trans('slug'); ?>" required value="<?php echo html_escape($user->slug); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <p class="Validation_error" id="slug_p"></p>
                </div>
                <div class="form-group">
                    <label><?php echo trans('first_name'); ?></label>
                    <input type="text" class="form-control auth-form-input" id="first_name" name="first_name" pattern="[a-zA-Z ]+" id="first_name" placeholder="<?php echo trans('first_name'); ?>" required value="<?php echo html_escape($user->first_name); ?>" [a-zA-Z]+ <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <p class="Validation_error" id="first_name_p"></p>
                </div>
                <div class="form-group">
                    <label><?php echo trans('last_name'); ?></label>
                    <input type="text" class="form-control auth-form-input" id="last_name" name="last_name" pattern="[a-zA-Z ]+" placeholder="<?php echo trans('last_name'); ?>" required value="<?php echo html_escape($user->last_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <p class="Validation_error" id="last_name_p"></p>
                </div>

                <div class="form-group">
                    <label><?php echo trans('phone_number'); ?></label>
                    <input type="text" class="form-control auth-form-input" id="phone_number" name="phone_number" placeholder="Enter mobile number" minlength="10" maxlength="10" required value="<?php echo html_escape($user->phone_number); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <span class="Validation_error" id="number_valid" style="color:red;"></span>

                </div>
                <?php if ($user->role == "vendor") : ?>
                    <?php if (!empty($user->shop_name)) : ?>
                        <div class="form-group">
                            <label><?php echo trans('shop_name'); ?></label>
                            <input type="text" class="form-control auth-form-input" id="shop_name" name="shop_name" pattern="[a-zA-Z ]+" title="Please input only english words" placeholder="<?php echo trans('shop_name'); ?>" required value="<?php echo html_escape($user->shop_name); ?>" required <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            <p class="Validation_error" id="shop_name_p" style="color: #d43f3a;"></span>

                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('shop_description'); ?></label>
                            <textarea class="form-control text-area" name="about_me" placeholder="<?php echo trans('shop_description'); ?>" required <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($user->about_me); ?></textarea>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>
                <?php if ($user->role == "vendor") : ?>
                    <div class="form-group">

                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Pincode<span class="Validation_error"> *</span>
                                </label>
                                <input type="text" name="pincode" id="pincode" class="form-control auth-form-input" value="<?php echo $user->pincode ?>" minlength="6" maxlength="6" required onchange="get_location($( '#pincode').val())">
                                <span class="Validation_error" id="pincode_span"></span>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">State<span class="Validation_error"> *</span>
                                </label>
                                <input type="text" name="supplier_state" id="supplier_state" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_state); ?>" placeholder="State" required readonly>
                                <p class="Validation_error" id="state_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">City<span class="Validation_error"> *</span>
                                </label>
                                <input type="text" name="supplier_city" id="supplier_city" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_city); ?>" placeholder="City" required readonly>
                                <p class="Validation_error" id="city_p"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Area<span class="Validation_error"> *</span></label>
                                <input type="text" name="area" id="supplier_area" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_area); ?>" placeholder="Area" required>
                                <p class="Validation_error" id="area_p"></p>
                            </div>
                            <div class="col-12 col-sm-6 m-b-15">
                                <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span></label>
                                <input type="text" name="house_no" id="supplier_house_no" class="form-control auth-form-input" value="<?php echo html_escape($user->house_no); ?>" placeholder="House No" required>
                                <p class="Validation_error" id="house_no_p"></p>
                            </div>
                            <div class="col-12 col-sm-6 m-b-15">
                                <label class="control-label">Landmark</label>
                                <input type="text" name="landmark" class="form-control auth-form-input" value="<?php echo html_escape($user->landmark); ?>" placeholder="Landmark">
                                <p class="Validation_error" id="landmark_p"></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($user->role == "vendor") : ?>
                    <?php if (!empty($user->gst_number)) : ?>
                        <div class="form-group">

                            <label class="control-label">GST Number</label>
                            <input type="text" class="form-control form-input" id="gst_number" name="gst_number" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" placeholder="GST Number" required value="<?php echo html_escape($user->gst_number); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            <p class="Validation_error" id="gst_number_p"></p>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($user->pan_number)) : ?>
                        <div class="form-group">
                            <label class="control-label">Pan Number</label>
                            <input type="text" class="form-control form-input" id="pan_number" name="pan_number" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" value="<?php echo html_escape($user->pan_number); ?>" required <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            <p class="Validation_error" id="pan_number_p"></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($user->supplier_type_goods == "Food Products") : ?>
                        <div class="form-group">
                            <label class="control-label">FSSAI Number</label>
                            <input type="text" class="form-control form-input" id="fssai_number" name="fssai_number" placeholder="FSSAI Number" required value="<?php echo html_escape($user->fssai_number); ?>" maxlength="14" minlength="14" onkeypress="return onlyNumberKey(event)" required<?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            <p class="Validation_error" id="fssai_p"></p>

                        </div>
                    <?php endif; ?>
            </div>
        <?php endif; ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" id="save_change" class="btn btn-primary pull-right" onclick="user_edit();"><?php echo trans('save_changes'); ?></button>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?>
        <!-- form end -->
    </div>
</div>
</div>

<script>
    function get_states(val, map) {
        $('#select_states').children('option').remove();
        $('#select_cities').children('option').remove();
        $('#get_states_container').hide();
        $('#get_cities_container').hide();
        var data = {
            " country_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "ajax_controller/get_states",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_states").innerHTML = obj.content;
                    $('#get_states_container').show();
                } else {
                    document.getElementById("select_states").innerHTML = "";
                    $('#get_states_container').hide();
                }
            }
        });
    }

    function get_cities(val, map) {
        var data = {
            "state_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "ajax_controller/get_cities",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_cities").innerHTML = obj.content;
                    $('#get_cities_container').show();
                } else {
                    document.getElementById("select_cities").innerHTML = "";
                    $('#get_cities_container').hide();
                }
            }
        });
    }
</script>
<script>
    function get_location(pincode) {
        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                    $('#pincode_span1')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('input[name="supplier_state"]').val(html[0].PostOffice[0].State)
                    $('input[name="supplier_city"]').val(html[0].PostOffice[0].District)
                    $('input[name="area"]').val(html[0].PostOffice[0].Name)
                    //$('#supplier_area1').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }
</script>
<script>
    function onlyNumberKey(evt) {

        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
<script>
    function user_edit() {

        var myform = document.getElementById("user_edit_details");
        var fd = new FormData($(myform)[0]);
        var b = $("#user_edit_details").serializeArray();

        b.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });

        b.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });
        console.log(b);
        var letters = /^[a-zA-Z]+ [a-zA-Z]+$/;


        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var regex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
        if ($("#pan_number").val() == "") {
            $("#pan_number_p")[0].innerHTML = "*Field must be filled out";
            $('#pan_number').css({
                'borderColor': 'red'
            });

        } else if (regex.test($("#pan_number").val()) == false) {
            $("#pan_number_p")[0].innerHTML = "Enter a valid pan number";
            $('#pan_number').css({
                'borderColor': 'red'
            });


        } else {
            $("#pan_number_p").hide();
            $('#pan_number').css({
                'borderColor': '#dfe0e6'
            });
        }

        var regex1 = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
        if ($("#gst_number").is(":visible")) {
            if ($("#gst_number").val() == "") {
                $("#gst_number_p")[0].innerHTML = "*Field must be filled out";
                $('#gst_number').css({
                    'borderColor': 'red'
                });

            } else if (regex1.test($("#gst_number").val()) == false) {
                $("#gst_number_p")[0].innerHTML = "Enter a valid gst number";
                $('#gst_number').css({
                    'borderColor': 'red'
                });


            } else {
                $("#gst_number_p").hide();
                $('#gst_number').css({
                    'borderColor': '#dfe0e6'
                });
            }
        } else {
            console.log("Hell");
        }
        var regex2 = /^[a-z](-?[a-z])*$/;
        if ($("#slug").val() == "") {
            $("#slug_p")[0].innerHTML = "*Field must be filled out";
            $('#slug').css({
                'borderColor': 'red'
            });

        } else if (regex2.test($("#slug").val()) == false) {
            $("#slug_p")[0].innerHTML = "Enter a valid slug";
            $('#slug').css({
                'borderColor': 'red'
            });


        } else {
            $("#slug_p").hide();
            $('#slug').css({
                'borderColor': '#dfe0e6'
            });
        }

        var regex3 = /^(?=.{1,50}$)[a-z]+(?:['_.\s][a-z]+)*$/i;
        if ($("#first_name").val() == "") {
            $("#first_name_p")[0].innerHTML = "*Field must be filled out";
            $('#first_name').css({
                'borderColor': 'red'
            });

        } else if (regex3.test($("#first_name").val()) == false) {
            $("#first_name_p")[0].innerHTML = "Enter a valid first name";
            $('#first_name').css({
                'borderColor': 'red'
            });


        } else {
            $("#first_name_p")[0].innerHTML = "";

            $('#first_name').css({
                'borderColor': '#dfe0e6'
            });
        }

        if ($("#last_name").val() == "") {
            $("#last_name_p")[0].innerHTML = "*Field must be filled out";
            $('#last_name').css({
                'borderColor': 'red'
            });

        } else if (regex3.test($("#last_name").val()) == false) {
            $("#last_name_p")[0].innerHTML = "Enter a valid last  name";
            $('#last_name').css({
                'borderColor': 'red'
            });


        } else {
            $("#last_name_p")[0].innerHTML = "";
            $('#last_name').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#shop_name").val() == "") {
            $("#shop_name_p")[0].innerHTML = "*Field must be filled out";
            $('#shop_name').css({
                'borderColor': 'red'
            });

        } else if (regex3.test($("#shop_name").val()) == false) {
            $("#shop_name_p")[0].innerHTML = "Enter a valid shopname";
            $('#shop_name').css({
                'borderColor': 'red'
            });


        } else {
            $("#shop_name_p")[0].innerHTML = "";
            $('#shop_name').css({
                'borderColor': '#dfe0e6'
            });
        }

        if ($("#fssai_number").is(":visible")) {
            if ($("#fssai_number").val() == "") {
                $("#fssai_p")[0].innerHTML = "*Field must be filled out";
                $('#fssai_number').css({
                    'borderColor': 'red'
                });

            } else if ($("#fssai_number").val().length != 14) {
                $("#fssai_p")[0].innerHTML = "*Enter valid fssai number";
                $('#fssai_number').css({
                    'borderColor': 'red'
                });

            } else {
                $("#fssai_p")[0].innerHTML = "";

                $('#fssai_number').css({
                    'borderColor': '#dfe0e6'
                });
            }
        }

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if ($("#textEmail").val() == "") {
            $("#email_valid")[0].innerHTML = "*Field must be filled out";
            $('#textEmail').css({
                'borderColor': 'red'
            });

        } else if (reg.test($("#textEmail").val()) == false) {
            $("#email_valid")[0].innerHTML = "Enter a valid email";
            $('#textEmail').css({
                'borderColor': 'red'
            });


        } else {
            $("#email_valid").hide();
            $('#textEmail').css({
                'borderColor': '#dfe0e6'
            });
        }



        if ($("#phone_number").val() == "") {
            $("#number_valid")[0].innerHTML = "*Field must be filled out";
            $('#phone_number').css({
                'borderColor': 'red'
            });

        } else if ($("#phone_number").val().length != 10) {
            $("#number_valid")[0].innerHTML = "*Enter valid mobile number";
            $('#phone_number').css({
                'borderColor': 'red'
            });

        } else {
            $("#number_valid")[0].innerHTML = "";

            $('#phone_number').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#pincode").val() == "") {
            $("#pincode_span")[0].innerHTML = "*Field must be filled out";
            $('#pincode').css({
                'borderColor': 'red'
            });

        } else if ($("#pincode").val().length != 6) {
            $("#pincode_span")[0].innerHTML = "Enter a valid pincode";
            $('#pincode').css({
                'borderColor': 'red'
            });


        } else {
            $("#pincode_span")[0].innerHTML = "";
            $('#pincode').css({
                'borderColor': '#dfe0e6'
            });
        }

        if ($("#supplier_state").val() == "") {
            $("#state_p")[0].innerHTML = "*Field must be filled out";
            $('#supplier_state').css({
                'borderColor': 'red'
            });
            if ($("#supplier_city").val() == "") {
                $("#city_p")[0].innerHTML = "*Field must be filled out";
                $('#supplier_city').css({
                    'borderColor': 'red'
                });

            }
        }
        if ($("#supplier_area").val() == "") {
            $("#area_p")[0].innerHTML = "*Field must be filled out";
            $('#supplier_area').css({
                'borderColor': 'red'
            });

        }
        if ($("#supplier_house_no").val() == "") {
            $("#house_no_p")[0].innerHTML = "*Field must be filled out";
            $('#supplier_house_no').css({
                'borderColor': 'red'
            });

        }
        if ($("#supplier_house_no").val() == "") {
            $("#house_no_p")[0].innerHTML = "*Field must be filled out";
            $('#shipping_address_login').css({
                'borderColor': 'red'
            });

        } else if (($("#first_name").val() != "") && ($("#first_name").val().match(regex3)) && ($("#last_name").val() != "") && ($("#last_name").val().match(regex3)) && ($("#textEmail").val() != "") && ($("#textEmail").val().match(reg)) && ($("#shop_name").val() != "") && ($("#shop_name").val().match(regex3)) && ($("#phone_number").val() != "") && ($("#phone_number").val().length == 10) && ($("#pincode").val() != "") && ($("#pincode").val().length == 6) && ($("#supplier_state").val() != "") && ($("#supplier_city").val() != "") && ($("#supplier_area").val() != "") && ($("#supplier_house_no").val() != "" && ($("#pan_number").val() != "") && ($("#pan_number").val().match(regex) && ($("#gst_number").val() != "") && ($("#gst_number").val().match(regex1) && ($("#slug").val() != "") && ($("#slug").val().match(regex2) && ($("#fssai_number").val() != "") && ($("#fssai_number").val().length == 14)))))) {
            $.ajax({
                url: base_url + "membership_controller/edit_user_post",
                type: "post",
                data: b,
                success: function(data) {
                    $('.Validation_error').hide();
                    $('#first_name').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#last_name').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#textEmail').css({
                        'borderColor': '#dfe0e6'
                    });
                    $("#phone_number").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#zipcode").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#supplier_state").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#supplier_city").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#supplier_area").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#supplier_house_no").css({

                        'borderColor': '#dfe0e6'

                    })
                    location.reload();
                }
            })
        }
    }
</script>
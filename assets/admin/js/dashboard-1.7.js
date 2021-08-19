//delete product
function delete_product(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "id": product_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                method: "POST",
                url: base_url + "dashboard_controller/delete_product",
                data: data,
                success: function(response) {;

                    location.reload();
                }

            });


        }
    });
}

//delete quote request
function delete_quote_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "id": id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "bidding_controller/delete_quote_request",
                data: data,
                success: function(response) {;
                    location.reload();
                }
            });
        }
    });
}

function delete_barter_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "id": id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "bidding_controller/delete_barter_request",
                data: data,
                success: function(response) {;
                    location.reload();
                }
            });
        }
    });
}

function reject_barter_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "id": id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "bidding_controller/reject_barter",
                data: data,
                success: function(response) {;
                    location.reload();
                }
            });
        }
    });
}

function accept_barter_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "id": id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "bidding_controller/accept_barter",
                data: data,
                success: function(response) {;
                    location.reload();
                }
            });
        }
    });
}

function get_states(val, map) {
    $('#select_states').children('option').remove();
    $('#select_cities').children('option').remove();
    $('#get_states_container').hide();
    $('#get_cities_container').hide();
    var data = {
        "country_id": val,
        "sys_lang_id": sys_lang_id
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
            if (map) {
                update_product_map();
            }
        }
    });
}


function get_cities(val, map) {
    var data = {
        "state_id": val,
        "sys_lang_id": sys_lang_id
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
            if (map) {
                update_product_map();
            }
        }
    });
}
//change by him
function get_states_1(val, map) {
    console.log('hello');
    $('#select_states_1').children('option').remove();
    $('#select_cities_1').children('option').remove();
    $('#get_states_container_1').hide();
    $('#get_cities_container_1').hide();
    var data = {
        "country_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_states",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_states_1").innerHTML = obj.content;
                $('#get_states_container_1').show();
            } else {
                document.getElementById("select_states_1").innerHTML = "";
                $('#get_states_container_1').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}


function get_cities_1(val, map) {
    var data = {
        "state_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_cities",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_cities_1").innerHTML = obj.content;
                $('#get_cities_container_1').show();
            } else {
                document.getElementById("select_cities_1").innerHTML = "";
                $('#get_cities_container_1').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}
//end

//set main image session
$(document).on('click', '.btn-set-image-main-session', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    $('.btn-is-image-main').removeClass('btn-success');
    $('.btn-is-image-main').addClass('btn-secondary');
    $(this).removeClass('btn-secondary');
    $(this).addClass('btn-success');
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/set_image_main_session",
        data: data,
        success: function(response) {}
    });
});

//set main image
$(document).on('click', '.btn-set-image-main', function() {
    var image_id = $(this).attr('data-image-id');
    var product_id = $(this).attr('data-product-id');
    var data = {
        "image_id": image_id,
        "product_id": product_id,
        "sys_lang_id": sys_lang_id
    };
    $('.btn-is-image-main').removeClass('btn-success');
    $('.btn-is-image-main').addClass('btn-secondary');
    $(this).removeClass('btn-secondary');
    $(this).addClass('btn-success');
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/set_image_main",
        data: data,
        success: function(response) {}
    });
});

//delete product image session
$(document).on('click', '.btn-delete-product-img-session', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image_session",
        data: data,
        success: function() {
            $('#uploaderFile' + file_id).remove();
        }
    });
});


//delete product image session size chart
$(document).on('click', '.btn-delete-product-img-session-sizeChart', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image_session",
        data: data,
        success: function() {
            $('#uploaderFile' + file_id).remove();
            $("#hideShow-sizechart").show();
        }
    });
});

//delete product image
$(document).on('click', '.btn-delete-product-img', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image",
        data: data,
        success: function(response) {
            location.reload();
        }
    });
});

//delete size chart image
$(document).on('click', '.btn-delete-sizechart-img', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_sizechart",
        data: data,
        success: function(response) {
            // location.reload();
            $('#uploaderFile' + file_id).remove();
            $("#hide1").show();

        }
    });
});

//delete story image
$(document).on('click', '.btn-delete-story-img', function() {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_story_image",
        data: data,
        success: function(response) {
            location.reload();
        }
    });
});

//delete user story video preview
function delete_user_video_preview(user_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "user_id": user_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_story_video",
                type: "post",
                data: data,
                success: function(response) {
                    document.getElementById("video_upload_result").innerHTML = response;
                    location.reload();
                }
            });
        }
    });
}

function update_product_map() {
    var country_text = $("#select_countries").find('option:selected').text();
    var country_val = $("#select_countries").find('option:selected').val();
    var state_text = $("#select_states").find('option:selected').text();
    var state_val = $("#select_states").find('option:selected').val();
    var address = $("#address_input").val();
    var zip_code = $("#zip_code_input").val();
    var data = {
        "country_text": country_text,
        "country_val": country_val,
        "state_text": state_text,
        "state_val": state_val,
        "address": address,
        "zip_code": zip_code,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/show_address_on_map",
        data: data,
        success: function(response) {
            document.getElementById("map-result").innerHTML = response;
        }
    });
}

//delete product video preview
function delete_product_video_preview(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_video",
                type: "post",
                data: data,
                success: function(response) {
                    document.getElementById("video_upload_result").innerHTML = response;
                }
            });
        }
    });
}

//delete product audio preview
function delete_product_audio_preview(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_audio",
                type: "post",
                data: data,
                success: function(response) {
                    document.getElementById("audio_upload_result").innerHTML = response;
                }
            });
        }
    });
}


$('#select_shipping_cost').on('change', function() {
    if ($(this).find(':selected').attr('data-shipping-cost') == 1) {
        $('.shipping-cost-container').show();
        $(".price-input").prop('required', true);
    } else {
        $('.shipping-cost-container').hide();
        $(".price-input").prop('required', false);
    }
});

function generateUniqueString() {
    var time = String(new Date().getTime()),
        i = 0,
        output = '';
    for (i = 0; i < time.length; i += 2) {
        output += Number(time.substr(i, 2)).toString(36);
    }
    return ('SKU-' + output.toUpperCase());
}

function paddding(n, length) {
    var len = length - ('' + n).length;
    return (len > 0 ? new Array(++len).join('0') : '') + n
}

function uniqueProductCode(n) {
    n = n + 26;
    var ordA = 'A'.charCodeAt(0);
    var ordZ = 'Z'.charCodeAt(0);
    var len = ordZ - ordA + 1;

    var s = "";
    while (n >= 0) {
        s = String.fromCharCode(n % len + ordA) + s;
        n = Math.floor(n / len) - 1;
    }
    return s;
}

function generateUniqueProductCode(element, button) {
    $("#form-variation-add-text").hide();
    $(".spinner-btn-add-variation").show();
    var test = "GBP";
    var count = 0;
    var last_product_id = 0;

    $("select[name='" + element[0].name + "'").each(function() {
        count++;
        test += paddding($(this).val(), 3);
        if (count >= 2) {
            return false;
        }
    })
    $.ajax({
        url: base_url + "dashboard/last_product",
        async: true,
        type: "get",
        success: function(res) {
            var obj = JSON.parse(res);
            last_product_id = parseInt(obj.last_record[0].id);
            test += uniqueProductCode(parseInt((parseInt(last_product_id) + 1) / 1000000));
            test += paddding(parseInt(last_product_id) + 1, 6).substr(paddding(parseInt(last_product_id) + 1, 6).length - 6);
            $("#input_sku").val(test);
            $("#form-variation-add-text").show();
            $(".spinner-btn-add-variation").hide();
            button.disabled = false;
        }
    });

}


function generateUniqueProductVariationCode(button, product_id, sku) {
    $("#form-variation-option-add-text").hide();
    $(".spinner-variation-options").show();
    button.disabled = true;
    var data = {
        "product_id": product_id,
        "sys_lang_id": sys_lang_id,
        "sku": sku
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        url: base_url + "dashboard/get_variation_option_count",
        async: true,
        type: "post",
        data: data,
        success: function(res) {
            var obj = JSON.parse(res);
            console.log(obj);
            $("#input_sku_option").val(obj.sku_option);
            $("#form-variation-option-add-text").show();
            $(".spinner-variation-options").hide();
            button.disabled = false;
        }
    });

}


function generateUniqueProductOptionCode(element, button) {
    $("#form-variation-add-text").hide();
    $(".spinner-btn-add-variation").show();
    var test = "GBP";
    var count = 0;
    var last_product_id = 0;

    $("select[name='" + element[0].name + "'").each(function() {
        count++;
        test += paddding($(this).val(), 3);
        if (count >= 2) {
            return false;
        }
    })
    $.ajax({
        url: base_url + "dashboard/last_product",
        async: true,
        type: "get",
        success: function(res) {
            var obj = JSON.parse(res);
            last_product_id = parseInt(obj.last_record[0].id);
            test += uniqueProductCode(parseInt((parseInt(last_product_id) + 1) / 1000000));
            test += paddding(parseInt(last_product_id) + 1, 6).substr(paddding(parseInt(last_product_id) + 1, 6).length - 6);
            $("#input_sku").val(test);
            $("#form-variation-add-text").show();
            $(".spinner-btn-add-variation").hide();
            button.disabled = false;
        }
    });

}


$('input[type=radio][name=product_type]').change(function() {
    $('input[name=listing_type]').prop('checked', false);
    if (this.value == 'digital') {
        $('.listing_ordinary_listing').hide();
        $('.listing_take_offers').hide();
        $('.listing_sell_on_site input').prop('checked', true);
    } else {
        $('.listing_ordinary_listing').show();
        $('.listing_take_offers').show();
    }
});

//delete product digital file
function delete_product_digital_file(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function(willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_digital_file",
                type: "post",
                data: data,
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        document.getElementById("digital_files_upload_result").innerHTML = obj.html_content;
                    }
                }
            });
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * LICENSE KEY FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//add license key
function add_license_keys(product_id) {
    var data = {
        'product_id': product_id,
        'license_keys': $('#textarea_license_keys').val(),
        'allow_dublicate': $("input[name='allow_dublicate_license_keys']:checked").val(),
        'sys_lang_id': sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/add_license_keys",
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("result-add-license-keys").innerHTML = obj.success_message;
                $('#textarea_license_keys').val('');
            }
        }
    });
}

//delete license key
function delete_license_key(id, product_id) {
    var data = {
        'id': id,
        'product_id': product_id,
        'sys_lang_id': sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/delete_license_key",
        data: data,
        success: function(response) {
            $('#tr_license_key_' + id).remove();
        }
    });
}

//update license code list on modal open
$("#viewLicenseKeysModal").on('show.bs.modal', function() {
    var product_id = $('#license_key_list_product_id').val();
    var data = {
        'product_id': product_id,
        'sys_lang_id': sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/refresh_license_keys_list",
        data: data,
        success: function(response) {
            document.getElementById("response_license_key").innerHTML = response;
        }
    });
});

//get filter subcategories
function get_filter_subcategories_dashboard(val) {
    var data = {
        "parent_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/get_subcategories",
        data: data,
        success: function(response) {
            $('#subcategories').children('option:not(:first)').remove();
            $("#subcategories").append(response);
        }
    });
}

//on modal close 
$(document).on('hidden.bs.modal', function(event) {
    if ($('.modal:visible').length) {
        $('body').addClass('modal-open');
    }
});

function product_in_stock(user_id) {
    var data = {
        "user_id": user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: base_url + "home_controller/products_in_stock/" + user_id,
        data: data,
        beforeSend: function() {
            $('#cover-spin').show();
        },
        success: function(response) {
            $("#product_div_seller")[0].innerHTML = response;
            $("#cover-spin").hide();
            $('#in_stock').css("background-color", "white");
        }
    })
}

function highest_discount(user_id, str) {
    var data = {
        // "csfr_token_name": $.cookie(csfr_cookie_name)
        "user_id": user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: base_url + "home_controller/highest_discount_products/" + user_id,
        data: data,
        beforeSend: function() {
            $('#cover-spin').show();
        },
        success: function(response) {
            $("#product_div_seller")[0].innerHTML = response;
            $("#selected_tag")[0].innerHTML = str;
            $("#whats_new")[0].style.backgroundColor = "white";
            $("#better_discount")[0].style.backgroundColor = "#b09d9d2e";
            $("#low_to_high")[0].style.backgroundColor = "white";
            $("#high_to_low")[0].style.backgroundColor = "white";
            $('#in_stock').css("background-color", "transparent");
            $("#cover-spin").hide();
        }
    })
}

function priceLow(user_id, str) {
    var data = {
        // "csfr_token_name": $.cookie(csfr_cookie_name)
        "user_id": user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: base_url + "home_controller/price_low/" + user_id,
        data: data,
        beforeSend: function() {
            $('#cover-spin').show();
        },
        success: function(response) {
            $("#product_div_seller")[0].innerHTML = response;
            $("#selected_tag")[0].innerHTML = str;
            $("#whats_new")[0].style.backgroundColor = "white";
            $("#better_discount")[0].style.backgroundColor = "white";
            $("#low_to_high")[0].style.backgroundColor = "#b09d9d2e";
            $("#high_to_low")[0].style.backgroundColor = "white";
            $('#in_stock').css("background-color", "transparent");
            $("#cover-spin").hide();
        }
    })
}

function priceHigh(user_id, str) {
    var data = {
        // "csfr_token_name": $.cookie(csfr_cookie_name)
        "user_id": user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: base_url + "home_controller/price_high/" + user_id,
        data: data,
        beforeSend: function() {
            $('#cover-spin').show();
        },
        success: function(response) {
            $("#product_div_seller")[0].innerHTML = response;
            $("#selected_tag")[0].innerHTML = str;
            $("#whats_new")[0].style.backgroundColor = "white";
            $("#better_discount")[0].style.backgroundColor = "white";
            $("#low_to_high")[0].style.backgroundColor = "white";
            $("#high_to_low")[0].style.backgroundColor = "#b09d9d2e";
            $('#in_stock').css("background-color", "transparent");
            $("#cover-spin").hide();
        }
    })
}

function newProducts(user_id, str) {
    var data = {
        // "csfr_token_name": $.cookie(csfr_cookie_name)
        "user_id": user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: base_url + "home_controller/new_products/" + user_id,
        data: data,
        beforeSend: function() {
            $('#cover-spin').show();
        },
        success: function(response) {
            $("#product_div_seller")[0].innerHTML = response;
            $("#selected_tag")[0].innerHTML = str;
            $("#whats_new")[0].style.backgroundColor = "#b09d9d2e";
            $("#better_discount")[0].style.backgroundColor = "white";
            $("#low_to_high")[0].style.backgroundColor = "white";
            $("#high_to_low")[0].style.backgroundColor = "white";
            $('#in_stock').css("background-color", "transparent");
            $("#cover-spin").hide();
        }
    })
}


//script for validity of input field(is-invalid)
$(document).on("change", ".is-invalid", function() {
    if ($(this).val().length != 0)
        $(this).removeClass('is-invalid');
})

//function to check whether mobile number is registered or not
function check_for_mobile_register_js(phn_num) {
    var res;
    var data = {
        'sys_lang_id': sys_lang_id,
        'phn_num': phn_num
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        async: false,
        url: base_url + "check-register-mobile",
        data: data,
        success: function(response) {
            // console.log(response);
            var i = JSON.parse(response);
            res = i.result;
        }
    });
    return res;
}

//function to send verification otp
function send_verification_otp(phn_num, label_content) {
    var data = {
        'sys_lang_id': sys_lang_id,
        'phn_num': phn_num,
        'label_content': label_content
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "home_controller/send_otp_verification/" + phn_num,
        data: data,
        beforeSend: function() {
            document.getElementById("send-otp-result").innerHTML = "";
            document.getElementById("verify_btn").style.display = "block";
            document.getElementById("resend_otp").style.display = "block";
            document.getElementById("close_btn").style.display = "none";
        },
        success: function(response) {
            if (response != null) {
                var i = JSON.parse(response);
                console.log(i.otp);
                console.log(i.message);
                document.getElementById("send-otp-result").innerHTML = i.html_content1;
                $("#cross-btn").click(function() {
                    document.getElementById("btnsubmit_register").disabled = true;
                    document.getElementById("verify_mobile_span").innerHTML = "*You cannot register without Mobile Verification!";
                })
            }
        }
    });
}

//function to send verification otp
// function send_order_text(phn_num, label_content, order_no) {
//     var data = {
//         'sys_lang_id': sys_lang_id,
//         'phn_num': phn_num,
//         'label_content': label_content,
//         'order_no': order_no
//     };
//     data[csfr_token_name] = $.cookie(csfr_cookie_name);
//     $.ajax({
//         type: "POST",
//         url: base_url + "home_controller/send_otp_verification/" + phn_num,
//         data: data,

//         success: function(response) {
//             if (response != null) {
//                 var i = JSON.parse(response);
//                 console.log(i.order_no);
//                 console.log(i.message);
//                 //document.getElementById("send-otp-result").innerHTML = i.html_content1;
//                 // $("#cross-btn").click(function() {
//                 //     document.getElementById("btnsubmit_register").disabled = true;
//                 //     document.getElementById("verify_mobile_span").innerHTML = "*You cannot register without Mobile Verification!";
//                 // })
//             }
//         }
//     });
// }

//function to verify entered otp with session otp
function otp_verification(input_otp) {
    var data = {
        'sys_lang_id': sys_lang_id,
        'input_otp': input_otp
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "home_controller/session_otp_verification/" + input_otp,
        data: data,
        beforeSend: function() {
            document.getElementById("send-otp-result").innerHTML = "";
        },
        success: function(response) {
            var i = JSON.parse(response);
            console.log(i.result);
            if (i.result == true) {
                document.getElementById("otp_field").value = "";
                document.getElementById("send-otp-result").innerHTML = i.html_content2;
                document.getElementById("verify_btn").style.display = "none";
                document.getElementById("resend_otp").style.display = "none";
                document.getElementById("close_btn").style.display = "block";
                $("#cross-btn").click(function() {
                    document.getElementById("btnsubmit_register").disabled = false;
                    document.getElementById("verify_mobile_span").innerHTML = "";
                })
            } else {
                document.getElementById("send-otp-result").innerHTML = i.html_content2;
                $("#cross-btn").click(function() {
                    document.getElementById("btnsubmit_register").disabled = true;
                    document.getElementById("verify_mobile_span").innerHTML = "*You cannot register without Mobile Verification!";
                })
            }
        }
    });
}

//function to send verification otp for cart page
function send_verification_otp_cart(phn_num, label_content) {
    var data = {
        'sys_lang_id': sys_lang_id,
        'phn_num': phn_num,
        'label_content': label_content
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "home_controller/send_otp_verification/" + phn_num,
        data: data,
        beforeSend: function() {
            document.getElementById("send-otp-result-cart").innerHTML = "";
            document.getElementById("verify_btn_cart").style.display = "block";
            document.getElementById("resend_otp_cart").style.display = "block";
            document.getElementById("close_btn_cart").style.display = "none";
            document.getElementById("verifyOTPbutton").disabled = true;
            document.getElementById("phn_number").disabled = true;
            document.getElementById("otp_field_cart").style.display = "block";
        },
        success: function(response) {
            if (response != null) {
                var i = JSON.parse(response);
                // console.log(i.otp);
                // console.log(i.message);
                document.getElementById("send-otp-result-cart").innerHTML = i.html_content1;
            }
        }
    });
}

//function to verify entered otp with session otp
function otp_verification_cart(input_otp, user_id, phn_num) {
    var data = {
        'sys_lang_id': sys_lang_id,
        'input_otp': input_otp,
        'user_id': user_id,
        'phn_num': phn_num
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "home_controller/session_otp_verification/" + input_otp,
        data: data,
        beforeSend: function() {
            document.getElementById("send-otp-result-cart").innerHTML = "";
        },
        success: function(response) {
            var i = JSON.parse(response);
            console.log(i.result);
            if (i.result == true) {
                update_mobile_num(phn_num, user_id);
                document.getElementById("otp_field_cart").value = "";
                document.getElementById("send-otp-result-cart").innerHTML = i.html_content2;
                document.getElementById("verify_btn_cart").style.display = "none";
                document.getElementById("resend_otp_cart").style.display = "none";
                document.getElementById("close_btn_cart").style.display = "block";
                document.getElementById("otp_field_cart").style.display = "none";
            } else {
                document.getElementById("send-otp-result-cart").innerHTML = i.html_content2;
            }
        }
    });
}

//function to update mobile number in users table
function update_mobile_num(phn_num, user_id) {
    var res;
    var data = {
        // 'sys_lang_id': sys_lang_id,
        'phn_num': phn_num,
        'user_id': user_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        async: false,
        url: base_url + "profile_controller/update_user_mobile_number",
        data: data,
        success: function(response) {
            // $('#registerMobileModal').modal('hide');
            location.reload();
        }
    });
    return res;
}
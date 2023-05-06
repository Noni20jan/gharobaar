$("form").submit(function () {
  $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
}),
  $(document).ready(function () {
    function e(e) {
      e.each(function () {
        var e = $(this),
          t = e.data("delay"),
          a = "animated " + e.data("animation");
        e.css({ "animation-delay": t, "-webkit-animation-delay": t }),
          e
            .addClass(a)
            .one(
              "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
              function () {
                e.removeClass(a);
              }
            );
      });
    }
    $("#main-slider-new").on("init", function (e, t) {
      var n = $("#main-slider-new .item:first-child").find("[data-animation]");
      a(n);
    }),
      $("#main-slider-new").on("beforeChange", function (e, t, n, i) {
        var o = $('#main-slider-new .item[data-slick-index="' + i + '"]').find(
          "[data-animation]"
        );
        a(o);
      }),
      $("#main-slider-new").slick({
        autoplay: !0,
        autoplaySpeed: 9e3,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: !0,
        speed: 500,
        fade: 1 == slider_fade_effect,
        swipeToSlide: !0,
        rtl: rtl,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#main-slider-nav-new .prev"),
        nextArrow: $("#main-slider-nav-new .next"),
      }),
      $("#main-mobile-slider-new").on("init", function (e, t) {
        var n = $("#main-mobile-slider-new .item:first-child").find(
          "[data-animation]"
        );
        a(n);
      }),
      $("#main-mobile-slider-new").on("beforeChange", function (e, t, n, i) {
        var o = $(
          '#main-mobile-slider-new .item[data-slick-index="' + i + '"]'
        ).find("[data-animation]");
        a(o);
      }),
      $("#main-mobile-slider-new").slick({
        autoplay: !0,
        autoplaySpeed: 9e3,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: !0,
        speed: 500,
        fade: 1 == slider_fade_effect,
        swipeToSlide: !0,
        rtl: rtl,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#main-mobile-slider-nav-new .prev"),
        nextArrow: $("#main-mobile-slider-nav-new .next"),
      }),
      $("#main-slider").on("init", function (t, a) {
        e($("#main-slider .item:first-child").find("[data-animation]"));
      }),
      $("#main-slider").on("beforeChange", function (t, a, n, i) {
        e(
          $('#main-slider .item[data-slick-index="' + i + '"]').find(
            "[data-animation]"
          )
        );
      }),
      $("#main-slider").slick({
        autoplay: !0,
        autoplaySpeed: 9e3,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: !0,
        speed: 500,
        fade: 1 == slider_fade_effect,
        swipeToSlide: !0,
        rtl: rtl,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#main-slider-nav .prev"),
        nextArrow: $("#main-slider-nav .next"),
      }),
      $("#main-mobile-slider").on("init", function (t, a) {
        e($("#main-mobile-slider .item:first-child").find("[data-animation]"));
      }),
      $("#main-mobile-slider").on("beforeChange", function (t, a, n, i) {
        e(
          $('#main-mobile-slider .item[data-slick-index="' + i + '"]').find(
            "[data-animation]"
          )
        );
      }),
      $("#main-mobile-slider").slick({
        autoplay: !0,
        autoplaySpeed: 9e3,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: !0,
        speed: 500,
        fade: 1 == slider_fade_effect,
        swipeToSlide: !0,
        rtl: rtl,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#main-mobile-slider-nav .prev"),
        nextArrow: $("#main-mobile-slider-nav .next"),
      }),
      0 != $("#slider_special_offers").length &&
        $("#slider_special_offers").slick({
          autoplay: !1,
          autoplaySpeed: 4900,
          infinite: !0,
          speed: 200,
          swipeToSlide: !0,
          rtl: rtl,
          cssEase: "linear",
          lazyLoad: "progressive",
          prevArrow: $("#slider_special_offers_nav .prev"),
          nextArrow: $("#slider_special_offers_nav .next"),
          slidesToShow: 5,
          slidesToScroll: 5,
          responsive: [
            {
              breakpoint: 992,
              settings: { slidesToShow: 4, slidesToScroll: 4 },
            },
            {
              breakpoint: 768,
              settings: { slidesToShow: 3, slidesToScroll: 3 },
            },
            {
              breakpoint: 576,
              settings: { slidesToShow: 2, slidesToScroll: 2 },
            },
          ],
        }),
      $("#product_slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 300,
        arrows: !0,
        fade: !0,
        infinite: !1,
        swipeToSlide: !0,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#product-slider-nav .prev"),
        nextArrow: $("#product-slider-nav .next"),
        asNavFor: "#product_thumbnails_slider",
      }),
      $("#product_thumbnails_slider").slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        speed: 300,
        focusOnSelect: !0,
        arrows: !1,
        infinite: !1,
        vertical: !0,
        centerMode: !1,
        arrows: !0,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#product-thumbnails-slider-nav .prev"),
        nextArrow: $("#product-thumbnails-slider-nav .next"),
        asNavFor: "#product_slider",
      }),
      $(document).ready(function () {
        baguetteBox.run(".product-slider", {
          animation: 1 == rtl ? "fadeIn" : "slideIn",
        });
      }),
      $(document).ajaxStop(function () {
        baguetteBox.run(".product-slider", {
          animation: 1 == rtl ? "fadeIn" : "slideIn",
        });
      }),
      $(document).on(
        "click",
        "#product_thumbnails_slider .slick-slide",
        function () {
          var e = $(this).attr("data-slick-index");
          $("#product_slider").slick("slickGoTo", parseInt(e));
        }
      ),
      $("#blog-slider").slick({
        autoplay: !1,
        autoplaySpeed: 4900,
        infinite: !0,
        speed: 200,
        swipeToSlide: !0,
        rtl: rtl,
        cssEase: "linear",
        lazyLoad: "progressive",
        prevArrow: $("#blog-slider-nav .prev"),
        nextArrow: $("#blog-slider-nav .next"),
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
          { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: 2 } },
          { breakpoint: 480, settings: { slidesToShow: 1, slidesToScroll: 1 } },
        ],
      }),
      $(document).on("click", ".rating-stars .label-star", function () {
        $("#user_rating").val($(this).attr("data-star"));
      }),
      $(document).on("click", ".btn-open-mobile-nav", function () {
        $("#navMobile").hasClass("nav-mobile-open")
          ? ($("#navMobile").removeClass("nav-mobile-open"),
            $("#overlay_bg").hide())
          : ($("#navMobile").addClass("nav-mobile-open"),
            $("#overlay_bg").show());
      }),
      $(document).on("click", "#overlay_bg", function () {
        $("#navMobile").removeClass("nav-mobile-open"), $("#overlay_bg").hide();
      }),
      $(document).on("click", ".close-menu-click", function () {
        $("#navMobile").removeClass("nav-mobile-open"), $("#overlay_bg").hide();
      });
  });
var obj_mobile_nav = {
  id: "",
  name: "",
  parent_id: "",
  parent_name: "",
  back_button: 1,
};
function mobile_menu() {
  if (
    $('.mega-menu li a[data-parent-id="' + obj_mobile_nav.id + '"]').length > 0
  ) {
    if (
      (1 == obj_mobile_nav.back_button
        ? $("#navbar_mobile_links").hide()
        : ($("#navbar_mobile_links").show(),
          $("#navbar_mobile_back_button").empty()),
      $("#navbar_mobile_categories").empty(),
      $("#navbar_mobile_back_button").empty(),
      1 == obj_mobile_nav.back_button)
    ) {
      if (0 == obj_mobile_nav.parent_id)
        document.getElementById("navbar_mobile_back_button").innerHTML =
          '<a href="javascript:void(0)" class="nav-link" data-id="0"><strong><i class="icon-angle-left"></i>' +
          obj_mobile_nav.name +
          "</strong></a>";
      else {
        var e = $(
          '.mega-menu li a[data-id="' + obj_mobile_nav.parent_id + '"]'
        ).text();
        document.getElementById("navbar_mobile_back_button").innerHTML =
          '<a href="javascript:void(0)" class="nav-link" data-id="' +
          obj_mobile_nav.parent_id +
          '" data-category-name="' +
          e +
          '"><strong><i class="icon-angle-left"></i>' +
          obj_mobile_nav.name +
          "</strong></a>";
      }
      var t = $(
        '.mega-menu li a[data-parent-id="' + obj_mobile_nav.parent_id + '"]'
      ).attr("href");
      document.getElementById("navbar_mobile_categories").innerHTML =
        '<li class="nav-item"><a href="' +
        t +
        '" class="nav-link">' +
        txt_all +
        "</a></li>";
    }
    $('.mega-menu li a[data-parent-id="' + obj_mobile_nav.id + '"]').each(
      function () {
        var e = $(this).attr("data-id"),
          t = obj_mobile_nav.id,
          a = $(this).attr("href"),
          n = $(this).text();
        1 == $(this).attr("data-has-sb")
          ? $("#navbar_mobile_categories").append(
              '<li class="nav-item"><a href="javascript:void(0)" class="nav-link" data-id="' +
                e +
                '" data-parent-id="' +
                t +
                '">' +
                n +
                '<i class="icon-arrow-right"></i></a></li>'
            )
          : $("#navbar_mobile_categories").append(
              '<li class="nav-item"><a href="' +
                a +
                '" class="nav-link">' +
                n +
                "</a></li>"
            );
      }
    );
  }
}
function send_activation_email(e, t) {
  $("#result-login").empty(), $(".spinner-activation-login").show();
  var a = { id: e, token: t, type: "login", sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $("#submit_review").prop("disabled", !0),
    $.ajax({
      type: "POST",
      url: base_url + "auth_controller/send_activation_email_post",
      data: a,
      success: function (e) {
        var t = JSON.parse(e);
        1 == t.result
          ? ($(".spinner-activation-login").hide(),
            (document.getElementById("result-login").innerHTML =
              t.success_message))
          : location.reload();
      },
    });
}
function send_activation_email_register(e, t) {
  $("#result-register").empty(), $(".spinner-activation-register").show();
  var a = { id: e, token: t, type: "register", sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $("#submit_review").prop("disabled", !0),
    $.ajax({
      type: "POST",
      url: base_url + "auth_controller/send_activation_email_post",
      data: a,
      success: function (e) {
        var t = JSON.parse(e);
        1 == t.result
          ? ($(".spinner-activation-register").hide(),
            (document.getElementById("result-register").innerHTML =
              t.success_message))
          : location.reload();
      },
    });
}
function select_product_variation_option(e, t, a) {
  var n = { variation_id: e, selected_option_id: a, sys_lang_id: sys_lang_id };
  (n[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "select-variation-option-post",
      data: n,
      success: function (n) {
        var i = JSON.parse(n);
        1 == i.status &&
          ("" != i.html_content_price &&
            (document.getElementById(
              "product_details_price_container"
            ).innerHTML = i.html_content_price),
          "" != i.html_content_stock &&
            ((document.getElementById("text_product_stock_status").innerHTML =
              i.html_content_stock),
            0 == i.stock_status
              ? $(".btn-product-cart").attr("disabled", !0)
              : $(".btn-product-cart").attr("disabled", !1)),
          "" != i.html_content_slider &&
            ($("#product_slider").slick("unslick"),
            $("#product_thumbnails_slider").slick("unslick"),
            (document.getElementById("product_slider_container").innerHTML =
              i.html_content_slider),
            $("#product_slider").slick({
              slidesToShow: 1,
              slidesToScroll: 1,
              speed: 300,
              arrows: !0,
              fade: !0,
              infinite: !1,
              swipeToSlide: !0,
              cssEase: "linear",
              lazyLoad: "progressive",
              prevArrow: $("#product-slider-nav .prev"),
              nextArrow: $("#product-slider-nav .next"),
              asNavFor: "#product_thumbnails_slider",
            }),
            $("#product_thumbnails_slider").slick({
              slidesToShow: 7,
              slidesToScroll: 1,
              speed: 300,
              focusOnSelect: !0,
              arrows: !1,
              infinite: !1,
              vertical: !0,
              centerMode: !1,
              arrows: !0,
              cssEase: "linear",
              lazyLoad: "progressive",
              prevArrow: $("#product-thumbnails-slider-nav .prev"),
              nextArrow: $("#product-thumbnails-slider-nav .next"),
              asNavFor: "#product_slider",
            }))),
          "dropdown" == t && get_sub_variation_options(e, a);
      },
    });
}
function get_sub_variation_options(e, t) {
  var a = { variation_id: e, selected_option_id: t, sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      url: base_url + "get-sub-variation-options",
      type: "POST",
      data: a,
      success: function (e) {
        var a = JSON.parse(e);
        1 == a.status &&
          (document.getElementById(
            "variation_dropdown_" + a.subvariation_id
          ).innerHTML = "" == t ? "" : a.html_content);
      },
    });
}
function update_number_spinner(e) {
  var t = (e = e).closest(".number-spinner").find("input").val().trim(),
    a = 0;
  (a =
    "up" == e.attr("data-dir") ? parseInt(t) + 1 : t > 1 ? parseInt(t) - 1 : 1),
    e.closest(".number-spinner").find("input").val(a);
}
function delete_review(e, t, a, n) {
  swal({
    text: n,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (n) {
    if (n) {
      var i = parseInt($("#product_review_limit").val()),
        o = {
          id: e,
          product_id: t,
          user_id: a,
          limit: i,
          sys_lang_id: sys_lang_id,
        };
      (o[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          method: "POST",
          url: base_url + "home_controller/delete_review",
          data: o,
        }).done(function (e) {
          document.getElementById("review-result").innerHTML = e;
        });
    }
  });
}
function load_more_comment(e) {
  var t = {
    product_id: e,
    limit: parseInt($("#product_comment_limit").val()),
    sys_lang_id: sys_lang_id,
  };
  (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $("#load_comment_spinner").show(),
    $.ajax({
      url: base_url + "ajax_controller/load_more_comment",
      type: "POST",
      data: t,
      success: function (e) {
        var t = JSON.parse(e);
        "comments" == t.type &&
          setTimeout(function () {
            $("#load_comment_spinner").hide(),
              (document.getElementById("comment-result").innerHTML =
                t.html_content);
          }, 500);
      },
    });
}
function is_email(e) {
  return !!/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(
    e
  );
}
function str_lenght(e) {
  return "" == e || null == e ? 0 : (e = e.trim()).length;
}
function delete_comment(e, t, a) {
  swal({
    text: a,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (a) {
    if (a) {
      var n = parseInt($("#product_comment_limit").val()),
        i = { id: e, product_id: t, limit: n, sys_lang_id: sys_lang_id };
      (i[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          url: base_url + "ajax_controller/delete_comment",
          type: "POST",
          data: i,
          success: function (e) {
            var t = JSON.parse(e);
            "comments" == t.type &&
              (document.getElementById("comment-result").innerHTML =
                t.html_content);
          },
        });
    }
  });
}
function show_comment_box(e) {
  $(".visible-sub-comment").empty();
  var t = parseInt($("#product_comment_limit").val()),
    a = { comment_id: e, limit: t, sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "ajax_controller/load_subcomment_box",
      data: a,
      success: function (t) {
        var a = JSON.parse(t);
        "form" == a.type && $("#sub_comment_form_" + e).append(a.html_content);
      },
    });
}
function load_more_blog_comment(e) {
  var t = {
    post_id: e,
    limit: parseInt($("#blog_comment_limit").val()),
    sys_lang_id: sys_lang_id,
  };
  (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $("#load_comment_spinner").show(),
    $.ajax({
      url: base_url + "ajax_controller/load_more_blog_comments",
      type: "post",
      data: t,
      success: function (e) {
        var t = JSON.parse(e);
        "comments" == t.type &&
          setTimeout(function () {
            $("#load_comment_spinner").hide(),
              (document.getElementById("comment-result").innerHTML =
                t.html_content);
          }, 500);
      },
    });
}
function delete_blog_comment(e, t, a) {
  swal({
    text: a,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (a) {
    if (a) {
      var n = parseInt($("#blog_comment_limit").val()),
        i = { comment_id: e, post_id: t, limit: n, sys_lang_id: sys_lang_id };
      (i[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          url: base_url + "ajax_controller/delete_blog_comment",
          type: "post",
          data: i,
          success: function (e) {
            var t = JSON.parse(e);
            "comments" == t.type &&
              (document.getElementById("comment-result").innerHTML =
                t.html_content);
          },
        });
    }
  });
}
function delete_conversation(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { conversation_id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          method: "POST",
          url: base_url + "message_controller/delete_conversation",
          data: a,
        }).done(function (e) {
          location.reload();
        });
    }
  });
}
function remove_from_cart(e) {
  var t = { cart_item_id: e, sys_lang_id: sys_lang_id };
  (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "cart_controller/remove_from_cart",
      data: t,
      success: function (e) {
        location.reload();
      },
    });
}
function approve_order_product(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { order_product_id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "order_controller/approve_order_product_post",
          data: a,
          success: function (e) {
            location.reload();
          },
        });
    }
  });
}
function set_site_language(e) {
  var t = { lang_id: e, sys_lang_id: sys_lang_id };
  (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      method: "POST",
      url: base_url + "home_controller/set_site_language",
      data: t,
    }).done(function (e) {
      location.reload();
    });
}
function load_more_promoted_products() {
  $("#load_promoted_spinner").show();
  var e = {
    offset: parseInt($("#promoted_products_offset").val()),
    sys_lang_id: sys_lang_id,
  };
  (e[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "home_controller/load_more_promoted_products",
      data: e,
      success: function (e) {
        var t = JSON.parse(e);
        1 == t.result
          ? setTimeout(function () {
              $("#promoted_products_offset").val(t.offset),
                $("#row_promoted_products").append(t.html_content),
                $("#load_promoted_spinner").hide(),
                t.hide_button && $(".promoted-load-more-container").hide();
            }, 300)
          : setTimeout(function () {
              $("#load_promoted_spinner").hide(),
                t.hide_button && $(".promoted-load-more-container").hide();
            }, 300);
      },
    });
}
function send_message_as_email(e, t, a, n) {
  var i = {
    email_type: "new_message",
    sender_id: e,
    receiver_id: t,
    message_subject: a,
    message_text: n,
    sys_lang_id: sys_lang_id,
  };
  (i[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "ajax_controller/send_email",
      data: i,
      success: function (e) {},
    });
}
function get_states(e, t) {
  $("#select_states").children("option").remove(),
    $("#select_cities").children("option").remove(),
    $("#get_states_container").hide(),
    $("#get_cities_container").hide();
  var a = { country_id: e, sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "ajax_controller/get_states",
      data: a,
      success: function (e) {
        var a = JSON.parse(e);
        1 == a.result
          ? ((document.getElementById("select_states").innerHTML = a.content),
            $("#get_states_container").show())
          : ((document.getElementById("select_states").innerHTML = ""),
            $("#get_states_container").hide()),
          t && update_product_map();
      },
    });
}
function get_cities(e, t) {
  var a = { state_id: e, sys_lang_id: sys_lang_id };
  (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "ajax_controller/get_cities",
      data: a,
      success: function (e) {
        var a = JSON.parse(e);
        1 == a.result
          ? ((document.getElementById("select_cities").innerHTML = a.content),
            $("#get_cities_container").show())
          : ((document.getElementById("select_cities").innerHTML = ""),
            $("#get_cities_container").hide()),
          t && update_product_map();
      },
    });
}
function hide_cookies_warning() {
  $(".cookies-warning").hide();
  var e = { sys_lang_id: sys_lang_id };
  (e[csfr_token_name] = $.cookie(csfr_cookie_name)),
    $.ajax({
      type: "POST",
      url: base_url + "home_controller/cookies_warning",
      data: e,
      success: function (e) {},
    });
}
function delete_quote_request(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "bidding_controller/delete_quote_request",
          data: a,
          success: function (e) {
            location.reload();
          },
        });
    }
  });
}
function delete_barter_request(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "bidding_controller/delete_barter_request",
          data: a,
          success: function (e) {
            location.reload();
          },
        });
    }
  });
}
function accept_barter_request(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "bidding_controller/accept_barter",
          data: a,
          success: function (e) {
            location.reload();
          },
        });
    }
  });
}
function reject_barter_request(e, t) {
  swal({
    text: t,
    icon: "warning",
    buttons: [sweetalert_cancel, sweetalert_ok],
    dangerMode: !0,
  }).then(function (t) {
    if (t) {
      var a = { id: e, sys_lang_id: sys_lang_id };
      (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "bidding_controller/reject_barter",
          data: a,
          success: function (e) {
            location.reload();
          },
        });
    }
  });
}
$(document).on("click", "#navbar_mobile_categories li a", function () {
  (obj_mobile_nav.id = $(this).attr("data-id")),
    (obj_mobile_nav.name = "" != $(this).text() ? $(this).text() : ""),
    (obj_mobile_nav.parent_id =
      null != $(this).attr("data-parent-id")
        ? $(this).attr("data-parent-id")
        : 0),
    (obj_mobile_nav.back_button = 1),
    console.log(obj_mobile_nav),
    mobile_menu();
}),
  $(document).on("click", "#navbar_mobile_back_button a", function () {
    (obj_mobile_nav.id = $(this).attr("data-id")),
      (obj_mobile_nav.name =
        null != $(this).attr("data-category-name")
          ? $(this).attr("data-category-name")
          : ""),
      (obj_mobile_nav.parent_id =
        null != $(this).attr("data-parent-id")
          ? $(this).attr("data-parent-id")
          : 0),
      0 == obj_mobile_nav.id && (obj_mobile_nav.back_button = 0),
      console.log(obj_mobile_nav),
      mobile_menu();
  }),
  $(document).on("click", ".mobile-search .search-icon", function () {
    $(".mobile-search-form").hasClass("display-block")
      ? ($(".mobile-search-form").removeClass("display-block"),
        $(".mobile-search .search-icon i").removeClass("icon-close"),
        $(".mobile-search .search-icon i").addClass("icon-search"))
      : ($(".mobile-search-form").addClass("display-block"),
        $(".mobile-search .search-icon i").removeClass("icon-search"),
        $(".mobile-search .search-icon i").addClass("icon-close"));
  }),
  $(function () {
    ($(".filter-custom-scrollbar").overlayScrollbars({}),
    $(".search-results-location").overlayScrollbars({}),
    $(".messages-sidebar").overlayScrollbars({}),
    $("#message-custom-scrollbar").length > 0) &&
      OverlayScrollbars(
        document.getElementById("message-custom-scrollbar"),
        {}
      ).scroll({ y: "100%" }, 0);
  }),
  $(".mega-menu .nav-item").hover(
    function () {
      var e = $(this).attr("data-category-id");
      $("#mega_menu_content_" + e).show(),
        $(".large-menu-item").removeClass("active"),
        $(".large-menu-item-first").addClass("active"),
        $(".large-menu-content-first").addClass("active");
    },
    function () {
      var e = $(this).attr("data-category-id");
      $("#mega_menu_content_" + e).hide();
    }
  ),
  $(".mega-menu .dropdown-menu").hover(
    function () {
      $(this).show();
    },
    function () {}
  ),
  $(".large-menu-item").hover(
    function () {
      var e = $(this).attr("data-subcategory-id");
      $(".large-menu-item").removeClass("active"),
        $(this).addClass("active"),
        $(".large-menu-content").removeClass("active"),
        $("#large_menu_content_" + e).addClass("active");
    },
    function () {}
  ),
  $(window).scroll(function () {
    $(this).scrollTop() > 100
      ? $(".scrollup").fadeIn()
      : $(".scrollup").fadeOut();
  }),
  $(".scrollup").click(function () {
    return $("html, body").animate({ scrollTop: 0 }, 700), !1;
  }),
  $(function () {
    $(".search-select a").click(function () {
      $(".search-select .btn").text($(this).text()),
        $(".search-select .btn").val($(this).text()),
        $(".search_type_input").val($(this).attr("data-value"));
    });
  }),
  $(document).on(
    "click",
    ".quantity-select-product .dropdown-menu .dropdown-item",
    function () {
      $(".quantity-select-product .btn span").text($(this).text()),
        $("input[name='product_quantity']").val($(this).text());
    }
  ),
  $(document).on("click", "#show_phone_number", function () {
    $(this).hide(), $("#phone_number").show();
  }),
  $(document).ready(function () {
    $("#form_login").submit(function (e) {
      var t = $(this);
      if (!1 === t[0].checkValidity()) e.preventDefault(), e.stopPropagation();
      else {
        e.preventDefault();
        t.find("input, select, button, textarea");
        var a = t.serializeArray();
        a.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) }),
          a.push({ name: "sys_lang_id", value: sys_lang_id }),
          $.ajax({
            url: base_url + "auth_controller/login_post",
            type: "post",
            data: a,
            success: function (e) {
              var t = JSON.parse(e);
              1 == t.result
                ? location.reload()
                : 0 == t.result &&
                  (document.getElementById("result-login").innerHTML =
                    t.error_message);
            },
          });
      }
      t[0].classList.add("was-validated");
    });
  }),
  $(document).on(
    "click",
    ".product-add-to-cart-container .number-spinner button",
    function () {
      update_number_spinner($(this));
    }
  ),
  $(document).on(
    "input keyup paste change",
    ".number-spinner input",
    function () {
      var e = $(this).val();
      (e = (e = e.replace(",", "")).replace(".", "")),
        $.isNumeric(e) || (e = 1),
        isNaN(e) && (e = 1),
        $(this).val(e);
    }
  ),
  $(document).on(
    "input paste change",
    ".cart-item-quantity .number-spinner input",
    function () {
      var e = {
        product_id: $(this).attr("data-product-id"),
        cart_item_id: $(this).attr("data-cart-item-id"),
        quantity: $(this).val(),
        sys_lang_id: sys_lang_id,
      };
      (e[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
          type: "POST",
          url: base_url + "update-cart-product-quantity",
          data: e,
          success: function (e) {
            location.reload();
          },
        });
    }
  ),
  $(document).on(
    "click",
    ".cart-item-quantity .btn-spinner-minus",
    function () {
      update_number_spinner($(this));
      var e = $(this).attr("data-cart-item-id");
      0 != $("#q-" + e).val() && $("#q-" + e).change();
    }
  ),
  $(document).on("click", ".cart-item-quantity .btn-spinner-plus", function () {
    update_number_spinner($(this));
    var e = $(this).attr("data-cart-item-id");
    $("#q-" + e).change();
  }),
  $(document).on("click", ".rate-product .rating-stars label", function () {
    $(".rate-product  .rating-stars label i").removeClass("icon-star"),
      $(".rate-product  .rating-stars label i").addClass("icon-star-o");
    var e = $(this).attr("data-star");
    $(".rate-product  .rating-stars label").each(function () {
      $(this).attr("data-star") <= e &&
        ($(this).find("i").removeClass("icon-star-o"),
        $(this).find("i").addClass("icon-star"));
    });
  }),
  $(document).on("click", ".rate-product .label-star-open-modal", function () {
    var e = $(this).attr("data-product-id"),
      t = $(this).attr("data-star");
    $("#rateProductModal #review_product_id").val(e),
      $("#rateProductModal #user_rating").val(t);
  }),
  $(document).on("click", ".btn-add-review", function () {
    var e = $(this).attr("data-product-id");
    $("#rateProductModal #review_product_id").val(e);
  }),
  $(document).ready(function () {
    $("#form_add_comment").submit(function (e) {
      e.preventDefault();
      var t = !0,
        a = !0,
        n = $("#form_add_comment").serializeArray();
      if (
        ((object_serialized = {}),
        $(n).each(function (e, t) {
          (object_serialized[t.name] = t.value),
            "g-recaptcha-response" == t.name && (g_recaptcha = t.value);
        }),
        $("#form_add_comment").find("#comment_name").length > 0 && (t = !1),
        0 == t &&
          (str_lenght(object_serialized.name) < 1
            ? ($("#comment_name").addClass("is-invalid"), (a = !1))
            : $("#comment_name").removeClass("is-invalid"),
          str_lenght(object_serialized.email) < 1
            ? ($("#comment_email").addClass("is-invalid"), (a = !1))
            : $("#comment_email").removeClass("is-invalid"),
          1 == is_recaptcha_enabled &&
            0 == t &&
            ("" == g_recaptcha
              ? ($("#form_add_comment .g-recaptcha").addClass(
                  "is-recaptcha-invalid"
                ),
                (a = !1))
              : $("#form_add_comment .g-recaptcha").removeClass(
                  "is-recaptcha-invalid"
                ))),
        str_lenght(object_serialized.comment) < 1
          ? ($("#comment_text").addClass("is-invalid"), (a = !1))
          : $("#comment_text").removeClass("is-invalid"),
        !a)
      )
        return !1;
      n.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) }),
        n.push({
          name: "limit",
          value: parseInt($("#product_comment_limit").val()),
        }),
        n.push({ name: "sys_lang_id", value: sys_lang_id }),
        $.ajax({
          url: base_url + "ajax_controller/add_comment",
          type: "post",
          data: n,
          success: function (e) {
            1 == is_recaptcha_enabled && 0 == t && grecaptcha.reset(),
              $("#form_add_comment")[0].reset();
            var a = JSON.parse(e);
            "message" == a.type
              ? (document.getElementById("message-comment-result").innerHTML =
                  a.html_content)
              : (document.getElementById("comment-result").innerHTML =
                  a.html_content);
          },
        });
    });
  }),
  $(document).on("click", ".btn-submit-subcomment", function () {
    var e = $(this).attr("data-comment-id"),
      t = {};
    (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $("#form_add_subcomment_" + e).ajaxSubmit({
        beforeSubmit: function () {
          var t = !0,
            a = !0,
            n = "";
          $("#form_add_subcomment_" + e).find(".form-comment-name").length >
            0 && (t = !1);
          var i = $("#form_add_subcomment_" + e).serializeArray();
          if (
            ((object_serialized = {}),
            $(i).each(function (e, t) {
              (object_serialized[t.name] = t.value),
                "g-recaptcha-response" == t.name && (n = t.value);
            }),
            0 == t &&
              (object_serialized.name.length < 1
                ? ($(".form-comment-name").addClass("is-invalid"), (a = !1))
                : $(".form-comment-name").removeClass("is-invalid"),
              object_serialized.email.length < 1 ||
              !is_email(object_serialized.email)
                ? ($(".form-comment-email").addClass("is-invalid"), (a = !1))
                : $(".form-comment-email").removeClass("is-invalid"),
              1 == is_recaptcha_enabled &&
                ("" == n
                  ? ($("#form_add_subcomment_" + e + " .g-recaptcha").addClass(
                      "is-recaptcha-invalid"
                    ),
                    (a = !1))
                  : $(
                      "#form_add_subcomment_" + e + " .g-recaptcha"
                    ).removeClass("is-recaptcha-invalid"))),
            object_serialized.comment.length < 1
              ? ($(".form-comment-text").addClass("is-invalid"), (a = !1))
              : $(".form-comment-text").removeClass("is-invalid"),
            0 == a)
          )
            return !1;
        },
        type: "POST",
        url: base_url + "ajax_controller/add_comment",
        data: t,
        success: function (t) {
          var a = JSON.parse(t);
          "message" == a.type
            ? (document.getElementById("sub_comment_form_" + e).innerHTML =
                a.html_content)
            : (document.getElementById("comment-result").innerHTML =
                a.html_content);
        },
      });
  }),
  $(document).ready(function () {
    $("#form_add_blog_comment").submit(function (e) {
      e.preventDefault();
      var t = !0,
        a = !0,
        n = $("#form_add_blog_comment").serializeArray();
      if (
        ((object_serialized = {}),
        $(n).each(function (e, t) {
          (object_serialized[t.name] = t.value),
            "g-recaptcha-response" == t.name && (g_recaptcha = t.value);
        }),
        $("#form_add_blog_comment").find("#comment_name").length > 0 &&
          (t = !1),
        0 == t &&
          (str_lenght(object_serialized.name) < 1
            ? ($("#comment_name").addClass("is-invalid"), (a = !1))
            : $("#comment_name").removeClass("is-invalid"),
          str_lenght(object_serialized.email) < 1
            ? ($("#comment_email").addClass("is-invalid"), (a = !1))
            : $("#comment_email").removeClass("is-invalid"),
          1 == is_recaptcha_enabled &&
            0 == t &&
            ("" == g_recaptcha
              ? ($("#form_add_blog_comment .g-recaptcha").addClass(
                  "is-recaptcha-invalid"
                ),
                (a = !1))
              : $("#form_add_blog_comment .g-recaptcha").removeClass(
                  "is-recaptcha-invalid"
                ))),
        str_lenght(object_serialized.comment) < 1
          ? ($("#comment_text").addClass("is-invalid"), (a = !1))
          : $("#comment_text").removeClass("is-invalid"),
        !a)
      )
        return !1;
      n.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) }),
        n.push({
          name: "limit",
          value: parseInt($("#blog_comment_limit").val()),
        }),
        n.push({ name: "sys_lang_id", value: sys_lang_id }),
        $.ajax({
          url: base_url + "ajax_controller/add_blog_comment",
          type: "post",
          data: n,
          success: function (e) {
            1 == is_recaptcha_enabled && 0 == t && grecaptcha.reset(),
              $("#form_add_blog_comment")[0].reset();
            var a = JSON.parse(e);
            "message" == a.type
              ? (document.getElementById("message-comment-result").innerHTML =
                  a.html_content)
              : (document.getElementById("comment-result").innerHTML =
                  a.html_content);
          },
        });
    });
  }),
  $(document).on("click", ".btn-cart-product-quantity-item", function () {
    var e = $(this).val(),
      t = {
        product_id: $(this).attr("data-product-id"),
        quantity: e,
        sys_lang_id: sys_lang_id,
      };
    (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "cart_controller/update_cart_product_quantity",
        data: t,
        success: function (e) {
          location.reload();
        },
      });
  }),
  $(document).ready(function () {
    $("#use_same_address_for_billing").change(function () {
      $(this).is(":checked")
        ? $(".cart-form-billing-address").hide()
        : $(".cart-form-billing-address").show();
    });
  }),
  $(document).on("input paste click", "#input_location", function () {
    var e = $(this).val();
    if (
      (e.length > 0
        ? $(".btn-reset-location-input").show()
        : ($("#location_id_inputs input").val(""),
          $(".btn-reset-location-input").hide()),
      e.length < 3)
    )
      return $("#response_search_location").hide(), !1;
    var t = { input_value: e, sys_lang_id: sys_lang_id };
    (t[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/search_location",
        data: t,
        success: function (t) {
          var a = JSON.parse(t);
          1 == a.result &&
            ((document.getElementById("response_search_location").innerHTML =
              a.response),
            $("#response_search_location").show()),
            $("#response_search_location ul li a").wrapInTag({ words: [e] });
        },
      });
  }),
  ($.fn.wrapInTag = function (e) {
    var t = e.tag || "strong",
      a = e.words || [],
      n = RegExp(a.join("|"), "gi"),
      i = "<" + t + ">$&</" + t + ">";
    $(this)
      .contents()
      .each(function () {
        var t;
        3 === this.nodeType
          ? $(this).replaceWith(
              ((t = this), t.textContent ? t.textContent : t.innerText).replace(
                n,
                i
              )
            )
          : e.ignoreChildNodes || $(this).wrapInTag(e);
      });
  }),
  $(document).on("click", "#response_search_location ul li a", function () {
    $("#input_location").val($(this).text());
    var e = $(this).attr("data-country"),
      t = $(this).attr("data-state"),
      a = $(this).attr("data-city");
    $("#location_id_inputs").empty(),
      null != e &&
        0 != e &&
        $("#location_id_inputs").append(
          "<input type='hidden' value='" +
            e +
            "' name='country' class='input-location-filter'>"
        ),
      null != t &&
        0 != t &&
        $("#location_id_inputs").append(
          "<input type='hidden' value='" +
            t +
            "' name='state' class='input-location-filter'>"
        ),
      null != a &&
        0 != a &&
        $("#location_id_inputs").append(
          "<input type='hidden' value='" +
            a +
            "' name='city' class='input-location-filter'>"
        );
  }),
  $(document).on("click", "#btn_submit_location", function () {
    var e = {
      country_id: $("#location_id_inputs input[name='country']").val(),
      state_id: $("#location_id_inputs input[name='state']").val(),
      city_id: $("#location_id_inputs input[name='city']").val(),
      sys_lang_id: sys_lang_id,
    };
    (e[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "set-default-location-post",
        data: e,
        success: function (e) {
          location.reload();
        },
      });
  }),
  $(document).on("click", ".btn-reset-location-input", function () {
    $("#input_location").val(""),
      $("#location_id_inputs input").val(""),
      $(this).hide();
  }),
  $(document).on("click", function (e) {
    0 === $(e.target).closest(".filter-location").length &&
      $("#response_search_location").hide();
  }),
  $(document).on("input", "#input_search", function () {
    var e = $(".search_type_input").val(),
      t = $(this).val();
    if (t.length < 2) return $("#response_search_results").hide(), !1;
    var a = {
      search_type: e,
      input_value: t,
      lang_base_url: lang_base_url,
      sys_lang_id: sys_lang_id,
    };
    (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/ajax_search",
        data: a,
        success: function (e) {
          var a = JSON.parse(e);
          1 == a.result &&
            ((document.getElementById("response_search_results").innerHTML =
              a.response),
            $("#response_search_results").show()),
            $("#response_search_results ul li a").wrapInTag({ words: [t] });
        },
      });
  }),
  $(document).on("input", "#input_search_mobile", function () {
    var e = $("#search_type_input_mobile").val(),
      t = $(this).val();
    if (t.length < 2) return $("#response_search_results_mobile").hide(), !1;
    var a = {
      search_type: e,
      input_value: t,
      lang_base_url: lang_base_url,
      sys_lang_id: sys_lang_id,
    };
    (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/ajax_search",
        data: a,
        success: function (e) {
          var a = JSON.parse(e);
          1 == a.result &&
            ((document.getElementById(
              "response_search_results_mobile"
            ).innerHTML = a.response),
            $("#response_search_results_mobile").show()),
            $("#response_search_results_mobile ul li a").wrapInTag({
              words: [t],
            });
        },
      });
  }),
  $(document).on("click", function (e) {
    0 === $(e.target).closest(".top-search-bar").length &&
      $("#response_search_results").hide();
  }),
  $(document).on("change keyup paste", ".filter-search-input", function () {
    var e = $(this).attr("data-filter-id"),
      t = $(this).val().toLowerCase();
    $("#" + e + " li").each(function (e, a) {
      $(this).find("label").text().toLowerCase().indexOf(t) > -1
        ? $(this).show()
        : $(this).hide();
    });
  }),
  $(document).on("click", "#btn_filter_price", function () {
    var e = $("#price_min").val(),
      t = $("#price_max").val();
    if ("" != e || "" != t) {
      var a = $(this).attr("data-query-string"),
        n = $(this).attr("data-current-url"),
        i = "";
      "" != e
        ? ((i = "p_min=" + e), "" != t && (i += "&p_max=" + t))
        : "" != t && (i = "p_max=" + t),
        (a = "" == a ? "?" + i : "?" + a + "&" + i),
        window.location.replace(n + a);
    }
  }),
  $("#form_send_message").submit(function (e) {
    e.preventDefault();
    var t = $("#message_subject").val(),
      a = $("#message_text").val(),
      n = $("#message_receiver_id").val(),
      i = $("#message_send_em").val();
    if (t.length < 1) return $("#message_subject").addClass("is-invalid"), !1;
    if (($("#message_subject").removeClass("is-invalid"), a.length < 1))
      return $("#message_text").addClass("is-invalid"), !1;
    $("#message_text").removeClass("is-invalid");
    var o = $(this),
      s = o.find("input, select, button, textarea"),
      r = o.serializeArray();
    r.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) }),
      r.push({ name: "sys_lang_id", value: sys_lang_id }),
      s.prop("disabled", !0),
      $.ajax({
        url: base_url + "message_controller/add_conversation",
        type: "post",
        data: r,
        success: function (e) {
          s.prop("disabled", !1);
          var o = JSON.parse(e);
          1 == o.result &&
            ((document.getElementById("send-message-result").innerHTML =
              o.html_content),
            $("#form_send_message")[0].reset()),
            1 == i && send_message_as_email(o.sender_id, n, t, a);
        },
      });
  }),
  $("#form_send_request").submit(function (e) {
    e.preventDefault();
    var t = $("#message_subject").val(),
      a = $("#message_text").val(),
      n = $("#message_receiver_id").val(),
      i = $("#message_send_em").val();
    if (t.length < 1) return $("#message_subject").addClass("is-invalid"), !1;
    if (($("#message_subject").removeClass("is-invalid"), a.length < 1))
      return $("#message_text").addClass("is-invalid"), !1;
    $("#message_text").removeClass("is-invalid");
    var o = $(this),
      s = o.find("input, select, button, textarea"),
      r = o.serializeArray();
    r.push({ name: csfr_token_name, value: $.cookie(csfr_cookie_name) }),
      r.push({ name: "sys_lang_id", value: sys_lang_id }),
      s.prop("disabled", !0),
      $.ajax({
        url: base_url + "message_controller/add_request",
        type: "post",
        data: r,
        success: function (e) {
          s.prop("disabled", !1);
          var o = JSON.parse(e);
          1 == o.result &&
            ((document.getElementById("send-message-result").innerHTML =
              o.html_content),
            $("#form_send_request")[0].reset()),
            1 == i && send_message_as_email(o.sender_id, n, t, a);
        },
      });
  }),
  $(document).on("change", "#address_input", function () {
    update_product_map();
  }),
  $(document).on("change", "#zip_code_input", function () {
    update_product_map();
  }),
  $(document).on("click", ".btn-add-remove-wishlist", function () {
    var e = $(this).attr("data-product-id"),
      t = $(this).attr("data-reload");
    "0" == t &&
      ($(this).find("i").hasClass("icon-heart-o")
        ? ($(this).find("i").removeClass("icon-heart-o"),
          $(this).find("i").addClass("icon-heart"))
        : ($(this).find("i").removeClass("icon-heart"),
          $(this).find("i").addClass("icon-heart-o")));
    var a = { product_id: e, sys_lang_id: sys_lang_id };
    (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
      $.ajax({
        type: "POST",
        url: base_url + "add-remove-wishlist-post",
        data: a,
        success: function (e) {
          "1" == t && location.reload();
        },
      });
  }),
  $("#form_validate").submit(function () {
    $(".custom-control-validate-input").removeClass(
      "custom-control-validate-error"
    ),
      setTimeout(function () {
        $(".custom-control-validate-input .error").each(function () {
          var e = $(this).attr("name");
          $(this).is(":visible") &&
            ((e = e.replace("[]", "")),
            $(".label_validate_" + e).addClass(
              "custom-control-validate-error"
            ));
        });
      }, 100);
  }),
  $(".custom-control-validate-input input").click(function () {
    var e = $(this).attr("name");
    (e = e.replace("[]", "")),
      $(".label_validate_" + e).removeClass("custom-control-validate-error");
  }),
  $("#form_validate").validate(),
  $("#form_validate_service").validate(),
  $("#form_validate_search").validate(),
  $("#form_validate_search_mobile").validate(),
  $("#form_validate_newsletter").validate(),
  $("#form_add_cart").validate(),
  $("#form_validate_checkout").validate(),
  $("#form_add_cart").submit(function () {
    $("#form_add_cart .custom-control-variation input").each(function () {
      if ($(this).hasClass("error")) {
        var e = $(this).attr("id");
        $("#form_add_cart .custom-control-variation label").each(function () {
          $(this).attr("for") == e && $(this).addClass("is-invalid");
        });
      } else {
        e = $(this).attr("id");
        $("#form_add_cart .custom-control-variation label").each(function () {
          $(this).attr("for") == e && $(this).removeClass("is-invalid");
        });
      }
    });
  }),
  $(document).on("click", ".custom-control-variation input", function () {
    var e = $(this).attr("name");
    $(".custom-control-variation label").each(function () {
      $(this).attr("data-input-name") == e && $(this).removeClass("is-invalid");
    });
  }),
  $(document).ready(function () {
    $(".validate_terms").submit(function (e) {
      console.log("test"),
        $(".custom-control-validate-input p").remove(),
        $(".custom-control-validate-input input").is(":checked")
          ? $(".custom-control-validate-input").removeClass(
              "custom-control-validate-error"
            )
          : (e.preventDefault(),
            $(".custom-control-validate-input").addClass(
              "custom-control-validate-error"
            ),
            $(".custom-control-validate-input").append(
              "<p class='text-danger'>" + msg_accept_terms + "</p>"
            ));
    });
  }),
  $(document).on(
    "input keyup paste change",
    ".validate_price .price-input",
    function () {
      var e = $(this).val();
      (e = e.replace(",", ".")),
        $.isNumeric(e) && 0 != e
          ? $(this).removeClass("is-invalid")
          : $(this).addClass("is-invalid");
    }
  ),
  $(document).ready(function () {
    $(".validate_price").submit(function (e) {
      $(".validate_price .validate-price-input").each(function () {
        var t = $(this).val();
        "" != t &&
          ((t = t.replace(",", ".")),
          $.isNumeric(t) && 0 != t
            ? $(this).removeClass("is-invalid")
            : (e.preventDefault(),
              $(this).addClass("is-invalid"),
              $(this).focus()));
      });
    });
  }),
  $(document).on(
    "input keyup paste change keypress",
    ".price-input",
    function () {
      if (
        ("undefined" == typeof thousands_separator &&
          (thousands_separator = "."),
        "." == thousands_separator)
      ) {
        var e = $(this);
        (46 == event.which && -1 == e.val().indexOf(".")) ||
          !(event.which < 48 || event.which > 57) ||
          0 == event.which ||
          8 == event.which ||
          event.preventDefault(),
          -1 != (t = $(this).val()).indexOf(".") &&
            t.substring(t.indexOf(".")).length > 2 &&
            0 != event.which &&
            8 != event.which &&
            $(this)[0].selectionStart >= t.length - 2 &&
            event.preventDefault();
      } else {
        var t;
        e = $(this);
        (44 == event.which && -1 == e.val().indexOf(",")) ||
          !(event.which < 48 || event.which > 57) ||
          0 == event.which ||
          8 == event.which ||
          event.preventDefault(),
          -1 != (t = $(this).val()).indexOf(",") &&
            t.substring(t.indexOf(",")).length > 2 &&
            0 != event.which &&
            8 != event.which &&
            $(this)[0].selectionStart >= t.length - 2 &&
            event.preventDefault();
      }
    }
  ),
  $(document).ready(function () {
    $("iframe").attr("allowfullscreen", "");
  }),
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

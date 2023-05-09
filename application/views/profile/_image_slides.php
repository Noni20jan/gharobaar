<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $video = $this->file_model->get_user_story_video($user_id); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript">
window._wpemojiSettings = {
    "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/13.0.1\/72x72\/",
    "ext": ".png",
    "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/13.0.1\/svg\/",
    "svgExt": ".svg",
    "source": {
        "concatemoji": "https:\/\/amazingcarousel.com\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.6.1"
    }
};
! function(e, a, t) {
    var n, r, o, i = a.createElement("canvas"),
        p = i.getContext && i.getContext("2d");

    function s(e, t) {
        var a = String.fromCharCode;
        p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, e), 0, 0);
        e = i.toDataURL();
        return p.clearRect(0, 0, i.width, i.height), p.fillText(a.apply(this, t), 0, 0), e === i.toDataURL()
    }

    function c(e) {
        var t = a.createElement("script");
        t.src = e, t.defer = t.type = "text/javascript", a.getElementsByTagName("head")[0].appendChild(t)
    }
    for (o = Array("flag", "emoji"), t.supports = {
            everything: !0,
            everythingExceptFlag: !0
        }, r = 0; r < o.length; r++) t.supports[o[r]] = function(e) {
        if (!p || !p.fillText) return !1;
        switch (p.textBaseline = "top", p.font = "600 32px Arial", e) {
            case "flag":
                return s([127987, 65039, 8205, 9895, 65039], [127987, 65039, 8203, 9895, 65039]) ? !1 : !s([55356,
                    56826, 55356, 56819
                ], [55356, 56826, 8203, 55356, 56819]) && !s([55356, 57332, 56128, 56423, 56128, 56418, 56128,
                    56421, 56128, 56430, 56128, 56423, 56128, 56447
                ], [55356, 57332, 8203, 56128, 56423, 8203, 56128, 56418, 8203, 56128, 56421, 8203, 56128,
                    56430, 8203, 56128, 56423, 8203, 56128, 56447
                ]);
            case "emoji":
                return !s([55357, 56424, 8205, 55356, 57212], [55357, 56424, 8203, 55356, 57212])
        }
        return !1
    }(o[r]), t.supports.everything = t.supports.everything && t.supports[o[r]], "flag" !== o[r] && (t.supports
        .everythingExceptFlag = t.supports.everythingExceptFlag && t.supports[o[r]]);
    t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && !t.supports.flag, t.DOMReady = !1, t
        .readyCallback = function() {
            t.DOMReady = !0
        }, t.supports.everything || (n = function() {
                t.readyCallback()
            }, a.addEventListener ? (a.addEventListener("DOMContentLoaded", n, !1), e.addEventListener("load", n, !1)) :
            (e.attachEvent("onload", n), a.attachEvent("onreadystatechange", function() {
                "complete" === a.readyState && t.readyCallback()
            })), (n = t.source || {}).concatemoji ? c(n.concatemoji) : n.wpemoji && n.twemoji && (c(n.twemoji), c(n
                .wpemoji)))
}(window, document, window._wpemojiSettings);
</script>
<script type='text/javascript'
    src='https://amazingcarousel.com/wp-content/uploads/amazingcarousel/sharedengine/amazingcarousel.js?ver=1.2'
    id='amazingcarousel-script-js'></script>
<link rel="https://api.w.org/" href="https://amazingcarousel.com/wp-json/" />
<link rel="alternate" type="application/json" href="https://amazingcarousel.com/wp-json/wp/v2/pages/2036" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml"
    href="https://amazingcarousel.com/wp-includes/wlwmanifest.xml" />
<script>
(function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-42549293-1', 'auto')
ga('send', 'pageview');
</script>

<style type="text/css">
img.wp-smiley,
img.emoji {
    display: inline !important;
    border: none !important;
    box-shadow: none !important;
    height: 1em !important;
    width: 1em !important;
    margin: 0 .07em !important;
    vertical-align: -0.1em !important;
    background: none !important;
    padding: 0 !important;
}

.amazingcarousel-hover-effect {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: center center;
    display: none;
}
</style>
<style>
.test {
    cursor: pointer;
    padding: 0 5px;
    display: inline-block;
    /* margin: 0 0 15px; */
    color: #aaa;
    transition: .2s;
    position: absolute;
    top: 85%;
    /* border: 1px red solid; */

}

i>span {
    color: red;
}

i:hover {
    color: #666;
}

.test:before {
    font-family: fontawesome;
    content: '\f004';
    font-style: normal;
}

i.press {
    animation: size .4s;
    color: red;
}



@keyframes fade {
    0% {
        color: transparent;
    }

    50% {
        color: black;
    }

    100% {
        color: transparent;
    }
}

@keyframes size {
    0% {
        padding: 0px 12px;
    }

    50% {
        padding: 0px 16px;
    }

    100% {
        padding: 0px 8px;
    }
}

.slick-arrow {
    color: black;
}

.items {
    width: 90%;
    margin: 0px auto;
    margin-top: 100px
}

.slick-slide {
    margin: 10px
}

.slick-slide img {
    width: 100%;
    max-height: 259px;
    border: 0px solid #fff
}

.image-heading {
    text-align: left;
    font-size: 28px;
    font-weight: 600;
    /* margin-bottom: 20px; */
    margin-left: 0%;
}
</style>

<?php $image_count = 0;
if (!empty($product_images)) {
    $image_count = item_count($product_images);
} ?>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>

<div class="image-heading row">Seller's Gallery</div>
<?php if (count($product_images) > 0) : ?>
<div class="item">
    <script type='text/javascript'
        src='https://amazingcarousel.com/wp-content/uploads/amazingcarousel/sharedengine/amazingcarousel.js?ver=1.2'
        id='amazingcarousel-script-js'></script>
    <link rel="https://api.w.org/" href="https://amazingcarousel.com/wp-json/" />
    <link rel="alternate" type="application/json" href="https://amazingcarousel.com/wp-json/wp/v2/pages/2036" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml"
        href="https://amazingcarousel.com/wp-includes/wlwmanifest.xml" />

    <!-- GA Google Analytics @ https://m0n.co/ga -->
    <!-- <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-42549293-1', 'auto');
            ga('send', 'pageview');
        </script> -->




    <body class="home page-template-default page page-id-2036 single-author singular two-column right-sidebar">

        <link rel="stylesheet" type="text/css" media="all"
            href="<?php echo base_url(); ?>assets/css/initcarousel.css" />


        <div id="amazingcarousel-container-7">

            <div id="amazingcarousel-7"
                style="display:none;position:relative;width:100%;max-width:960px;margin:0px auto 0px;">

                <div class="amazingcarousel-list-container">

                    <ul class="amazingcarousel-list">
                        <?php if ($video != null) : ?>
                        <li class="amazingcarousel-item">
                            <div class="amazingcarousel-item-container">
                                <div class="amazingcarousel-image">
                                    <a href="<?php echo get_user_video_url($video); ?>" title="" class="html5lightbox"
                                        data-group=""> <video style="outline:none;" width="200" height="200" controls>
                                            <source src="<?php echo get_user_video_url($video); ?>" type="video/mp4">
                                            Your browser does not support HTML video.
                                        </video></a>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php foreach ($product_images as $image) : ?>
                        <li class="amazingcarousel-item">
                            <div class="amazingcarousel-item-container">
                                <div class="amazingcarousel-image">
                                    <a href="<?php echo get_story_image_url($image, 'image_default'); ?>" title=""
                                        class="html5lightbox" data-group=""><img
                                            src="<?php echo get_story_image_url($image, 'image_default'); ?>"
                                            alt="" /></a>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>

                    </ul>

                    <div class="amazingcarousel-prev"></div>

                    <div class="amazingcarousel-next"></div>

                </div>

                <div class="amazingcarousel-nav"></div>

            </div>

        </div>

        <script src="<?php echo base_url(); ?>assets/js/initcarousel.js"></script>



        <div id="wonderpluginlightbox_options" data-skinsfoldername="skins/default/"
            data-jsfolder="https://amazingcarousel.com/wp-content/plugins/wonderplugin-lightbox/engine/"
            data-autoslide="false" data-slideinterval="5000" data-showtimer="true" data-timerposition="bottom"
            data-timerheight="2" data-timercolor="#dc572e" data-timeropacity="1" data-navarrowspos="inside"
            data-closepos="outside" data-enteranimation="" data-exitanimation="" data-showplaybutton="false"
            data-alwaysshownavarrows="false" data-bordersize="8" data-showtitleprefix="false" data-responsive="true"
            data-fullscreenmode="false" data-fullscreentextoutside="true" data-closeonoverlay="true"
            data-videohidecontrols="false" data-titlestyle="bottom" data-imagepercentage="75"
            data-enabletouchswipe="true" data-autoplay="true" data-html5player="true" data-overlaybgcolor="#000"
            data-overlayopacity="0.8" data-defaultvideovolume="1" data-bgcolor="#FFF" data-borderradius="0"
            data-thumbwidth="96" data-thumbheight="72" data-thumbtopmargin="12" data-thumbbottommargin="12"
            data-barheight="64" data-showtitle="true" data-titleprefix="%NUM / %TOTAL"
            data-titlebottomcss="color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;"
            data-showdescription="true"
            data-descriptionbottomcss="color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;"
            data-titleinsidecss="color:#fff; font-size:16px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left;"
            data-descriptioninsidecss="color:#fff; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;"
            data-titleoutsidecss="color:#fff; font-size:18px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:center; margin: 8px;"
            data-descriptionoutsidecss="color:#fff; font-size:14px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:center; margin:8px; padding: 0px;"
            data-videobgcolor="#000" data-html5videoposter="" data-responsivebarheight="false"
            data-smallscreenheight="415" data-barheightonsmallheight="64" data-notkeepratioonsmallheight="false"
            data-showsocial="false" data-socialposition="position:absolute;top:100%;right:0;"
            data-socialpositionsmallscreen="position:absolute;top:100%;right:0;left:0;"
            data-socialdirection="horizontal" data-socialbuttonsize="32" data-socialbuttonfontsize="18"
            data-socialrotateeffect="true" data-showfacebook="true" data-showtwitter="true" data-showpinterest="true"
            data-bordertopmargin="48" data-shownavigation="true" data-navbgcolor="rgba(0,0,0,0.2)"
            data-shownavcontrol="true" data-hidenavdefault="false" data-hidenavigationonmobile="false"
            data-hidenavigationonipad="false" style="display:none;"></div>
        <script type='text/javascript' src='https://amazingcarousel.com/wp-includes/js/comment-reply.min.js?ver=5.6.1'
            id='comment-reply-js'></script>
        <script type='text/javascript' src='https://amazingcarousel.com/wp-includes/js/wp-embed.min.js?ver=5.6.1'
            id='wp-embed-js'></script>
</div>
<?php else : ?>
<div>
    No media available.
</div>
<?php endif; ?>




<?php if (item_count($product_images) <= 7) : ?>
<style>
.product-thumbnails-slider .slick-track {
    transform: none !important;
}
</style>
<?php endif; ?>

<script>
$('#productVideoModal').on('hidden.bs.modal', function(e) {
    $(this).find('video')[0].pause();
});
$('#productAudioModal').on('hidden.bs.modal', function(e) {
    Amplitude.pause();
});
</script>

<script>
function likePic(test) {
    var id = test.id.split("-");
    var classnam = test.className.split(" ");
    $("#img-" + id[1]).toggleClass("press", 1000);
    $("#img-" + id[1]).prop('disabled', true);
    var liked = 1;
    if (classnam[1] != undefined) {
        var liked = 0;
    }

    var num_likes = parseInt($('#span-' + id[1])[0].innerText.split(" ")[0]);
    if (liked) {
        num_likes++;
    } else {
        num_likes--;
    }

    if (num_likes <= 1) {
        $('#span-' + id[1])[0].innerText = num_likes + " like";
    } else {
        $('#span-' + id[1])[0].innerText = num_likes + " likes";
    }

    var data = {
        "image_id": id[1],
        "user_id": <?php echo $user->id; ?>,
        "liked": liked
    }
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        url: base_url + "like_controller/add_like",
        type: "post",
        data: data,
        success: function(response) {
            // location.reload();
            $("#img-" + id[1]).prop('disabled', false);
            console.log(response);
        }
    })
}
</script>
<script>
$(document).ready(function() {
    setTimeout(function() {
        $(".amazingcarousel-image").each(function() {
            $(".amazingcarousel-list-wrapper").css('border-radius', '40px');
            if ($(this)[0].childNodes.length == 5) {
                $($(this)[0].childNodes[4]).css({
                    opacity: 0
                });
            }
            if ($(this)[0].childNodes.length == 4) {
                $($(this)[0].childNodes[3]).css({
                    opacity: 0
                });
            }
        });
        console.log("test")
    }, 10)
})
</script>
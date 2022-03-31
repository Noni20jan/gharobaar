<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<style>
    .flexed-reviews {
        display: flex;
        max-height: 200px;
        overflow-y: auto;
    }

    @media screen and (max-width: 800px) {
        .flexed-reviews {
            display: block !important;
            height: auto;
            overflow-y: scroll;
        }

        #reviews-for-mobile-view {
            display: block !important;
        }

        #reviews-for-web {
            display: none !important;
        }
    }

    .reviews-container .list-reviews .media {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 0px solid rgba(0, 0, 0, 0.08);
    }

    #reviews-for-mobile-view {
        display: none;
    }

    #reviews-for-web {
        display: block;
    }

    /* for see more on reviews */
    .addReadMore.showlesscontent .SecSec,
    .addReadMore.showlesscontent .readLess {
        display: none;
    }

    .addReadMore.showmorecontent .readMore {
        display: none;
    }

    .addReadMore .readMore,
    .addReadMore .readLess {
        margin-left: 2px;
        cursor: pointer;
        color: #007C05;
    }

    .addReadMoreWrapTxt.showmorecontent .SecSec,
    .addReadMoreWrapTxt.showmorecontent .readLess {
        display: block;
    }

    .transition {
        -webkit-transform: scale(1.5);
        -moz-transform: scale(1.5);
        -o-transform: scale(1.5);
        transform: scale(1.5);
    }
</style>
<div class="container">
    <div class="reviews-container">
        <div class="row" id="reviews-for-web">
            <div class="col-12">
                <div class="review-total">
                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</label>
                    <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id) : ?>
                        <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                    <?php endif; ?>
                    <?php if (!empty($reviews)) :
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                    endif; ?>
                </div>
                <?php if (empty($reviews)) : ?>
                    <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
                <?php else : ?>
                    <div class="row list-unstyled list-reviews flexed-reviews">
                        <?php foreach ($reviews as $review) : ?>
                            <?php if ($product->id == $review->product_id) : ?>
                                <div class="col-6 media">
                                    <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                                    <div class="media-body">
                                        <div class="row-custom">
                                            <?php $this->load->view('partials/_review_stars', ['review' => $review->rating]); ?>
                                        </div>
                                        <div class="row-custom">

                                            <h5 class="username"><?php echo get_first_last_name_by_user_id($review->user_id); ?></h5>

                                        </div>
                                        <div class="row-custom">
                                            <div class="review">
                                                <p class="addReadMore showlesscontent"><?php echo html_escape($review->review); ?></p>
                                            </div>
                                        </div>
                                        <div class="row-custom">

                                            <?php foreach ($review_images as $image) : ?>
                                                <?php if ($review->id == $image->id) : ?>
                                                    <img id="review_image1" class="review_image small" src="<?php echo base_url() . $image->image_url; ?> " style="border-radius:10%;width:100px;height:100px" />
                                                <?php endif ?>
                                            <?php endforeach; ?>

                                        </div>
                                        <div class="row-custom">
                                            <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row" id="reviews-for-mobile-view">
            <div class="col-12">
                <div class="review-total">
                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</label>
                    <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id) : ?>
                        <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                    <?php endif; ?>
                    <?php if (!empty($reviews)) :
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                    endif; ?>
                </div>
                <?php if (empty($reviews)) : ?>
                    <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
                <?php else : ?>
                    <ul class="list-unstyled list-reviews flexed-reviews">
                        <?php foreach ($reviews as $review) : ?>
                            <?php if ($product->id == $review->product_id) : ?>
                                <li class="media">
                                    <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                        <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                                    </a>
                                    <div class="media-body">
                                        <div class="row-custom">
                                            <?php $this->load->view('partials/_review_stars', ['review' => $review->rating]); ?>
                                        </div>
                                        <div class="row-custom">
                                            <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                                <h5 class="username"><?php echo get_shop_name_by_user_id($review->user_id); ?></h5>
                                            </a>
                                        </div>
                                        <div class="row-custom">
                                            <div class="review">
                                                <p class="addReadMore showlesscontent"><?php echo html_escape($review->review); ?></p>
                                            </div>
                                        </div>
                                        <div class="row-custom">
                                            <?php foreach ($review_images as $image) : ?>
                                                <?php if ($review->id == $image->id) : ?>
                                                    <img id="review_image1" class="review_image small" src="<?php echo base_url() . $image->image_url; ?> " style="border-radius:10%;width:100px;height:100px" />
                                                <?php endif ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="row-custom">
                                            <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.review_image').hover(function() {
            $(this).addClass('transition');
            // other code     
        }, function() {
            $(this).removeClass('transition');
        });
    });
</script>

<!-- <script>
    var str = "your long string with many words.";
    var wordCount = str.match(/(\w+)/g).length;
    console.log(wordCount);
</script>
<script>
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 100; // How many characters are shown by default
        var ellipsestext = "";
        var moretext = "See More";
        var lesstext = "See Less";

        $('.more').each(function() {
            var content = $(this).html();

            var content_length = content.split(' ').length;


            const splitWords = (text, numWords) => {
                const words = text.split(' ')
                let part1 = '',
                    part2 = ''
                words.forEach((word, idx) => {
                    if (idx < numWords) {
                        part1 += ' ' + word
                    } else {
                        part2 += ' ' + word
                    }
                })
                return [part1.trim(), part2.trim()]
            }

            const [part1, part2] = splitWords(content, showChar);


            if (content_length > showChar) {

                var c = part1;
                var h = part2;

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span> <span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="see_more morelink" >' + moretext + '</a></span>';

                $(this).html(html);
            }

        });
        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script> -->


<!-- see more script -->
<script>
    function AddReadMore() {
        //This limit you can set after how much characters you want to show Read More.
        var carLmt = 30;
        // Text to show when text is collapsed
        var readMoreTxt = " ... Read More";
        // Text to show when text is expanded
        var readLessTxt = " Read Less";


        //Traverse all selectors with this class and manupulate HTML part to show Read More
        $(".addReadMore").each(function() {
            if ($(this).find(".firstSec").length)
                return;

            var allstr = $(this).text();
            if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
            }

        });
        //Read More and Read Less Click Event binding
        $(document).on("click", ".readMore,.readLess", function() {
            $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
        });
    }
    $(function() {
        //Calling function after Page Load
        AddReadMore();
    });


    // $(function() {

    //     var maxL = 40;
    //     var i = 0;
    //     $('.content').each(function() {

    //         var text = $(this).text();
    //         if (text.length > maxL) {
    //             var begin = text.substr(0, maxL),
    //                 end = text.substr(maxL);

    //             $(this).html(begin)
    //                 .append($('<a class="readmore"/>').html(' ...more'))
    //                 .append($('<div class="more-review" />').html(end));
    //         }
    //     });

    //     $(document).on('click', '.readmore', function() {
    //         // i++;
    //         $(this).html('');
    //         // if (i % 2 != 0) {
    //         //     $(this).html(' ...less');
    //         // } else {
    //         //     $(this).html(' ...more');
    //         // }
    //         // $(this).next('.readmore').html('');
    //         // $(this).next('.readmore').fadeOut("400");
    //         $(this).next('.more-review').slideToggle(400);

    //     })
    // })
</script>
<!-- end for see more -->
<?php $this->load->view('partials/_modal_rate_product'); ?>
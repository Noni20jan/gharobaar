<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* width */
    .col-12 .row .categories-for-mobile::-webkit-scrollbar {
        width: 4px;
    }

    .col-12 .row .categories-for-mobile {
        scrollbar-color: #fff0 #fff0;
    }
</style>
<?php if ($this->auth_check) {
    if ($this->auth_user->user_type == "guest") {
        redirect(base_url() . 'logout');
    }
} ?>
<div id="wrapper">
    <div class="container">
        <div class="row categories-for-mobile" id="only-for-mobile">
            <?php $this->load->view("partials/categories_for_mobile"); ?>
        </div>
        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">Shop By Category</h3>
        </div>

        <?php switch ($category->id):
            case 1: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/men"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_1.png" alt="men">
                            <p class="category_page_title">Men</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/women"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_2.png" alt="women">
                            <p class="category_page_title">Women</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/jewellery"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_3.png" alt="jewellery">
                            <p class="category_page_title">Jewellery</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/bags-wallets"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_4.png" alt="Bags-Wallets">
                            <p class="category_page_title">Bags & Wallets</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/accessories"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_5.png" alt="Accessories">
                            <p class="category_page_title">Accessories</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("fashion/footwear"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_6.png" alt="Footwear">
                            <p class="category_page_title">Footwear</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 2: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <input type="hidden" id="category_modal" value="home_cooks_product">
                        <a href="<?php echo generate_url("home-cooks/fresh-baked-items"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_cooks_imgs/home_cooks_1.png" alt="Fresh-Baked-Items">
                            <p class="category_page_title">Fresh Baked Items</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home-cooks//fresh-home-food"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_cooks_imgs/home_cooks_2.png" alt="Fresh-Home-Food">
                            <p class="category_page_title">Fresh Home Food</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 3: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/coffee-tea-beverages"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_1.png" alt="Coffee-Tea-Beverages">
                            <p class="category_page_title">Coffee Tea & Beverages</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/cooking-baking"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_2.png" alt="Cooking-Baking">
                            <p class="category_page_title">Cooking & Baking</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/dairy"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_3.png" alt="Dairy">
                            <p class="category_page_title">Dairy</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/fruits-and-veggies"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_4.png" alt="Fruits-Veggies">
                            <p class="category_page_title">Fruits & Veggies</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/packaged-frozen"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_5.png" alt="Packaged-Frozen">
                            <p class="category_page_title">Packaged & Frozen</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/pickles-jams-spreads"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_6.png" alt="Pickles-Jams-Spreads">
                            <p class="category_page_title">Pickles/Jams/ Spreads</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("grocery/snack-foods"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_7.png" alt="Foods">
                            <p class="category_page_title">Foods</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 4: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/bed-bath"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_1.png" alt="Bed-Bath">
                            <p class="category_page_title">Bed & Bath</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/furniture-garden-outdoors"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_2.png" alt="Furniture-Garden-Outdoor">
                            <p class="category_page_title">Furniture/ Garden/ Outdoor</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/home-accents"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_3.png" alt="Home-Accents">
                            <p class="category_page_title">Home Accents</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/home-care-cleaning"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_4.png" alt="Home-Care-Cleaning">
                            <p class="category_page_title">Home Care & Cleaning</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/kitchen"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_5.png" alt="Kitchen">
                            <p class="category_page_title">Kitchen</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/living"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_6.png" alt="Living">
                            <p class="category_page_title">Living</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("home/tableware-barware"); ?>"><img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_7.png" alt="Tableware">
                            <p class="category_page_title">Tableware</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 5: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/bath-skin"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_1.png" alt="Bath-kin">
                            <p class="category_page_title">Bath & Skin</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/dental"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_2.png" alt="Dental">
                            <p class="category_page_title">Dental</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/essentials"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_3.png" alt="Essentials">
                            <p class="category_page_title">Essentials</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/hair-makeup-nails"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_4.png" alt="Hair-Makeup-Nails">
                            <p class="category_page_title">Hair, Makeup & Nails</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/pet-supplies"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_5.png" alt="Pet-Supplies">
                            <p class="category_page_title">Pet Supplies</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("personal-care-lifestyle/sports-fitness"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_6.png" alt="Sports-Fitness">
                            <p class="category_page_title">Sports & Fitness</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 6: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/accessories-39"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_1.png" alt="Accessories">
                            <p class="category_page_title">Accessories</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/apparel"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_2.png" alt="Apparel">
                            <p class="category_page_title">Apparel</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/diapering-feeding"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_3.png" alt="Diapering-Feeding">
                            <p class="category_page_title">Diapering & Feeding</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/food-products"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_4.png" alt="Food Products">
                            <p class="category_page_title">Food Products</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/footwear"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_5.png" alt="Footwear">
                            <p class="category_page_title">Footwear</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/fun-learning"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_6.png" alt="Fun-Learning">
                            <p class="category_page_title">Fun & Learning</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/kids-care-products"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_7.png" alt="Kids-Care-Products">
                            <p class="category_page_title">Kids Care Products</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/kids-room"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_8.png" alt="Kids-Room">
                            <p class="category_page_title">Kids Room</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("kids-corner/school-stationery"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_9.png" alt="School-Stationary">
                            <p class="category_page_title">School Stationery</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 7: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("art-stationery/drawings-paintings"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_1.png" alt="Drawings-Paintings">
                            <p class="category_page_title">Drawings & Paintings</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("art-stationery/art-craft"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_2.png" alt="Art-Craft">
                            <p class="category_page_title">Art & Craft</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("art-stationery/magnets-keychains"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_3.png" alt="Magnets-Keychains">
                            <p class="category_page_title">Magnets & Keychains</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("art-stationery/stationery"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_4.png" alt="Stationary">
                            <p class="category_page_title">Stationery</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("art-stationery/tech-accessories"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_5.png" alt="Tech-Accessories">
                            <p class="category_page_title">Tech Accessories</p>
                        </a>
                    </div>
                </div>
            <?php break;
            case 8: ?>
                <div class="row shop-by-center">
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("gifts-festivities/all-things-festive"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/gifts_for_you_imgs/gifts_for_you_1.png" alt="All-Things-Festive">
                            <p class="category_page_title">All Things Festive</p>
                        </a>
                    </div>
                    <div class="col-2 two-for-mobile">
                        <a href="<?php echo generate_url("gifts-festivities/gift-wrapping-supplies"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/gifts_for_you_imgs/gifts_for_you_2.png" alt="Gift-Wrapping-Supplies">
                            <p class="category_page_title">Gift Wrapping Supplies</p>
                        </a>
                    </div>
                    <div class=" col-2 two-for-mobile">
                        <a href="<?php echo generate_url("gifts-festivities/hampers-gifts"); ?>">
                            <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/gifts_for_you_imgs/gifts_for_you_3.png" alt="Hampers-Gifts">
                            <p class="category_page_title">Hampers & Gifts</p>
                        </a>
                    </div>
                </div>
        <?php break;
        endswitch; ?>

        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">All in <?php echo $category->name; ?></h3>
        </div>

        <div class="row categories-for-mobile" style="padding-bottom: 12px;">
            <?php foreach ($subcategories as $sub_cat) : ?>
                <a href="<?php echo generate_category_url($sub_cat); ?>">
                    <p class="all-in-categoty"><?php echo category_name($sub_cat); ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="row categories-for-mobile" id="top-picks-container" style="margin-top: 10px; text-align:inherit !important;">
            <!--print products-->
            <?php foreach ($latest_products as $product) : ?>
                <?php if ($product->is_shop_open == "1") : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="col-12 text-center">
            <div class="btn btn-md btn-view-more-new m-t-15 m-b-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
                <a id="show_more_products" class="view-new-text" href="<?= generate_category_url($category) ?>">View All Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var category = $('#category_modal').val();
        if (category == "home_cooks_product") {
            $('#locateModal').modal('show');
        }
    });
</script>
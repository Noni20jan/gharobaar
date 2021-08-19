<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- custom style style -->

<!-- <?php var_dump(get_filters()); ?> -->
<?php $sellers = get_products();
$unique_state_array = array();
foreach ($sellers as $seller) {
    $value = $seller->product_state;
    if (!in_array($value, $unique_state_array, true) && !empty($value)) {
        array_push($unique_state_array, $value);
    }
}

//var_dump($unique_state_array);
?>
<style>
    @media (max-width: 768px) {
        .svg-fotter {
            position: absolute;
            top: -5%;
            left: 0;
        }
    }

    .veg-non-veg {
        position: absolute;
        /* left: -44px; */
        right: 297px;
        top: 6px;
    }

    @media only screen and (max-width: 900px) {
        .veg-non-veg {
            float: left;
        }
    }



    .active_non-veg {
        padding: .2rem .9rem !important;
        border-radius: 20px !important;
        line-height: 1.5 !important;
        color: #fff !important;
        background-color: red;
    }

    @media only screen and (max-width: 900px) {
        .active_non-veg {
            padding: .2rem .7rem !important;
            border-radius: 20px !important;
            line-height: 1.5 !important;
            color: #fff !important;
            background-color: red;
        }
    }

    .active_veg {
        padding: .2rem .9rem !important;
        border-radius: 20px !important;
        line-height: 1.5 !important;
        color: #fff !important;
        background-color: green;
    }



    @media only screen and (max-width: 900px) {
        .active_veg {
            padding: .2rem .7rem !important;
            border-radius: 20px !important;
            line-height: 1.5 !important;
            color: #fff !important;
            background-color: green;
        }
    }

    .non-active_non-veg {
        padding: .2rem .9rem !important;
        border-radius: 20px !important;
        line-height: 1.5 !important;
        color: black !important;
        background-color: transparent;
        border: 1px solid red;
    }

    @media only screen and (max-width: 900px) {
        .non-active_non-veg {
            padding: .2rem .7rem !important;
            border-radius: 20px !important;
            line-height: 1.5 !important;
            color: black !important;
            background-color: transparent;
            border: 1px solid red;

        }
    }

    .non-active_veg {
        padding: .2rem .9rem !important;
        border-radius: 20px !important;
        line-height: 1.5 !important;
        color: black !important;
        background-color: transparent;
        border: 1px solid green;

    }

    @media only screen and (max-width: 900px) {
        .non-active_veg {
            padding: .2rem .7rem !important;
            border-radius: 20px !important;
            line-height: 1.5 !important;
            color: black !important;
            background-color: transparent;
            border: 1px solid green;
        }
    }

    @media (max-width: 768px) {
        .btn-filter-products-mobile {
            width: 49% !important;
            height: 36px;
            position: absolute;
            right: 2px;
            top: 41px;
            border: 1px solid #e2e2e2;
        }
    }

    #product_filter {
        float: left;
    }

    @media (max-width: 768px) {
        #product_filter {
            float: left;
            position: relative;
            top: 9px;
        }
    }
</style>

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
<div id="wrapper">
    <div class="container">

        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($parent_categories)) :
                            foreach ($parent_categories as $item) :
                                if ($item->id == $category->id) : ?>
                                    <li class="breadcrumb-item active"><?php echo category_name($item); ?></li>
                                <?php else : ?>
                                    <li class="breadcrumb-item"><a href="<?php echo generate_category_url($item); ?>"><?php echo category_name($item); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php else :
                            $breadcrumbs = breadcrumbs();
                            foreach ($breadcrumbs as $bread) :
                            ?>
                                <li class="breadcrumb-item active"><?php echo $bread; ?></li>

                        <?php endforeach;
                        endif; ?>

                    </ol>
                </nav>
            </div>
        </div>
        <hr>
        <?php
        $search = clean_str($this->input->get('search', TRUE));
        if (!empty($search)) : ?>
            <input type="hidden" name="search" value="<?= $search; ?>">
        <?php endif; ?>
        <div class="row">
            <div class="col-12 product-list-header">
                <?php if (!empty($category)) : ?>
                    <h1 class="page-title product-list-title"><?php echo category_name($category); ?></h1>
                <?php else : ?>
                    <h1 class="page-title product-list-title"><?php echo trans("products"); ?></h1>
                <?php endif; ?>


                <div class="product-sort-by">
                    <span class="span-sort-by"><?php echo trans("sort_by"); ?></span>
                    <?php $filter_sort = str_slug($this->input->get('sort', true)); ?>
                    <div class="sort-select">
                        <select class="custom-select" onchange="window.location.replace(this.value);" style="border-radius: 20px;">
                            <option value="<?= current_url() . generate_filter_url($query_string_array, 'sort', 'most_recent'); ?>" <?= $filter_sort == 'most_recent' ? ' selected' : ''; ?>><?= trans("latest_first"); ?></option>
                            <option value="<?= current_url() . generate_filter_url($query_string_array, 'sort', 'oldest_first'); ?>" <?= $filter_sort == 'oldest_first' ? ' selected' : ''; ?>><?= trans("oldest_first"); ?></option>
                            <option value="<?= current_url() . generate_filter_url($query_string_array, 'sort', 'lowest_price'); ?>" <?= $filter_sort == 'lowest_price' ? ' selected' : ''; ?>><?= trans("lowest_price"); ?></option>
                            <option value="<?= current_url() . generate_filter_url($query_string_array, 'sort', 'highest_price'); ?>" <?= $filter_sort == 'highest_price' ? ' selected' : ''; ?>><?= trans("highest_price"); ?></option>
                            <option value="<?= current_url() . generate_filter_url($query_string_array, 'sort', 'top_discount'); ?>" <?= $filter_sort == 'top_discount' ? ' selected' : ''; ?>><?= "Top Discount" ?></option>

                        </select>
                    </div>
                </div>
                <?php if (isset($category)) : ?>
                    <div class="veg-non-veg">
                        <?php if ($category->id == 2) : ?>


                            <a type="button" id="veg" class="<?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'Veg') ? "active_veg" : "non-active_veg" ?>" href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'Veg'); ?>">Veg

                            </a>
                            <a type="button" id="non_veg" class="<?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'non_Veg') ? "active_non-veg" : "non-active_non-veg" ?>" href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'non_Veg'); ?>">Non Veg

                            </a>

                        <?php elseif (isset($parent_category)) : ?>
                            <?php if ($parent_category->id == 15) : ?>
                                <a type="button" id="veg" class="<?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'Veg') ? "active_veg" : "non-active_veg" ?>" href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'Veg'); ?>">Veg
                                </a>
                                <a type="button" id="non_veg" class="<?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'non_Veg') ? "active_non-veg" : "non-active_non-veg" ?>" href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'non_Veg'); ?>">Non Veg
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>


                <button class="btn btn-filter-products-mobile" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                    <i class="icon-filter"></i>&nbsp;<?php echo trans("filter_products"); ?>
                </button>

            </div>
        </div>

        <div class="row">
            <?php $array_option_names = array(); ?>
            <div class="col-12 col-md-3 col-sidebar-products">
                <div>
                    <!-- <div style="float:left;">
                        <img src="<?php echo base_url(); ?>assets/img/landing-page-img/filter.png" style="height: 30px;width: 30px;" />
                    </div> -->
                    <div id="product_filter">
                        <h6 class="title">Filter By </h6>
                    </div>
                </div>
                <div id="collapseFilters" class="product-filters">
                    <?php
                    $categories = $this->parent_categories;
                    if (!empty($category)) :
                        $categories = get_subcategories($category->id);
                        if (empty($categories)) {
                            $categories = get_subcategories($category->parent_id);
                        }
                    endif;
                    ?>
                    <br>
                    <div>

                        <input type="checkbox" class="check-box-size" id="product_type" value="product_type" name="filter_checkbox[]" onclick="show_product_stock(this)">
                        <label for="product_type" style="margin: 10px;"><b><?php echo trans("product_stock_option"); ?></b></label>
                    </div>
                    <div class="filter-item" id="product_stock_option" style="display: none">

                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'product_type', 'Made_to_order'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'product_type', 'Made_to_order') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">Made to order</label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'product_type', 'Made_to_stock'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input " <?= is_custom_field_option_selected($query_string_object_array, 'product_type', 'Made_to_stock') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">Ready Stock / Inventory</label>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php if (false) : ?>
                        <?php if (!empty($parent_categories)) : ?>
                            <?php if ($parent_categories[0]->id != 15) : ?>

                                <div>

                                    <input type="checkbox" class="check-box-size" id="origin_of_product" value="origin_of_product" name="filter_checkbox[]" onclick="show_origin_of_product(this)">
                                    <label for="origin_of_product" style="margin: 10px;"><b>State of Origin</b></label>
                                </div>
                                <div class="filter-item" id="origin_of_product_filter" style="display: none">

                                    <div class="filter-list-container">
                                        <ul class="filter-list filter-custom-scrollbar">
                                            <?php foreach ($unique_state_array as $state) : ?>
                                                <li>
                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'origin_of_product', $state); ?>">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'origin_of_product', $state) ? 'checked' : ''; ?>>
                                                            <label class="custom-control-label"><?php echo ucfirst($state); ?></label>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div>

                                <input type="checkbox" class="check-box-size" id="origin_of_product" value="origin_of_product" name="filter_checkbox[]" onclick="show_origin_of_product(this)">
                                <label for="origin_of_product" style="margin: 10px;"><b>State of Origin</b></label>
                            </div>
                            <div class="filter-item" id="origin_of_product_filter" style="display: none">

                                <div class="filter-list-container">
                                    <ul class="filter-list filter-custom-scrollbar">
                                        <?php foreach ($unique_state_array as $state) : ?>
                                            <li>
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, 'origin_of_product', $state); ?>">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'origin_of_product', $state) ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label"><?php echo ucfirst($state); ?></label>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div>

                        <input type="checkbox" class="check-box-size" id="category" value="category" name="filter_checkbox[]" onclick="show_category(this)">
                        <label for="category" style="margin: 10px;"><b>Category</b></label>
                    </div>
                    <?php if (!empty($categories)) : ?>
                        <div class="filter-item" id="category_filter" style="display: none">

                            <?php if (!empty($category)) :
                                $url = generate_url("products");
                                if ($category->parent_id != 0) :
                                    $url = generate_category_url($parent_category);
                                endif; ?>
                                <a href="<?= $url . generate_filter_url($query_string_array, '', ''); ?>" class="filter-list-categories-parent">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                                    </svg>
                                    <span><?= !empty($parent_category) ? category_name($parent_category) : trans("categories_all"); ?></span>
                                </a>
                            <?php endif; ?>
                            <div class="filter-list-container">
                                <ul class="filter-list filter-custom-scrollbar<?= !empty($category) ? ' filter-list-subcategories' : ' filter-list-categories'; ?>">
                                    <?php if (!empty($category->has_subcategory)) : ?>
                                        <li>
                                            <a href="<?= generate_category_url($category) . generate_filter_url($query_string_array, '', ''); ?>" <?= !empty($category) && $category ?>><span class="font-600"><?= category_name($category); ?></span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php foreach ($categories as $item) :
                                        if ($item->actionable_status) :
                                    ?>
                                            <li<?= !empty($category->has_subcategory) ? ' class="li-sub"' : ''; ?>>
                                                <a href="<?= generate_category_url($item) . generate_filter_url($query_string_array, '', ''); ?>" <?= !empty($category) && $category->id == $item->id ? 'class="active"' : ''; ?>><?= category_name($item); ?></a>
                                                </li>
                                        <?php
                                        endif;
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($parent_categories)) :
                        $all_cat_filter = get_catg_filter(); ?>
                        <?php foreach ($all_cat_filter as $single_filter) : ?>
                            <?php if ($parent_categories[count($parent_categories) - 1]->id == $single_filter->category_id) :

                                $filter_ids = get_filter_id_by_cat_id($single_filter->category_id);
                                // var_dump($filter_ids);
                                // die();
                                foreach ($filter_ids as $filter_id) :
                                    $filter = get_filters_by_id($filter_id->filter_id);
                                    // var_dump($filter);
                                    // die(); 
                            ?>
                                    <?php if ($filter->filter_group == 1) : ?>
                                        <div>

                                            <input type="checkbox" class="check-box-size" id="dynamic1" value="dynamic1" name="filter_checkbox[]" onclick="show_dynamic1(this)">
                                            <label for="dynamic1" style="margin: 10px;"><b><?php echo ucfirst(str_replace('_', ' ', $filter->name)); ?></b></label>
                                        </div>
                                        <div class="filter-item" id="dynamic_filter1" style="display: none">
                                            <h4 class="title"></h4>
                                            <div class="filter-list-container">
                                                <ul class="filter-list filter-custom-scrollbar">
                                                    <?php $values = get_filtervalues_by_filterid_filtergroupid($filter->id, $single_filter->filter_group_id);
                                                    ?>
                                                    <?php foreach ($values as $value) :
                                                        @$array_option_names[$filter->name . "_" . $value->option_name] = $value->option_name; ?>
                                                        <li>
                                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->name,  $value->option_name); ?>">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, $filter->name,  $value->option_name) ? 'checked' : ''; ?>>
                                                                    <label class="custom-control-label"><?php echo $value->option_name; ?></label>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>

                                                </ul>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div>

                                            <input type="checkbox" class="check-box-size" id="dynamic2" value="dynamic2" name="filter_checkbox[]" onclick="show_dynamic2(this)">
                                            <label for="dynamic2" style="margin: 10px;"><b><?php echo ucfirst(str_replace('_', ' ', $filter->name)); ?></b></label>
                                        </div>
                                        <div class="filter-item" id="dynamic_filter2" style="display: none">

                                            <div class="filter-list-container">
                                                <ul class="filter-list filter-custom-scrollbar">
                                                    <?php $values = get_filtervalues_by_filterid($filter->id);
                                                    ?>
                                                    <?php foreach ($values as $value) :
                                                        @$array_option_names[$filter->name . "_" . $value->option_name] = $value->option_name; ?>

                                                        <li>
                                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->name,  $value->option_name); ?>">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, $filter->name,  $value->option_name) ? 'checked' : ''; ?>>
                                                                    <label class="custom-control-label"><?php echo $value->option_name; ?></label>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>

                                                </ul>
                                            </div>
                                        </div>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div>
                        <input type="checkbox" class="check-box-size" id="availability" value="availability" name="filter_checkbox[]" onclick="show_availability(this)">
                        <label for="availability" style="margin: 10px;"><b>Availability</b></label>
                    </div>
                    <div class="filter-item" id="availability_filter" style="display: none">

                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'available', 'in_stock'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'available', 'in_stock') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">In Stock</label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'cash_on_delivery', 'Y'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'cash_on_delivery', 'Y') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">Cash on Delivery</label>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>

                    <div>
                        <input type="checkbox" class="check-box-size" id="price" value="price" name="filter_checkbox[]" onclick="show_price(this)">
                        <label for="price" style="margin: 10px;"><b>Price</b></label>
                    </div>
                    <?php if ($this->form_settings->price == 1) :
                        $filter_p_min = clean_number($this->input->get('p_min', true));
                        $filter_p_max = clean_number($this->input->get('p_max', true)); ?>
                        <div class="filter-item" id="price_filter" style="display: none">

                            <div class="price-filter-inputs">
                                <div class="row align-items-baseline row-price-inputs">
                                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                                        <span><?php echo trans("min"); ?></span>
                                        <input type="input" id="price_min" value="<?= !empty($filter_p_min) ? $filter_p_min : ''; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("min"); ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                                        <span><?php echo trans("max"); ?></span>
                                        <input type="input" id="price_max" value="<?= !empty($filter_p_max) ? $filter_p_max : ''; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("max"); ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-2 col-price-inputs text-left">
                                        <button type="button" id="btn_filter_price" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_price_filter_url($query_string_object_array); ?>" class="btn btn-sm btn-default btn-filter-price float-left"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <input type="checkbox" class="check-box-size" id="discounts" value="discounts" name="filter_checkbox[]" onclick="show_discount(this)">
                        <label for="discounts" style="margin: 10px;"><b>Discounts</b></label>
                    </div>
                    <div class="filter-item" id="discount_filter" style="display: none">

                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'discount', 'More_than_50'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'discount', 'More_than_50') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                More than 50%
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'discount', '25-50'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'discount', '25-50') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                25-50%
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'discount', '0-25'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'discount', '0-25') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                0-25%
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'discount', '0'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'discount', '0') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                No Discount
                                            </label>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" class="check-box-size" id="rating" value="rating" name="filter_checkbox[]" onclick="show_rating(this)">
                        <label for="rating" style="margin: 10px;"><b>Rating</b></label>
                    </div>

                    <div class="filter-item" id="rating_filter" style="display: none">

                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'rating', '5'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'rating', '5') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>&nbsp;5
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'rating', '4'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'rating', '4') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>&nbsp;4
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'rating', '3'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'rating', '3') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>&nbsp;3
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'rating', '2'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'rating', '2') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i></div>&nbsp;2
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'rating', '1'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'rating', '1') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                <div class="rating"><i class="fa fa-star"></i></div>&nbsp;1
                                            </label>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <input type="checkbox" class="check-box-size" id="seller_type" value="seller_type" name="filter_checkbox[]" onclick="show_seller_type(this)">
                        <label for="seller_type" style="margin: 10px;"><b>Seller Type</b></label>
                    </div>
                    <div class="filter-item" id="seller_type_filter" style="display: none">

                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Out of regular job'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Out of regular job') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Out of regular job
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Pursuing Passion'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Pursuing Passion') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Pursuing Passion
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Sole Bread Earner'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Sole Bread Earner') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Sole Bread Earner
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Cooperative Groups'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Cooperative Groups') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Cooperative Groups
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'First Venture'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'First Venture') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                First Venture
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Gritty over Sixty'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Gritty over Sixty') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Gritty over Sixty
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'seller_type', 'Phoenix (Rising from the ashes)'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'seller_type', 'Phoenix (Rising from the ashes)') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Phoenix (Rising from the ashes)
                                            </label>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <?php $array_field_names = array();
                    if (!empty($custom_filters)) :
                        foreach ($custom_filters as $custom_filter) :
                            $filter_name = get_custom_field_name($custom_filter->name_array, $this->selected_lang->id);
                            @$array_field_names[$custom_filter->product_filter_key] = $filter_name; ?> <div class="filter-item">
                                <h4 class="title"><?= $filter_name; ?></h4>
                                <div class="filter-list-container">
                                    <input type="text" class="form-control filter-search-input" placeholder="<?= trans("search") . " " . $filter_name; ?>" data-filter-id="product_filter_<?= $custom_filter->id; ?>">
                                    <ul id="product_filter_<?= $custom_filter->id; ?>" class="filter-list filter-custom-scrollbar">
                                        <?php $options = get_custom_field_options($custom_filter, $this->selected_lang->id);
                                        if (!empty($options)) :
                                            foreach ($options as $option) :
                                                $option_name = get_custom_field_option_name($option);
                                                @$array_option_names[$custom_filter->product_filter_key . "_" . $option->option_key] = $option_name; ?>
                                                <li>
                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, $custom_filter->product_filter_key, $option->option_key); ?>">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, $custom_filter->product_filter_key, $option->option_key) ? 'checked' : ''; ?>>
                                                            <label class="custom-control-label"><?= $option_name; ?></label>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php endforeach;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                    <!-- <<<<<<< Updated upstream=======>>>>>>> Stashed changes -->




                    <!-- <<<<<<< Updated upstream=======>>>>>>> Stashed changes -->
                    <!-- <div class="filter-item">
                        <h4 class="title">Size</h4>
                        <div class="filter-list-container">
                            <ul class="filter-list">
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'basic_size', 'Small'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'basic_size', 'Small') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Small
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'basic_size', 'Medium'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'basic_size', 'Medium') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Medium
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'basic_size', 'Large'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'basic_size', 'Large') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Large
                                            </label>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= current_url() . generate_filter_url($query_string_array, 'basic_size', 'Others'); ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'basic_size', 'Others') ? 'checked' : ''; ?>>
                                            <label class="custom-control-label">
                                                Others
                                            </label>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div> -->





                    <?php if (!empty($parent_categories)) : ?>


                        <?php if ($parent_categories[0]->id == 12) : ?>
                            <div>

                                <input type="checkbox" class="check-box-size" id="gender" value="gender" name="filter_checkbox[]" onclick="show_gender(this)">
                                <label for="gender" style="margin: 10px;"><b>Gender</b></label>
                            </div>
                            <div class="filter-item" id="gender_filter" style="display: none">

                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'gender', 'Men'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'gender', 'Men') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Men</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'gender', 'Women'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'gender', 'Women') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Women</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'gender', 'Kids_Boys'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'gender', 'Kids_Boys') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Kids(Boys)</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'gender', 'Kids_Girls'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'gender', 'Kids_Girls') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Kids(Girls)</label>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        <?php endif; ?>
                        <?php if (!empty($parent_categories[4])) : ?>
                            <?php if ($parent_categories[0]->id == 12 || $parent_categories[4]->id == 1389) : ?>
                                <div>

                                    <input type="checkbox" id="blouse_detail" value="blouse_detail" name="filter_checkbox[]" onclick="show_blouse_detail(this)">
                                    <label for="blouse_detail" style="margin: 10px;"><b>Blouse Details</b></label>
                                </div>
                                <div class="filter-item" id="blouse_detail_filter" style="display: none">

                                    <div class="filter-list-container">
                                        <ul class="filter-list">
                                            <li>
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, 'blouse_details', 'With_Blouse_Piece'); ?>">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'blouse_details', 'With_Blouse_Piece') ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label">With Blouse Piece</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, 'blouse_details', 'Without_Blouse_Piece'); ?>">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'blouse_details', 'Without_Blouse_Piece') ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label">Without Blouse Piece</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, 'blouse_details', 'With_Stitched_Blouse'); ?>">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'blouse_details', 'With_Stitched_Blouse') ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label">With Stitched Blouse</label>
                                                    </div>
                                                </a>
                                            </li>


                                        </ul>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endif; ?>


                        <?php if ($parent_categories[0]->id == 309) : ?>
                            <div>

                                <input type="checkbox" id="pet_age" value="pet_age" name="filter_checkbox[]" onclick="show_pet_age(this)">
                                <label for="pet_age" style="margin: 10px;"><b>Pet Age</b></label>
                            </div>
                            <div class="filter-item" id="pet_age_filter" style="display: none">

                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Young_Adult'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Young_Adult') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Young Adult</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'All_Life_Stages'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'All_Life_Stages') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">All Life Stages</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Senior'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Senior') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Senior</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Adolescent'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Adolescent') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Adolescent</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Adult'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Adult') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Adult</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Baby'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Baby') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Baby</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Puppy'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Puppy') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Puppy</label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'pet_age', 'Kitten'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'pet_age', 'Kitten') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">Kitten</label>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($parent_categories[0]->id == 3) : ?>
                            <div>

                                <input type="checkbox" id="jewellery_type" value="jewellery_type" name="filter_checkbox[]" onclick="show_jeweller_type(this)">
                                <label for="jewellery_type" style="margin: 10px;"><b>Jewellery Type</b></label>
                            </div>
                            <div class="filter-item" id="jewellery_type_filter" style="display: none">

                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'jewellery_type', 'Gold'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'jewellery_type', 'Gold') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Gold
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'jewellery_type', 'silver'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'jewellery_type', 'silver') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Silver
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'jewellery_type', 'Precious_Stones'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'jewellery_type', 'Precious_Stones') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Precious Stones
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'jewellery_type', 'Semi_Precious'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'jewellery_type', 'Semi_Precious') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Semi Precious
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'jewellery_type', 'Artificial'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'jewellery_type', 'Artificial') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Artificial
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($parent_categories[0]->id == 15) : ?>
                            <div>

                                <input type="checkbox" id="type_meal" value="type_meal" name="filter_checkbox[]" onclick="show_food(this)">
                                <label for="type_meal" style="margin: 10px;"><b>Type of Meal</b></label>
                            </div>
                            <br>
                            <div class="filter-item" id="food_pref" style="display: none">
                                <h4 class="title">Food Preference</h4>
                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_preference', 'Gluten_Free'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_preference', 'Gluten Free') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Gluten Free
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_preference', 'Organic'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_preference', 'Organic') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Organic
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_preference', 'Sustainable'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_preference', 'Sustainable') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Sustainable
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_preference', 'Vegan'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_preference', 'Vegan') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Vegan
                                                    </label>
                                                </div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </div>

                            <div class="filter-item" id="food_type" style="display: none">
                                <h4 class="title">Food Type</h4>
                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'Veg'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'Veg') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Veg
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'non_Veg'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'non_Veg') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Non Veg
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'food_type', 'Jain'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'food_type', 'Jain') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Jain
                                                    </label>
                                                </div>
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                            <div class="filter-item" id="meal_type" style="display: none">
                                <h4 class="title">Meal Type</h4>
                                <div class="filter-list-container">
                                    <ul class="filter-list">
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'meal_type', 'Appetisers'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'meal_type', 'Appetisers') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Appetisers
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'meal_type', 'Main_Course'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'meal_type', 'Main_Course') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Main Course
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'meal_type', 'Beverages'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'meal_type', 'Beverages') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Beverages
                                                    </label>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, 'meal_type', 'Desserts'); ?>">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, 'meal_type', 'Desserts') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label">
                                                        Desserts
                                                    </label>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                </div>

                <div class="row-custom">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "products_sidebar", "class" => "m-b-15"]); ?>
                </div>
            </div>

            <div class="col-12 col-md-9 col-content-products">
                <div class="filter-reset-tag-container">
                    <?php $show_reset_link = false;
                    if (!empty($query_string_object_array)) :
                        foreach ($query_string_object_array as $filter) :

                            if ($filter->key != 'sort') :
                                $show_reset_link = true;

                                if ($filter->key == "p_min") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("price") . '(' . get_currency($this->payment_settings->default_currency) . ')'; ?></span>
                                            <span><?= trans("min") . ": " . html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "p_max") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("price") . '(' . get_currency($this->payment_settings->default_currency) . ')'; ?></span>
                                            <span><?= trans("max") . ": " . html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "product_type") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?php echo trans("product_stock_option"); ?></span>
                                            <span><?= str_replace('_', ' ', html_escape($filter->value)); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "gender") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Gender</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "origin_of_product") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">State of Origin</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "available") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Availability</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "cash_on_delivery") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Cash on Delivery</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "food_type") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Food Type</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "discount") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Discounts</span>
                                            <span><?= str_replace('_', ' ', html_escape($filter->value)); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "blouse_details") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Blouse Details</span>
                                            <span><?= str_replace('_', ' ', html_escape($filter->value)); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "search") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("search"); ?></span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "food_preference") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Food Preference</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>


                                <?php elseif ($filter->key == "seller_type") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Seller Type</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "meal_type") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Meal Type</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "pet_age") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Pet Age</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>



                                <?php elseif ($filter->key == "jewellery_type") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Jewellery Type</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "rating") : ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title">Rating</span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>

                                    <?php else :

                                    if (!empty($array_option_names[$filter->key . "_" . $filter->value])) : ?>
                                        <div class="filter-reset-tag">
                                            <div class="left">
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>"><i class="icon-close"></i></a>
                                                <?php //var_dump($array_option_names);
                                                ?>
                                            </div>
                                            <div class="right">
                                                <span class="reset-tag-title"><?= isset($array_field_names[$filter->key]) ? $array_field_names[$filter->key] : ucfirst($filter->key); ?></span>
                                                <span><?= $array_option_names[$filter->key . "_" . $filter->value]; ?></span>
                                            </div>
                                        </div>
                    <?php endif;
                                endif;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($show_reset_link) : ?>
                        <a href="<?= current_url(); ?>" class="link-reset-filters"><?= trans("reset_filters"); ?></a>
                    <?php endif; ?>
                </div>

                <div class="product-list-content">
                    <div class="row row-product">
                        <h6><b><?php echo ($product_count); ?></b>&nbsp;products found
                            <!-- <?php if (!empty($parent_categories)) :
                                        foreach ($parent_categories as $item) :
                                            if ($item->id == $category->id) : ?>
                                        <?php echo category_name($item); ?>
                                    <?php else : ?>
                                        <a href="<?php echo generate_category_url($item); ?>"><?php echo category_name($item); ?></a>
                                    <?php endif; ?>
                                <?php endforeach;
                                    else : ?>
                                <?= trans("products"); ?>
                            <?php endif; ?><h6> -->
                    </div>
                    <div class="row row-product" style="margin-top:20px">

                        <!--print products-->


                        <?php foreach ($products as $product) : ?>
                            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($products)) : ?>
                            <div class="col-12">
                                <p class="no-records-found"><?php echo trans("no_products_found"); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-list-pagination">
                    <div class="float-left">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>

                <div class="col-12">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "products", "class" => "m-t-15"]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<script type="text/javascript">
    $(document).ready(function() {
        if ($('#product_type').is(":checked")) {
            document.getElementById("product_stock_option").style.display = "block";
        } else if ($('#product_type').is(":not(:checked)")) {
            document.getElementById("product_stock_option").style.display = "none";
        }

        if ($('#category').is(":checked")) {
            document.getElementById("category_filter").style.display = "block";
        } else if ($('#category').is(":not(:checked)")) {
            document.getElementById("category_filter").style.display = "none";
        }
        if ($('#price').is(":checked")) {
            document.getElementById("price_filter").style.display = "block";
        } else if ($('#price').is(":not(:checked)")) {
            document.getElementById("price_filter").style.display = "none";
        }
        if ($('#availability').is(":checked")) {
            document.getElementById("availability_filter").style.display = "block";
        } else if ($('#availability').is(":not(:checked)")) {
            document.getElementById("availability_filter").style.display = "none";
        }
        if ($('#discounts').is(":checked")) {
            document.getElementById("discount_filter").style.display = "block";
        } else if ($('#discounts').is(":not(:checked)")) {
            document.getElementById("discount_filter").style.display = "none";
        }
        if ($('#rating').is(":checked")) {
            document.getElementById("rating_filter").style.display = "block";
        } else if ($('#rating').is(":not(:checked)")) {
            document.getElementById("rating_filter").style.display = "none";
        }

        if ($('#seller_type').is(":checked")) {
            document.getElementById("seller_type_filter").style.display = "block";
        } else if ($('#seller_type').is(":not(:checked)")) {
            document.getElementById("seller_type_filter").style.display = "none";
        }
        if ($('#blouse_detail').is(":checked")) {
            document.getElementById("blouse_detail_filter").style.display = "block";
        } else if ($('#blouse_detail').is(":not(:checked)")) {
            document.getElementById("blouse_detail_filter").style.display = "none";
        }
        if ($('#pet_age').is(":checked")) {
            document.getElementById("pet_age_filter").style.display = "block";
        } else if ($('#pet_age').is(":not(:checked)")) {
            document.getElementById("pet_age_filter").style.display = "none";
        }

        if ($('#jeweller_type').is(":checked")) {
            document.getElementById("jeweller_type_filter").style.display = "block";
        } else if ($('#jeweller_type').is(":not(:checked)")) {
            document.getElementById("jeweller_type_filter").style.display = "none";
        }
        if ($('#origin_of_product').is(":checked")) {
            document.getElementById("origin_of_product_filter").style.display = "block";
        } else if ($('#origin_of_product').is(":not(:checked)")) {
            document.getElementById("origin_of_product_filter").style.display = "none";
        }

        if ($('#gender').is(":checked")) {
            document.getElementById("gender_filter").style.display = "block";
        } else if ($('#gender').is(":not(:checked)")) {
            document.getElementById("gender_filter").style.display = "none";
        }
        if ($('#food').is(":checked")) {
            document.getElementById("food_pref").style.display = "block";
            document.getElementById("food_type").style.display = "block";
            document.getElementById("meal_type").style.display = "block";
        } else if ($('#food').is(":not(:checked)")) {
            document.getElementById("food_pref").style.display = "none";
            document.getElementById("food_type").style.display = "block";
            document.getElementById("meal_type").style.display = "block";
        }
        if ($('#dynamic1').is(":checked")) {
            document.getElementById("dynamic_filter1").style.display = "block";
        } else if ($('#dynamic1').is(":not(:checked)")) {
            document.getElementById("dynamic_filter1").style.display = "none";
        }
        if ($('#dynamic2').is(":checked")) {
            document.getElementById("dynamic_filter2").style.display = "block";
        } else if ($('#dynamic2').is(":not(:checked)")) {
            document.getElementById("dynamic_filter2").style.display = "none";
        }
    });

    function show_product_stock(check) {
        var dvPassport = document.getElementById("product_stock_option");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_category(check) {
        var dvPassport = document.getElementById("category_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_price(check) {
        var dvPassport = document.getElementById("price_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_availability(check) {
        var dvPassport = document.getElementById("availability_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_discount(check) {
        var dvPassport = document.getElementById("discount_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_rating(check) {
        var dvPassport = document.getElementById("rating_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_seller_type(check) {
        var dvPassport = document.getElementById("seller_type_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_blouse_detail(check) {
        var dvPassport = document.getElementById("blouse_detail_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_pet_age(check) {
        var dvPassport = document.getElementById("pet_age_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_jeweller_type(check) {
        var dvPassport = document.getElementById("jeweller_type_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_gender(check) {
        var dvPassport = document.getElementById("gender_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_origin_of_product(check) {
        var dvPassport = document.getElementById("origin_of_product_filter");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_food(check) {
        var dvPassport = document.getElementById("food_pref");
        dvPassport.style.display = check.checked ? "block" : "none";
        document.getElementById("food_type").style.display = check.checked ? "block" : "none";
        document.getElementById("meal_type").style.display = check.checked ? "block" : "none";
    }

    function show_dynamic1(check) {
        var dvPassport = document.getElementById("dynamic_filter1");
        dvPassport.style.display = check.checked ? "block" : "none";
    }

    function show_dynamic2(check) {
        var dvPassport = document.getElementById("dynamic_filter2");
        dvPassport.style.display = check.checked ? "block" : "none";
    }
</script>
<script type="text/javascript">
    //localstorage to keep checkboxes check after refresh
    (function() {
        var boxes = document.querySelectorAll("input[name='filter_checkbox[]']");
        for (var i = 0; i < boxes.length; i++) {
            var box = boxes[i];
            if (box.hasAttribute("value")) {
                setupBox(box);
            }
        }

        function setupBox(box) {
            var storageId = box.getAttribute("value");
            var oldVal = localStorage.getItem(storageId);
            box.checked = oldVal === "true" ? true : false;

            box.addEventListener("change", function() {
                localStorage.setItem(storageId, this.checked);
            });
        }
    })();
</script>
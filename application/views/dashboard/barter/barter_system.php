
<div class="barter-class-new">
<div class="top-search-bar<?= $this->general_settings->multi_vendor_system != 1 ? ' top-search-bar-single-vendor' : ''; ?>">
    <?php echo form_open(generate_url('search_member'), ['id' => 'form_validate_search', 'class' => 'form_search_main', 'method' => 'get']); ?>
    <?php if ($this->general_settings->multi_vendor_system == 1) : ?>
        <!-- <div class="left">
            <div class="dropdown search-select">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                    <?php if (isset($search_type)) : ?>
                        <?php echo trans("supplier"); ?>
                    <?php else : ?>
                        <?php echo trans("product"); ?>
                    <?php endif; ?>
                </button>
                <div class="dropdown-menu">
                <a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("supplier"); ?></a>
                    <a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
                 
                </div>
            </div>
            <?php if (isset($search_type)) : ?>
                <input type="hidden" class="search_type_input" name="search_type" value="member">
            <?php else : ?>
                <input type="hidden" class="search_type_input" name="search_type" value="product">
            <?php endif; ?>
        </div> -->
        <div class="right">
            <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="Search For Members Who are Ready for Barter System" required autocomplete="off">
            <!-- <button class="btn btn-default btn-search"><i class="icon-search"></i></button> -->
            <div id="response_search_results" class="search-results-ajax"></div>
        </div>
    <?php else : ?>
        <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required autocomplete="off">
        <input type="hidden" class="search_type_input" name="search_type" value="product">
        <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
        <div id="response_search_results" class="search-results-ajax"></div>
    <?php endif; ?>
    <?php echo form_close(); ?>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Wrapper -->
<?php

$members=get_barter_members();
?>
<div id="wrapper">
		<div class="row">
			<div class="col-12">

				<!-- <nav class="nav-breadcrumb" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo trans("members"); ?></li>
					</ol>
				</nav> -->

				<h1 class="page-title page-title-product"></h1>

				<div class="row">
					<?php if (!empty($members)): ?>
						<?php foreach ($members as $member): ?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="member-list-item">
									<div class="left" style="text-align:center;">
										<a href="<?php echo generate_barter_product_url($member->slug); ?>">
											<img src="<?php echo get_user_avatar($member); ?>" height="100" width="100" alt="<?php echo get_shop_name($member); ?>" class="img-fluid img-profile lazyload barter-image" >
										</a>
									</div>
									<div class="right" style="text-align:center; margin-bottom:23px;">
										<a href="<?php echo generate_barter_product_url($member->slug); ?>" style="color:black;">
											<p class="username"><b><?php echo get_shop_name($member); ?></b></p>
										</a>
										<p><?php echo trans("products") . " (" . get_user_barter_products_count($member->id). ") " ; ?></p>

										<?php if ($this->auth_check): ?>
											<?php if ($member->id != $this->auth_user->id): ?>
												<?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
												<input type="hidden" name="following_id" value="<?php echo $member->id; ?>">
												<input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
												<?php if (is_user_follows($member->id, $this->auth_user->id)): ?>
													<p>
														<button class="btn follow-button"><i class="icon-user-minus"></i><b><?php echo "  ".trans("unfollow"); ?></b></button>
													</p>
												<?php else: ?>
													<p>
														<button class="btn follow-button"><i class="icon-user-plus"></i><b> <?php echo "  ".trans("follow"); ?></b></button>
													</p>
												<?php endif; ?>
												<?php echo form_close(); ?>
											<?php endif; ?>
										<?php else: ?>
											<p>
												<button class="btn btn-md btn-outline" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
											</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="col-12">
							<p class="no-records-found">
								<?php echo trans("no_members_found"); ?>
							</p>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
</div>
</div>
<!-- Wrapper End-->




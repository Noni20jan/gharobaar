<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav class="nav-breadcrumb" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo trans("following"); ?></li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-3">
				<!-- load profile nav -->
				<?php $this->load->view("profile/_profile_tabs"); ?>
			</div>

			<div class="col-sm-12 col-md-9">
				<div class="profile-tab-content">
					<div class="user-profile-follower">
						<img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>" class="img-fluid img-profile lazyload user-profile-img">
						<p class="username">
							<?php echo get_shop_name($this->auth_user); ?>
						</p>
						<p class="followers">
							<?php echo "(Following " . get_following_users_count($user->id) . ")"; ?>
						</p>
					</div>
					<div class="row">
						<?php foreach ($following_users as $item) : ?>
							<div class="col-4 col-sm-2">
								<div class="follower-item">
									<a href="<?php echo generate_profile_url($item->slug); ?>">
										<img src="<?php echo get_user_avatar($item); ?>" alt="<?php echo get_shop_name($item); ?>" class="img-fluid img-profile lazyload">
										<p class="username">
											<?php echo get_shop_name($item); ?>
										</p>
									</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="row-custom">
						<!--Include banner-->
						<?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
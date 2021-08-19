<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $title; ?></h3>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="row">
			<!-- include message block -->
			<!-- <div class="col-sm-12">
				<?//php $this->load->view('admin/includes/_messages'); ?>
			</div> -->
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<?php $this->load->view('admin/order/_filter_refunds'); ?>
					<!-- <table class="table table-bordered table-striped" role="grid"> -->
					<table id="refunds_table" class="display" style="width:100%">

						<thead>
							<tr role="row">
								<th><?php echo 'Sr. No.' ?></th>
								<th><?php echo trans('refundId'); ?></th>
								<th><?php echo trans('order_id'); ?></th>
								<th><?php echo 'Arn' ?></th>
								<th><?php echo trans('referenceId'); ?></th>
								<th><?php echo trans('txAmount'); ?></th>
								<th><?php echo trans('refundAmount'); ?></th>
								<th><?php echo trans('note'); ?></th>
								<th><?php echo trans('processed'); ?></th>
								<th><?php echo trans('initiatedOn'); ?></th>
								<th><?php echo trans('processedOn'); ?></th>

							</tr>
						</thead>
						<tbody id="refunds_data">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>
<script>
	$(document).ready(function() {
		$('#refunds_table').DataTable({
			paging: false,
			searching: false
		});
	});
</script>
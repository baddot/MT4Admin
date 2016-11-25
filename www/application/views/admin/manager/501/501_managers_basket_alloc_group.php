<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<div class="modal fade" id="myAllocModalHorizontal" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['managers_basket_dlg_alloc_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-5">
						<div class="panel panel-default" style="padding-left: 10px;text-align: center;"">
							<div class="panel-heading"><?php echo $arr_ui_string['managers_basket_group_list']?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable" style="max-height: 500px;">
									<table class="table table-bordered table-scrollable"  id="tb_group">
										<tbody id="list">
	                             	  <?php
										$cnt = count ( $list_group );
									
										foreach ( $list_group as $row ) {
											echo '<tr>';
											echo '<td>' . $row ['GROUP_NAME'] . '</td>';
											echo '</tr>';
										}
										?>
	                      		      </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-2"  style="text-align: center;">
						<button type="button" class="btn btn-default" id="btn_right">>></button>
						<button type="button" class="btn btn-default" style="margin-top: 10px;"  id="btn_left"><<</button>
					</div>

					<div class="col-sm-5" style="padding-right: 10px;">
						<div class="panel panel-default" style="text-align: center;">
							<div class="panel-heading"><?php echo $arr_ui_string['managers_basket_group_basket_list']?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable">
									<table class="table table-bordered table-scrollable"  id="tb_basket">
										<tbody>
				                           
				                        </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $arr_ui_string['btn_title_cancel']?>
                </button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--

//-->

function onClickModify() {
		
}

</script>

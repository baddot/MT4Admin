<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css"
	rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<div class="modal fade" id="myAllocModalHorizontal" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-admin">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['configuration_designate_omni_dlg_create_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="panel panel-default" style="padding-left: 10px;text-align: center;">
							<div class="panel-heading"><?php echo $arr_ui_string['configuration_designate_omni_dlg_create_fields'][0]?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable" style="max-height: 500px;">
									<table class="table table-bordered table-scrollable"  id="tb_account">
										<tbody id="list">
	                             	  <?php
										$cnt = count ( $list_account );
									
										foreach ( $list_account as $row ) {
											echo '<tr style="text-align: left;">';
											echo '<td value="'.$row ['NAME'].'">' . $row ['LOGIN'] . '</td>';
											echo '</tr>';
										}
										?>
	                      		      </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4" style="padding-right: 10px;">
						<div class="panel panel-default" style="text-align: center;">
							<div class="panel-heading"><?php echo $arr_ui_string['configuration_designate_omni_dlg_create_fields'][1]?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable">
									<table class="table table-bordered table-scrollable"  id="tb_group">
										<tbody>
				                           <?php
										$cnt = count ( $list_group );
									
										foreach ( $list_group as $row ) {
											echo '<tr  style="text-align: left;">';
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
					
					<div class="col-sm-4" style="padding-right: 10px;">
						<div class="panel panel-default" style="text-align: center;">
							<div class="panel-heading"><?php echo $arr_ui_string['configuration_designate_omni_dlg_create_fields'][2]?></div>
							<div class="panel-body">
								<div class="bodyfullcontainer scrollable">
									<table class="table table-bordered table-scrollable"  id="tb_result">
										<tbody>
										<?php
										$cnt = count ( $data );
									
										foreach ( $data as $row ) {
											echo '<tr>';
											echo '<td value="'. $row ['ACCOUNT_NAME'].'">' . $row ['ACCOUNT'] .'/'. $row ['GROUP_NAME']. '</td>';
											echo '</tr>';
										}
										?>
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
                <button type="button" class="btn btn-primary" name="btn_save" id="btn_save" onclick="onClickSave()">
                            <?php echo $arr_ui_string['btn_title_save']?>
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

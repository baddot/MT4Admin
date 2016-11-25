<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>

<div class="modal fade" id="myUpdateModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['configuration_lp_account_dlg_update_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['configuration_lp_account_fields'][1]?></label>
						<div class="col-sm-7">
							<select class="selectpicker" id="cb_update_lp_id"
								data-width="auto">
		            		<?php
																$arr = $list_lp;
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company['LP_ID'].'">' . $company['LP_NAME'] . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['configuration_lp_account_fields'][2]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['configuration_lp_account_fields'][2]?>" class="form-control"  id="tv_update_lp_name">
						</div>
					</div>
		
					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['configuration_lp_account_fields'][3]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['lp_info_fields'][4]?>" class="form-control"  id="tv_update_comments">
						</div>
					</div>
				</form>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $arr_ui_string['btn_title_cancel']?>
                </button>
				<button type="button" class="btn btn-primary" id="btn_modify" name="btn_modify">
                    <?php echo $arr_ui_string['btn_title_update']?>
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

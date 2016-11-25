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
                    <?php echo $arr_ui_string['wl_dlg_change_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][0]?></label>
						<div class="col-sm-7 content-loader">
							<label class="col-sm-2 control-label" for="textinput" id="lb_company_name"><?php echo $arr_ui_string['wl_info_fields'][0]?></label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][1]?></label>
						<div class="col-sm-7">
							<select class="selectpicker" id="cb_status"
								data-width="auto">
		            		<?php
																$arr = Array('Y', 'N');
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company.'">' . $company . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][2]?></label>
						<div class="col-sm-7">
							<select class="selectpicker" id="cb_enable"
								data-width="auto">
		            		<?php
																$arr = Array('Y', 'N');
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company.'">' . $company . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][3]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['wl_info_fields'][3]?>" class="form-control"  id="tv_omnibus_id">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][4]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['wl_info_fields'][4]?>" class="form-control"  id="tv_change_address">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][5]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['wl_info_fields'][5]?>" class="form-control"  id="tv_change_phone">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][6]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['wl_info_fields'][6]?>" class="form-control"  id="tv_change_email">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['wl_info_fields'][9]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['wl_info_fields'][9]?>" class="form-control" id="tv_change_comments">
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
                    <?php echo $arr_ui_string['btn_title_modify']?>
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

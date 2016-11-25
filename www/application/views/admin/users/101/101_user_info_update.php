
<link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.js"></script>
<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['users_dlg_change_title']?>
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_account']?></label>
						<div class="col-sm-8 content-loader">
							<label class="col-sm-2 control-label" for="textinput" id="lb_account">KimChi</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_name']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_name']?>" class="form-control"
								id="tv_name">
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_leverage']?></label>
						<div class="col-sm-4">
							<select class="selectpicker" id="cb_leverage" data-width="auto">
		            		<?php
																$arr = Array (
																		0,
																		100,
																		200,
																		300,
																		400,
																		500,
																		1000 
																);
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$leverage = $arr [$i];
																	echo '<option>' . $leverage . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_group']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_group']?>" class="form-control" id="tv_group">
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_agentaccount']?></label>
						<div class="col-sm-4">
							<select class="selectpicker" id="cb_agentaccount"
								data-width="auto">
		            		<?php
																$arr = Array (
																		0,
																		100,
																		200,
																		300,
																		400,
																		500,
																		1000 
																);
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$leverage = $arr [$i];
																	echo '<option>' . $leverage . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_status']?></label>
						<div class="col-sm-4">
							<select class="selectpicker" id="cb_status" data-width="100%">
		            		<?php
																$arr = Array (
																		'NR',
																		'RE' 
																);
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$leverage = $arr [$i];
																	echo '<option>' . $leverage . '</option>';
																}
																?>
                          </select>
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_basket']?></label>
						<div class="col-sm-4">
							<select class="selectpicker" id="cb_basket" data-width="100%">
		            		<?php
																$arr = Array (
																		'NR',
																		'RE' 
																);
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$leverage = $arr [$i];
																	echo '<option>' . $leverage . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_country']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_country']?>" class="form-control"  id="tv_country">
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_city']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_city']?>" class="form-control" id="tv_city">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_state']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_state']?>" class="form-control" id="tv_state">
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_zipcode']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_zipcode']?>" class="form-control" id="tv_zipcode">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_phone']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_phone']?>" class="form-control" id="tv_phone">
						</div>

						<label class="col-sm-2 control-label" for="textinput"><?php echo $arr_ui_string['users_dlg_change_email']?></label>
						<div class="col-sm-4">
							<input type="text" placeholder="<?php echo $arr_ui_string['users_dlg_change_email']?>" class="form-control" id="tv_email">
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

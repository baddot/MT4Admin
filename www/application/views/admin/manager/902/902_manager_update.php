
<div class="modal fade" id="myUpdateModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['manager_dlg_change_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_managerid']?></label>
						<div class="col-sm-7 content-loader">
							<label class="col-sm-2 control-label" for="textinput" id="lb_change_account">KimChi</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_name']?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_name']?>" class="form-control"
								id="tv_change_name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_companyname']?></label>
						<div class="col-sm-7">
							<select class="selectpicker" id="cb_change_companyname"
								data-width="auto">
		            		<?php
																$arr = $list_company;
																for($i = 0; $i < count ( $arr ); $i ++) {
																	$company = $arr [$i];
																	echo '<option value="'.$company['COMPANY_NAME'].'">' . $company['COMPANY_NAME'] . '</option>';
																}
																?>
                          </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_password']?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_password']?>" class="form-control"  id="tv_change_passwd">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_comments']?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_comments']?>" class="form-control" id="tv_change_comments">
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

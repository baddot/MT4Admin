
<div class="modal fade" id="myCreateModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only"><?php echo $arr_ui_string['btn_title_cancel']?></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    <?php echo $arr_ui_string['manager_dlg_create_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_managerid']?></label>
						<div class="col-sm-7 content-loader">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_managerid']?>" class="form-control"  id="tv_create_account">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_name']?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_name']?>" class="form-control"
								id="tv_create_name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_companyname']?></label>
						<div class="col-sm-7">
							<select class="selectpicker" id="cb_create_companyname"
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
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_password']?>" class="form-control"  id="tv_create_passwd">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['manager_dlg_comments']?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['manager_dlg_comments']?>" class="form-control" id="tv_create_comments">
						</div>
					</div>

				</form>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $arr_ui_string['btn_title_cancel']?>
                </button>
				<button type="button" class="btn btn-primary" id="btn_create" name="btn_create">
                    <?php echo $arr_ui_string['btn_title_create']?>
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

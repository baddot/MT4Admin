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
                    <?php echo $arr_ui_string['managers_basket_dlg_change_title']?> 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['managers_basket_group_fields'][0]?></label>
						<div class="col-sm-8 content-loader">
							<label class="col-sm-2 control-label" for="textinput" id="lb_basket_code">KimChi</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['managers_basket_group_fields'][1]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['managers_basket_group_fields'][1]?>" class="form-control"  id="tv_change_name">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="textinput"><?php echo $arr_ui_string['managers_basket_group_fields'][2]?></label>
						<div class="col-sm-7">
							<input type="text" placeholder="<?php echo $arr_ui_string['managers_basket_group_fields'][2]?>" class="form-control"  id="tv_change_comment">
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
                <button type="button" class="btn btn-primary" id="btn_delete" name="btn_delete">
                    <?php echo $arr_ui_string['btn_title_delete']?>
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
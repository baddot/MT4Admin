<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $arr_ui_string["admin_title"]?></title>
<!-- BOOTSTRAP STYLES-->
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"
	rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="<?php echo base_url(); ?>assets/css/font-awesome.css"
	rel="stylesheet" />
<!-- MORRIS CHART STYLES-->

<!-- CUSTOM STYLES-->
<link href="<?php echo base_url(); ?>assets/css/custom.css"
	rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans'
	rel='stylesheet' type='text/css' />
<!-- TABLE STYLES-->

<!-- /. PAGE WRAPPER  -->
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-dialog.min.js"></script>
<link
	href="<?php echo base_url(); ?>assets/css/bootstrap-dialog.min.css"
	rel="stylesheet" />
</head>
<body>

	<div class="container">
		<div class="row text-center ">
			<div class="col-md-12">
				<br />
				<br />
				<h2> <?php echo $arr_ui_string["admin_title"]?></h2>

				<br />
			</div>
		</div>
		<div class="row ">

			<div
				class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>  <?php echo $arr_ui_string["login_title"]?>  </strong>
					</div>
					<div class="panel-body">
						<form role="form">
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                            <?php
												echo '<input type="text" id="tv_id" class="form-control"  onkeypress="handle(event)"  placeholder="Your ' . $arr_ui_string ["login_id"] . '" />';
																																?>
                                        </div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                             <?php
												echo '<input type="password"  id="tv_pwd" class="form-control"  onkeypress="handle(event)" placeholder="Your ' . $arr_ui_string ["login_passwd"] . '" />';
																																											?>
                                        </div>
							<div class="form-group">
								<label class="checkbox-inline" id="cb_passwd"> <input
									type="checkbox" /> Remember me
								</label> <span class="pull-right"> <a href="#">Forget password ?
								</a>
								</span>
							</div>
						</form>
						<button class="btn btn-primary" onclick="onClickLogin()">Login Now</button>
							<hr />
							Not register ? <a href="registeration.html">click here </a>
					</div>
				</div>
			</div>


		</div>
	</div>
	<script>

	 function handle(e){
	        if(e.keyCode === 13){
	        	onClickLogin();
	        }

	        return false;
	}

	function onClickLogin() {
			var id = $('#tv_id').val();
	        var pw = $('#tv_pwd').val();
	        var save_login = $('#cb_login').is(':checked');

	        if(id == null || id == "" || pw == null || pw == "") {
	        	showAlert("<?php echo $arr_ui_string['msg_input_idpwd'];?>");
	        	return;
	        }

	        if(save_login == false) {
	            save_login = 0;
	        }
	        else {
	            save_login = 1;
	        }

	        $.ajax({
	            url: '<?php echo base_url(); ?>'+"manager/POST_MANAGER_LOGIN",
	            type: "post", // To protect sensitive data
	            data: {
	                ajax:true,
	                i_id:id,
	                i_pwd:pw,
	                i_save_info:save_login
	            },
	            success:function(response){
	                var code = response['result_code'];
	                var data = response['result_data'];
	                if(code == <?php echo VALUE_OK;?>) {
	                    location.href = '<?php echo base_url(); ?>'+"statement/compare_order_view";
	                }
	                else {
	                	showAlert("<?php echo $arr_ui_string['msg_fail_login_idpwd'];?>");
	                }
	            },
	            error:function(jqXHR, msg, erro) {
	            	showAlert("<?php echo $arr_ui_string['msg_fail_network'];?>");
	            }
	        });	
	}

	</script>

</body>
</html>

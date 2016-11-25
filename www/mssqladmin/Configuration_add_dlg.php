<link href="assets/css/bootstrap-select.css" rel="stylesheet" />
<script src="assets/js/bootstrap-select.js"></script>

<div class="modal fade" id="myCreateModalHorizontal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span> <span class="sr-only">cancel</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                    Add Server 
                </h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-sm-4 control-label" for="textinput">ServerName</label>
						<div class="col-sm-7">
							<input type="text" placeholder="" class="form-control"  id="tv_create_server_name">
						</div>
					</div>
		
					<div class="form-group">
						<label class="col-sm-4 control-label" for="textinput">IP</label>
						<div class="col-sm-7">
							<input type="text" placeholder="" class="form-control"  id="tv_create_server_ip">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label" for="textinput">MYSQL PORT</label>
						<div class="col-sm-7">
							<input type="text" placeholder="" class="form-control"  id="tv_create_mysql_port">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="textinput">MYSQL UserName</label>
						<div class="col-sm-7">
							<input type="text" placeholder="" class="form-control"  id="tv_create_mysql_username">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label" for="textinput">MYSQL PWD</label>
						<div class="col-sm-7">
							<input type="text" placeholder="" class="form-control"  id="tv_create_mysql_pwd">
						</div>
					</div>
				</form>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
                            cancel
                </button>
				<button type="button" class="btn btn-primary" id="btn_create" name="btn_create">
                    add
                </button>
			</div>
		</div>
	</div>
</div>


<!-- /. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="main-menu">
			<li class="text-center"><img src="<?php echo base_url(); ?>assets/img/find_user.png"
				class="user-image img-responsive" /></li>


			<li><a class="active-menu" href="#"><i class="fa fa-sitemap fa-3x"></i> <?php echo $arr_ui_string["menu_user"]?><span
					class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="<?php echo base_url(); ?>users/user_info_view"> <?php echo $arr_ui_string["menu_user_info"]?></a></li>
					<li><a href="<?php echo base_url(); ?>users/ib_info_view"> <?php echo $arr_ui_string["menu_ib_info"]?></a></li>
					<li><a href="<?php echo base_url(); ?>users/wl_info_view"> <?php echo $arr_ui_string["menu_wl_info"]?></a></li>
					<li><a href="<?php echo base_url(); ?>users/lp_info_view"> <?php echo $arr_ui_string["menu_lp_info"]?></a></li>
				</ul>
			</li>
			<li><a href="ui.html"><i class="fa fa-desktop fa-3x"></i> <?php echo $arr_ui_string["menu_statement"]?><span
					class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<!-- <li><a href="<?php echo base_url();?>statement/comm_settle_view"> <?php echo $arr_ui_string["menu_comm_settle_view"]?></a></li>  -->
					<li><a href="<?php echo base_url();?>statement/compare_order_view"> <?php echo $arr_ui_string["menu_statement_compare_order"]?></a></li>
					<li><a href="<?php echo base_url();?>statement/settle_summary_view"> <?php echo $arr_ui_string["menu_statement_settle_summary"]?></a></li>
					<li><a href="<?php echo base_url();?>statement/closed_orders_view"> <?php echo $arr_ui_string["menu_statement_closed_orders"]?></a></li>
					<li><a href="<?php echo base_url();?>statement/opened_orders_view"> <?php echo $arr_ui_string["menu_statement_opend_orders"]?></a></li>
					<li><a href="<?php echo base_url();?>statement/equity_view"> <?php echo $arr_ui_string["menu_statement_equip_view"]?></a></li>
					
				</ul>
			</li>
			<li><a href="tab-panel.html"><i class="fa fa-qrcode fa-3x"></i>  <?php echo $arr_ui_string["menu_trade"]?><span
					class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="<?php echo base_url();?>trade/trade_report_view"> <?php echo $arr_ui_string["menu_trade_report_view"]?></a></li>
				</ul>
			</li>
			<li><a class="menu" href="#"><i class="fa fa-sitemap fa-3x"></i> <?php echo $arr_ui_string["menu_manager"]?><span
					class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="<?php echo base_url(); ?>manager/manager_info_view"> <?php echo $arr_ui_string["menu_manager_info"]?></a></li>
					<li><a href="<?php echo base_url(); ?>manager/trac_manager_view"> <?php echo $arr_ui_string["menu_manager_trac"]?></a></li>
					<li><a href="<?php echo base_url(); ?>manager/freemargin_warning_view"> <?php echo $arr_ui_string["menu_manager_freemargin_warning"]?></a></li>
					<li><a href="<?php echo base_url(); ?>manager/managers_basket_group"><?php echo $arr_ui_string["menu_managers_basket_group"]?></a></li>
					<!-- <li><a href="#"><?php echo $arr_ui_string["menu_manager_basket"]?><span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li><a href="<?php echo base_url(); ?>manager/managers_basket_group"><?php echo $arr_ui_string["menu_managers_basket_group"]?></a></li>
						</ul></li>  -->
				</ul>
			</li>
			<li><a class="menu" href="#"><i class="fa fa-sitemap fa-3x"></i> <?php echo $arr_ui_string["menu_config"]?><span
					class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><a href="<?php echo base_url(); ?>configuration/markup_bridge_view"> <?php echo $arr_ui_string["menu_config_markup_bridge"]?></a></li>
					<li><a href="<?php echo base_url(); ?>configuration/designate_omni_view"> <?php echo $arr_ui_string["menu_config_designate_omni"]?></a></li>
					<li><a href="<?php echo base_url(); ?>configuration/settle_price_view"> <?php echo $arr_ui_string["menu_config_settle_price"]?></a></li>
					<li><a href="<?php echo base_url(); ?>configuration/agent_comm_view"> <?php echo $arr_ui_string["menu_config_agent_comm"]?></a></li>
					<li><a href="<?php echo base_url(); ?>configuration/lp_account_view"> <?php echo $arr_ui_string["menu_config_lp_account"]?></a></li>
				</ul>
			</li>
			<!-- <li><a href="form.html"><i class="fa fa-edit fa-3x"></i> <?php echo $arr_ui_string["menu_notify"]?> </a></li>  -->
		</ul>

	</div>

</nav>

<!-- /. NAV SIDE  -->

<?php
$lang["admin_title"] = "FBP BackOfficeSystem";

$lang["menu_user"] = "유저관리";
$lang['menu_wl_info'] = "103_wl_info";
$lang['menu_ib_info'] = "102_ib_info";
$lang["menu_user_info"] = "유저정보";
$lang['menu_lp_info'] = "104_lp_info";

$lang["menu_statement"] = "상태관리";
$lang["menu_comm_settle_view"] = "202_comm_settle_view";
$lang["menu_statement_compare_order"] = "206_compare_order";
$lang["menu_statement_settle_summary"] = "203_settle_summary";
$lang["menu_statement_closed_orders"] = "302_closed_orders";
$lang["menu_statement_opend_orders"] = "301_opened_orders";
$lang["menu_statement_equip_view"] = "201_equity_view";

$lang["menu_trade"] = "내역상세";
$lang["menu_trade_report_view"] = "304_trade_report";

$lang["menu_manager"] = "관리자";
$lang["menu_manager_info"] = "901_manager_info";
$lang["menu_manager_basket"] = "Manager Basket";
$lang["menu_manager_trac"] = "503_trace_manager";
$lang["menu_managers_basket_group"] = "501 Managers Basket Group";
$lang["menu_managers_basket_alloc"] = "501 Managers Basket Alloc";
$lang["menu_manager_freemargin_warning"] = "504 FreeMargine Warning";

$lang["menu_config"] = "구성";
$lang["menu_config_spread_lp"] = "401_spread_lp";
$lang["menu_config_markup_bridge"] = "401_markup_bridge";
$lang["menu_config_designate_omni"] = "402_designate_omni";
$lang["menu_config_settle_price"] = "403_settle_price";
$lang["menu_config_agent_comm"] = "404_agent_comm";
$lang["menu_config_lp_account"] = "405_lp_account";

$lang["menu_notify"] = "알림";

$lang["btn_title_prev"] = "이전";
$lang["btn_title_next"] = "다음";
$lang["btn_title_register"] = "등록하기";
$lang["btn_title_create"] = "창조하기";
$lang["btn_title_modify"] = "변경하기";
$lang["btn_title_cancel"] = "취소하기";
$lang["btn_title_delete"] = "삭제하기";
$lang["btn_select_all"] = "전체";
$lang["btn_title_update"] = "업데이트하기";
$lang["btn_title_search"] = "검색";
$lang["btn_title_save"] = "보관";
$lang["btn_title_export"] = "Export";
$lang["btn_title_import"] = "Import";
$lang["btn_title_download_import_template"] = "Download Template";

//
// user 관리
//

// 유저관리
$lang["users_userinfo_title"]   = "유저정보";
$lang["users_userinfo_explain"] = "유저들의 정보를 검색해보십시오.";
$lang["users_userinfo_search"] = "검색:";
$lang["users_userinfo_basket"] = "바스키트";
$lang["users_userinfo_fields"] = Array("바스키트",	"Account",	"Name",	"Balance",	"PrevBal.",	"PrevMonBal.",	"Leverage",	"Interate",	"PrevEquity",	"PrevMonEquity",	"Group",	"AgentAccNo",	"Status",	"RegDate",	"LastDate",	"LastUpddate",	"Phone",	"Email",	"Country",	"City",	"State","Zipcode");

// W/L관리
$lang["wl_info_title"]   = "WL Info";
$lang["wl_info_explain"] = "Search  WLs' information";
$lang["wl_info_fields"] = Array("Company Name",	"Status",	"Enabled",	"Omnibus ID",	"Address",	"Phone", "Email", "LastUpdate", "Last Updater", "Comment");


// WL변경 다이얼로그
$lang["wl_dlg_change_title"]   = "WL Info Change";

// LP관리
$lang["lp_info_title"]   = "LP Info";
$lang["lp_info_explain"] = "Search  LPs' information";
$lang["lp_info_fields"] = Array("LP ID",	"LP Name",	"Enabled",	"Phone","Email", "Address", "Comment", "LastUpdate", "Last Updater");


// LP 다이얼로그
$lang["lp_dlg_change_title"]   = "LP Info Change";
$lang["lp_dlg_create_title"]   = "LP Info Create";

// ib관리
$lang["ib_info_title"]   = "ib Info";
$lang["ib_info_explain"] = "Search  ibs' information";
$lang["ib_info_fields"] = Array("IB Account",	"IB Name",	"W/L",	"Group","Comm(pt)", "Upper Agent", "Enabled", "Hierarchy","Creation date" ,"Last update");


// ib 다이얼로그
$lang["ib_dlg_change_title"]   = "ib Info Change";
$lang["ib_dlg_create_title"]   = "ib Info Create";
$lang["ib_dlg_fields"] = Array("Agent Name",	"W/L",	"Group","Comm(pt)", "Upper Agent", "Enabled", "Hierarchy");

// 유저정보변경다이얼로그 
$lang["users_dlg_change_title"] = "Change";
$lang["users_dlg_change_account"] = "Account";
$lang["users_dlg_change_name"] = "Name";
$lang["users_dlg_change_leverage"] = "Leverage";
$lang["users_dlg_change_group"] = "Group";
$lang["users_dlg_change_agentaccount"] = "Agent Account";
$lang["users_dlg_change_status"] = "Status";
$lang["users_dlg_change_basket"] = "Basket";
$lang["users_dlg_change_country"] = "Country";
$lang["users_dlg_change_city"] = "City";
$lang["users_dlg_change_state"] = "State";
$lang["users_dlg_change_zipcode"] = "Zipcode";
$lang["users_dlg_change_phone"] = "Phone";
$lang["users_dlg_change_email"] = "Email";


//
//  Manager
//

// 로그인창
$lang["login_title"] = "Enter Details To Login";
$lang["login_id"] = "ID";
$lang["login_passwd"] = "PASSWORD";

$lang["manager_info_title"]   = "Manager Info";
$lang["manager_info_explain"] = "Search  managers' information";
$lang["manager_info_companyname"] = "Company Name";
$lang["manager_info_managername"] = "Manager Name";
$lang["manager_info_fields"] = Array("ManagerID", "Manager Name", "Company Name", "Company Pwd", "Last Logon TM", "Comments");
$lang["manager_trace_fields"] = Array("Date", "Time", "SEQ NO",	"Worker", "Company", "Title", "Detail");

// 매니저다이얼로그
$lang["manager_dlg_change_title"]   = "Manager Info Change";
$lang["manager_dlg_create_title"]   = "Manager Info Create";
$lang["manager_dlg_managerid"] = "Manager ID";
$lang["manager_dlg_name"] = "Name";
$lang["manager_dlg_password"] = "Password";
$lang["manager_dlg_comments"] = "Comments";
$lang["manager_dlg_companyname"] = "Company Name";



// Managers Basket관리
$lang["managers_basket_group_title"]   = "Managers Basket Info";
$lang["managers_basket_group_explain"] = "Search  Manager Baskets' information";
$lang["managers_basket_group_fields"] = Array("Basket Code",	"Basket Name",	"Comments",	"Count of Goup", "Allocate Group");
$lang["managers_basket_group_list"]   = "[ MT4 Group List ]";
$lang["managers_basket_group_basket_list"]   = "[ Groups in Basket ]";
$lang["managers_basket_group_btn_alloc"]   = "Alloc Group";

// Managers 다이얼로그
$lang["managers_basket_dlg_change_title"]   = "Managers Basket Info Change";
$lang["managers_basket_dlg_create_title"]   = "Managers Basket Info Create";
$lang["managers_basket_dlg_alloc_title"]    = "Alloc Group";

// Managers Basket Alloc User
$lang["managers_basket_alloc_user_title"]   = "Allocate Users into Basket";
$lang["managers_basket_alloc_user_explain"] = "Allocate Users into Basket";
$lang["managers_basket_alloc_user_fields"] = Array("Check","Account",	"Name",	"W/L",	"Group", "BASKET");

// Manager FreeMargine Waring
$lang["manager_freemargin_warning_title"]   = "< 504_freemargin_warning >";
$lang["manager_freemargin_warning_explain"] = "< 504_freemargin_warning >";
$lang["manager_freemargin_warning_fields"] = Array("Deal","Login",	"Time",	"Type",	"Symbol", "Volume", "Price", "SL", "TP");
$lang["manager_freemargin_warning_cf"] = Array("Free Margin Limit", "Save FreeMargin Limit");


//
//  Configuration
//

// SPREAD_LP 관리
$lang["configuration_spread_lp_title"]   = "Spread LP Info";
$lang["configuration_spread_lp_explain"] = "Search  Spread LPs' information";
$lang["configuration_spread_lp_fields"] = Array("Check",	"LP Name",	"Symbol",	"Markup Bid",	"Markup Ask",	"Enabled");

// SPREAD_LP 다이얼로그
$lang["configuration_spread_lp_dlg_create_title"]   = "Spread LP Create";


// Mark_bridge 관리
$lang["configuration_markup_bridge_title"]   = "401 markup_bridge";
$lang["configuration_markup_bridge_explain"] = "Search  markup_bridges' information";
$lang["configuration_markup_bridge_fields"] = Array("Check",	"LP Name",	"Symbol",	"SPREAD" ,"Markup Bid",	"Markup Ask",	"Swap Short", "Swap Long", "DIGITS", "Enabled");
$lang["configuration_markup_bridge_other_fields"] = Array("Mark Up", "Swap");

// Mark_bridge 다이얼로그
$lang["configuration_markup_bridge_dlg_create_title"]   = "markup_bridge Create";

// settle_price 관리
$lang["configuration_settle_price_title"]   = "Settle Price";
$lang["configuration_settle_price_explain"] = "show and set Settle Price";
$lang["configuration_settle_price_fields"] = Array("SYMBOL", "MARKET_RATE");
$lang["configuration_settle_price_lp"] = "LP";
$lang["configuration_settle_price_date"] = "Date";
$lang["configuration_settle_price_dlg_create_title"]   = "settle price create";
$lang["configuration_settle_price_dlg_update_title"]   = "settle price update";

// agent_comm 관리
$lang["configuration_agent_comm_title"]   = "< AGENT COMM >";
$lang["configuration_agent_comm_explain"] = "show and set agent comm";
$lang["configuration_agent_comm_fields"] = Array("GROUP", "Agent Comm (pt)", "MT4 Spread (pt)");

// lp_account 관리
$lang["configuration_lp_account_title"]   = "< LP ACCOUNT >";
$lang["configuration_lp_account_explain"] = "search < LP ACCOUNT >";
$lang["configuration_lp_account_fields"] = Array("LP ID", "LP NAME", "LP Account", "Comment");
$lang["configuration_lp_account_dlg_create_title"]   = "lp account create";
$lang["configuration_lp_account_dlg_update_title"]   = "lp account modify";

//
//  Trade
//
// 304_trade_report 관리
$lang["trade_report_title"]   = "304_trade_report";
$lang["trade_report_explain"] = "Search  trade_reports' information";
$lang["trade_report_fields"] = Array("Deal", "Login", "OpenTime", "Type", "Symbol", "Volume", "CloseTime", "Agent", "Swap", "Profit", "Comment");
$lang["trade_report_search_fields"] = Array("Account", "Term");


//
// Statement
//
// comm_settle_view 관리
$lang["common_settle_view_title"]   = "Commission Settlement";
$lang["common_settle_view_explain"] = "Search  Commission Settlements' information";
$lang["common_settle_view_fields"] = Array("Group Name",	"MT4 Mark-up",	"MT4 Spread",	"Total Agent Comm" ,"1st IB",	"2nd IB",	"3rd IB", "4th IB", "5th IB", "6th IB", "7th IB", "8th IB", "9th IB", "10th IB", "11th IB", "12th IB", "13th IB", "14th IB", "15th IB", "16th IB", "17th IB", "18th IB", "19th IB", "20th IB");
$lang["common_settle_view_other_fields"] = Array("Mark-up Common", "Spread", "AgentCommission");
$lang["common_settle_view_search_fields"] = Array("Basket", "Inqurity Period");

// compare_order 관리
$lang["compare_order_title"]   = "Compare Order";
$lang["compare_order_explain"] = "Compare and Order Values";
$lang["compare_order_omni_fields"] = Array("Volume", "WL Omni", "Volume2", "WL Subtotal", "Diff.(Volume)");
$lang["compare_order_order_fields"] = Array("Symbol", "Invast", "Sensus", "FBP", "buy", "sell", "diff");
$lang["compare_order_symbol_fields"] = Array("Order", "Login", "Open Time", "Type", "Symbol", "Volume", "Open Price", "S/L", "Reason", "Agent", "Swap", "Profit", "Comment", "Group");
$lang["compare_order_nomatch_fields"] = Array("Order", "Login", "Open Time", "Type", "Symbol", "Volume", "Open Price", "S/L", "Reason", "Agent", "Swap", "Profit", "Comment", "Deal", "Deal MATC", "OP MATC", "Vol Match");
$lang["compare_order_table_expain"] = Array("Omni계좌와 실계좌(WL의 하위계좌)의 주문 비교",
		"LP와 심볼별 포지션 비교",
		"현재 MT4에 열려있는 주문 목록",
		"Omni계좌와 실계좌의 불일치 주문 목록");
$lang["compare_order_btn_save_lp"] = "Save LP";
$lang["compare_order_btn_request"] = "Request";

// 203_settle_summary 관리
$lang["statement_settle_summary_title"]   = "< Settle Summary >";
$lang["statement_settle_summary_explain"] = "Search Settle Summaries information";
$lang["statement_settle_summary_fields_1"] = Array("W/L Client",	"Volume",	"Swap",	"PnL" ,"Mark-up Comm",	"FBP Total Profit",	"Agent Comm");
$lang["statement_settle_summary_fields_2"] = Array("",	"BUY VOLUME",	"SELL VOLUME",	"GROSS VOLUME" ,"DEPOSIT",	"WITHDRAWAL", "P/L", "SWAP", "BALANCE", "Floating P/L", "PREV EQUITY", "CURR EQUITY", "EQUITY DIFF");
$lang["statement_settle_summary_fields_3"] = Array("W/L Client",	"PnL",	"Volume",	"Swap" ,"Mark-up Comm",	"Agent Comm", "FBP Total Profile");
$lang["statement_settle_summary_date"] = "날짜";
$lang["statement_settle_summary_register_lp_account"] = "Register LP Account";
$lang["statement_settle_summary_table_expain"] = Array("FBP Abook 기대수익(MT4)", "FBP Abook 실제수익", "FBP B Book 기대수익");

// 302_closed_orders 관리
$lang["statement_closed_orders_title"]   = "< Closed Orders >";
$lang["statement_closed_orders_explain"] = "Closed Orders in A Book";
$lang["statement_closed_orders_fields_1"] = Array("W/L Client",	"PnL",	"Volume",	"Swap" ,"Mark-up Comm",	"Agent Comm", "FBP Total PnL");
$lang["statement_closed_orders_fields_2"] = Array("Deal", "Login", "Open Time", "Type", "Symbol", "Volume", "Closed Time", "Fixed Closed Price", "Swap", "2nd Conv", "Fixed Profit", "Group", "Total FBP Markup Comm", "Agent Comm");
$lang["statement_closed_orders_date"] = "Date";
$lang["statement_closed_orders_table_expain"] = Array("Summary A Group", "Closed Orders");


// 301_opened_orders 관리
$lang["statement_opened_orders_title"]   = "< opened Orders >";
$lang["statement_opened_orders_explain"] = "opened Orders in A Book";
$lang["statement_opened_orders_fields_1"] = Array("W/L Client",	"PnL",	"Volume",	"Swap" , "Agent Comm", "Mark-up Comm", "FBP Total Profile");
$lang["statement_opened_orders_fields_2"] = Array("Deal", "Login", "Open Time", "Type", "Symbol", "Volume", "Fixed Closed Price","Closed Price", "Swap", "2nd Conv", "Fixed Profit", "Group", "Total FBP Markup Comm", "Agent Comm");
$lang["statement_opened_orders_date"] = "Date";
$lang["statement_opened_orders_table_expain"] = Array("Summary A Group", "opened Orders");

// 201_quip_view 관리
$lang["statement_equip_view_title"]   = "< Equip View >";
$lang["statement_equip_view_explain"] = "Search Equities";
$lang["statement_equip_view_fields"] = Array("W/L",	"MT4 Account",	"Previous",	"Today" ,"Difference");
$lang["statement_equip_view_date"] = "Date";
$lang["statement_equip_view_cash"] = "CASH";
$lang["statement_equip_view_cash_fields"] = Array("",	"Account",	"Previous",	"Today" ,"Difference");

// 메시지
$lang['msg_export_ok'] = "Exported Successfully.";
$lang['msg_import_ok'] = "Imported Successfully.";
$lang['msg_save_ok'] = "Saved Successfully.";
$lang['msg_fail_network'] = "Network Failed! Please confirm your network.";
$lang['msg_fail_login_idpwd'] = "Please check your ID and Password.";
$lang['msg_input_idpwd'] = "Please input your ID or Password.";
$lang['msg_err_array'] = Array("관리자ID 가 존재하지 않습니다.", 										// 0
								 "대상 관리자ID 가 존재하지 않습니다.", 									// 1
								 "관리자ID 가 이미 존재합니다.", 										// 2
								 "잘못된 비밀번호 입니다.", 											// 3
								 "admin 계정만 새로운 관리자를 생성할 수 있습니다.",							// 4
								 "admin 계정만 다른 관리자 정보를 수정할 수 있습니다.", 						// 5
								 "LP ID 가 존재하지 않습니다.", 										// 6
								 "회사명이 존재하지 않습니다.", 										// 7
								 "고객 계좌가 존재하지 않습니다.", 										// 8
								 "일요일 또는 월요일에는 배치작업을 진행하지 않습니다.");						// 9

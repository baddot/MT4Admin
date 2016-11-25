<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statement extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct() {
        // Call the Model constructor
        parent::__construct ();
    }

    /*****************************************************	
 	 * View
 	 * ***************************************************/ 
    
    public  function  comm_settle_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/202/202_comm_settle_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $this->getLoggedUserID();
    	$data['list_basket'] = $this->admin_model->SP_LIST_BASKET($params);
    	
    	$this->load->view('includes/template', $data);
    }
    
    public  function  compare_order_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/206/206_compare_order.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	 
    	$this->load->view('includes/template', $data);
    }
    
    public  function  settle_summary_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/203/203_settle_summary.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
  		$data['i_dt'] = $this->input->get('i_dt');
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $this->getLoggedUserID();
    	$params['i_manager_level'] = $this->getSesstionData()['i_manager_level'];
    	$params['i_dt'] = $this->input->get('i_dt');
    	$data['list_balance'] = $this->admin_model->SP_LP_BALANCE_VIEW($params);
    	
    	$this->load->view('includes/template', $data);
    }
    
    public  function  closed_orders_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/302/302_closed_orders.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    
    	$this->load->view('includes/template', $data);
    }
    
    public  function  opened_orders_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/301/301_opened_orders.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    
    	$this->load->view('includes/template', $data);
    }
    
    
    public  function  equity_view(){
    	// load template
    	$data['main_content'] = 'admin/statement/201/201_equity_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    
    	$this->load->view('includes/template', $data);
    }
    
    
    /*****************************************************
     * API
     * ***************************************************/
    public function  POST_COMM_SETTLE_VIEW($api = true) {
    	//
    	// get parameters from requests.
    	//
    	$keyword = $this->input->post("search");
    	 
    	if($keyword == null) {
    		$keyword = "";
    	}
    	else {
    		$keyword = $keyword['value'];
    	}
    	 
    	$start = $this->input->post("start");
    	 
    	if($start == null || $start < 0) {
    		$start = 0;
    	}
    	 
    	$list_cnt = $this->input->post("length");
    	if($list_cnt == null) {
    		$list_cnt = ADMIN_DEFAULT_LIST_CNT;
    	}
    	    	 
    	$result = $this->getSesstionData();
    	 
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_last_id'] = $start;
    	$params['i_basket_code'] = $this->input->post("i_basket_code");
    	$params['i_from'] = $this->input->post("i_from");
    	$params['i_to'] = $this->input->post("i_to");
    	$params['i_list_count'] = $list_cnt;
    	 
    	$arrManagerInfo = $this->admin_model->SP_COMM_SETTLE_VIEW($params);
    	 
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_COMM_SETTLE_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_COMM_SETTLE_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_COMM_SETTLE_VIEW_CNT($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    	 
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	$lp_id = $this->input->post("i_lp_id");
    	 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_basket_code'] = $this->input->post("i_basket_code");
    	$params['i_from'] = $this->input->post("i_from");
    	$params['i_to'] = $this->input->post("i_to");
    	 
    	$count = $this->admin_model->SP_COMM_SETTLE_VIEW_CNT($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  GET_COMPARE_OPENORD_OMNI_SUB ($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;

    	$arrData = $this->admin_model->SP_COMPARE_OPENORD_OMNI_SUB($params);
    
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  GET_COMPARE_OPENORDER_SYMBOL($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$arrData = $this->admin_model->SP_COMPARE_OPENORDER_SYMBOL($params);
    
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  GET_COMPARE_LIST_OPENORDER($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$arrData = $this->admin_model->SP_COMPARE_LIST_OPENORDER($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PROFIT'] = $this->util->getCommanMoney($userInfo['PROFIT']);
    		$arrData[$i] = $userInfo;
    	}
    	
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    	
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    	
    	return $data['data'];
    }
    
    public function  GET_COMPARE_NONMATCH_OPENORDER($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$arrData = $this->admin_model->SP_COMPARE_NONMATCH_OPENORDER($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PROFIT'] = $this->util->getCommanMoney($userInfo['PROFIT']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    	
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    	
    	return $data['data'];
    }
    
    
    public function  POST_COMPARE_SAVE_LPORDER($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_invast_vol'] = $this->input->post('i_invast_vol');
    	$params['i_sensus_vol'] = $this->input->post('i_sensus_vol');
    
    	$result = $this->admin_model->SP_COMPARE_SAVE_LPORDER($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function POST_EXPORT_EXCEL($api=true) {
    	 
    	$type = $this->input->post("type");
    	 
    	$sheet_name = "";
    	$file_name = "statement";
    	$export_url = "";
    	if($type == 0) {
    		$sheet_name = "COMPARE_OPENORDER_SYMBOL";
    		$field_array = Array("SYMBOL", "INVAST_VOL", "SENSUS_VOL", "FBP_VOL", "BUY_VOL", "SELL_VOL", "DIFF_VOL");
    		$data = $this->GET_COMPARE_OPENORDER_SYMBOL(false);
    		$data = $data['data'];
    	}
    	else if($type == 1) {
    		$sheet_name = "COMPARE_LIST_OPENORDER";
    		$field_array = Array("TICKET", "LOGIN", "MODIFY_TIME", "TYPE", "SYMBOL", "VOLUME", "OPEN_PRICE", "SL", "REASON", "COMMISSION_AGENT", "SWAPS", "PROFIT", "COMMENT", "GROUP");
    		$data = $this->GET_COMPARE_LIST_OPENORDER(false);
    		$data = $data['data'];
    	}
    	else if($type == 2) {
    		$sheet_name = "COMPARE_NONMATCH_OPENORDER";
    		$field_array = Array("TICKET", "LOGIN", "OPEN_TIME", "TYPE", "SYMBOL", "VOLUME", "OPEN_PRICE", "SL", "REASON", "COMMISSION_AGENT", "SWAPS", "PROFIT", "COMMENTS", "SUB_TICKET", "DEAL_MATCH", "OP_MATCH", "VOL_MATCH");
    		$data = $this->GET_COMPARE_NONMATCH_OPENORDER(false);
    		$data = $data['data'];
    	}
    	
    	if($sheet_name != ""){
    		$export_url = $this->export_excel($file_name,$sheet_name, $field_array, $data);
    	}
    	 
    	$result = VALUE_OK;
    	 
    	if($api == true) {
    		$this->doRespondWithResult($result, Array("export_url"=>$export_url));
    		return;
    	}
    	 
    	return $result;
    } 
    
    public function  GET_SETTLE_SUMMARY_A($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_SETTLE_SUMMARY_A($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PNL'] = $this->util->getCommanMoney($userInfo['PNL']);
    		$userInfo['MARKUP_COMM'] = $this->util->getCommanMoney($userInfo['MARKUP_COMM']);
    		$userInfo['AGENT_COMM'] = $this->util->getCommanMoney($userInfo['AGENT_COMM']);
    		$arrData[$i] = $userInfo;
    	}
    	
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
	public function  GET_SETTLE_SUMMARY_B($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_SETTLE_SUMMARY_B($params);
    	
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PNL'] = $this->util->getCommanMoney($userInfo['PNL']);
    		$userInfo['MARKUP_COMM'] = $this->util->getCommanMoney($userInfo['MARKUP_COMM']);
    		$userInfo['AGENT_COMM'] = $this->util->getCommanMoney($userInfo['AGENT_COMM']);
    		$arrData[$i] = $userInfo;
    	}
    	
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_SETTLE_SUMMARY_A_GROUP($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_close_yn'] = $this->input->post('i_close_yn');
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_SETTLE_SUMMARY_A_GROUP($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PNL'] = $this->util->getCommanMoney($userInfo['PNL']);
    		$userInfo['AGENT_COMM'] = $this->util->getCommanMoney($userInfo['AGENT_COMM']);
    		$userInfo['MARKUP_COMM'] = $this->util->getCommanMoney($userInfo['MARKUP_COMM']);
    		$userInfo['FBP_TOT_PROFIT'] = $this->util->getCommanMoney($userInfo['FBP_TOT_PROFIT']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  GET_CLOSED_ORDERS_VIEW($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_CLOSED_ORDERS_VIEW($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['FIXED_PROFIT'] = $this->util->getCommanMoney($userInfo['FIXED_PROFIT']);
    		$userInfo['TOTAL_FBP_MARKUP'] = $this->util->getCommanMoney($userInfo['TOTAL_FBP_MARKUP']);
    		$userInfo['AGENT_COMM'] = $this->util->getCommanMoney($userInfo['AGENT_COMM']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  GET_OPENED_ORDERS_VIEW($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_OPENED_ORDERS_VIEW($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['FIXED_PROFIT'] = $this->util->getCommanMoney($userInfo['FIXED_PROFIT']);
    		$userInfo['TOTAL_FBP_MARKUP'] = $this->util->getCommanMoney($userInfo['TOTAL_FBP_MARKUP']);
    		$userInfo['AGENT_COMM'] = $this->util->getCommanMoney($userInfo['AGENT_COMM']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_EQUITY_VIEW($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_EQUITY_VIEW($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PREV_EQUITY'] = $this->util->getCommanMoney($userInfo['PREV_EQUITY']);
    		$userInfo['EQUITY'] = $this->util->getCommanMoney($userInfo['EQUITY']);
    		$userInfo['DIFF_EQUITY'] = $this->util->getCommanMoney($userInfo['DIFF_EQUITY']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  POST_CASH_VIEW($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    
    	$arrData = $this->admin_model->SP_CASH_VIEW($params);
    	for($i = 0; $i < count($arrData); $i++) {
    		$userInfo = $arrData[$i];
    		$userInfo['PREV_AMOUNT'] = $this->util->getCommanMoney($userInfo['PREV_AMOUNT']);
    		$userInfo['AMOUNT'] = $this->util->getCommanMoney($userInfo['AMOUNT']);
    		$userInfo['DIFF_AMOUNT'] = $this->util->getCommanMoney($userInfo['DIFF_AMOUNT']);
    		$arrData[$i] = $userInfo;
    	}
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_CASH_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    	$params['i_type_name'] = $this->input->post('i_type_name');
    	$params['i_account_name'] = $this->input->post('i_account_name');
    	$params['i_amount'] = $this->input->post('i_amount');
    
    	$result = $this->admin_model->SP_CASH_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_LP_BALANCE_VIEW($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_dt'] = $this->input->post('i_dt');
    	if($params['i_dt'] == null || $params['i_dt'] == false) {
    		$params['i_dt'] = '';
    	}
    
    	$arrData = $this->admin_model->SP_LP_BALANCE_VIEW($params);
    	
    	$data['data']['data'] = $arrData;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrData);
    	$data['data']['recordsTotal'] = count($arrData);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_LP_BALANCE_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_dt'] = $this->input->post('i_dt');
    	$params['i_lp_account'] = $this->input->post('i_lp_account');
    	$params['i_buy_volume'] = $this->input->post('i_buy_volume');
    	$params['i_sell_volume'] = $this->input->post('i_sell_volume');
    	$params['i_gross_volume'] = $this->input->post('i_gross_volume');
    	$params['i_withdrawal'] = $this->input->post('i_withdrawal');
    	$params['i_profit'] = $this->input->post('i_profit');
    	$params['i_balance'] = $this->input->post('i_balance');
    	$params['i_deposit'] = $this->input->post('i_deposit');
    	$params['i_swaps'] = $this->input->post('i_swaps');
    	$params['i_floating_profit'] = $this->input->post('i_floating_profit');
    	$params['i_prev_equity'] = $this->input->post('i_prev_equity');
    	$params['i_curr_equity'] = $this->input->post('i_curr_equity');
    
    	$result = $this->admin_model->SP_LP_BALANCE_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    /*****************************************************
     * other functions
     * ***************************************************/
    final function getUIStringArray() {
    	$arr_string = parent::getUIStringArray();
    	 
    	// comm_settle_view
    	$arr_string["common_settle_view_title"]   = $this->lang->line("common_settle_view_title");
    	$arr_string["common_settle_view_explain"]   = $this->lang->line("common_settle_view_explain");
    	$arr_string["common_settle_view_fields"]= $this->lang->line("common_settle_view_fields");
    	$arr_string["common_settle_view_other_fields"] = $this->lang->line("common_settle_view_other_fields");
    	$arr_string["common_settle_view_search_fields"]   = $this->lang->line("common_settle_view_search_fields");

    	// compare_order
    	$arr_string["compare_order_title"]   = $this->lang->line("compare_order_title");
    	$arr_string["compare_order_explain"]   = $this->lang->line("compare_order_explain");
    	$arr_string["compare_order_omni_fields"]= $this->lang->line("compare_order_omni_fields");
    	$arr_string["compare_order_order_fields"]= $this->lang->line("compare_order_order_fields");
    	$arr_string["compare_order_symbol_fields"]= $this->lang->line("compare_order_symbol_fields");
    	$arr_string["compare_order_nomatch_fields"]= $this->lang->line("compare_order_nomatch_fields");
    	$arr_string["compare_order_btn_save_lp"]= $this->lang->line("compare_order_btn_save_lp");
    	$arr_string["compare_order_btn_request"]= $this->lang->line("compare_order_btn_request");
    	$arr_string["compare_order_table_expain"]= $this->lang->line("compare_order_table_expain");
    	
    	// 203_settle_summary
    	$arr_string["statement_settle_summary_title"]   = $this->lang->line("statement_settle_summary_title");
    	$arr_string["statement_settle_summary_explain"]   = $this->lang->line("statement_settle_summary_explain");
    	$arr_string["statement_settle_summary_date"]= $this->lang->line("statement_settle_summary_date");
    	$arr_string["statement_settle_summary_fields_1"] = $this->lang->line("statement_settle_summary_fields_1");
    	$arr_string["statement_settle_summary_fields_2"]   = $this->lang->line("statement_settle_summary_fields_2");
    	$arr_string["statement_settle_summary_fields_3"]   = $this->lang->line("statement_settle_summary_fields_3");
    	$arr_string["statement_settle_summary_table_expain"]   = $this->lang->line("statement_settle_summary_table_expain");
    	$arr_string["statement_settle_summary_register_lp_account"]   = $this->lang->line("statement_settle_summary_register_lp_account");
    	
    	// 203_settle_summary
    	$arr_string["statement_closed_orders_title"]   = $this->lang->line("statement_closed_orders_title");
    	$arr_string["statement_closed_orders_explain"]   = $this->lang->line("statement_closed_orders_explain");
    	$arr_string["statement_closed_orders_date"]= $this->lang->line("statement_closed_orders_date");
    	$arr_string["statement_closed_orders_fields_1"] = $this->lang->line("statement_closed_orders_fields_1");
    	$arr_string["statement_closed_orders_fields_2"]   = $this->lang->line("statement_closed_orders_fields_2");
    	$arr_string["statement_closed_orders_table_expain"]   = $this->lang->line("statement_closed_orders_table_expain");
    	
    	// 203_settle_summary
    	$arr_string["statement_opened_orders_title"]   = $this->lang->line("statement_opened_orders_title");
    	$arr_string["statement_opened_orders_explain"]   = $this->lang->line("statement_opened_orders_explain");
    	$arr_string["statement_opened_orders_date"]= $this->lang->line("statement_opened_orders_date");
    	$arr_string["statement_opened_orders_fields_1"] = $this->lang->line("statement_opened_orders_fields_1");
    	$arr_string["statement_opened_orders_fields_2"]   = $this->lang->line("statement_opened_orders_fields_2");
    	$arr_string["statement_opened_orders_table_expain"]   = $this->lang->line("statement_opened_orders_table_expain");
    	
    	// 201_equity_view
    	$arr_string["statement_equip_view_title"]   = $this->lang->line("statement_equip_view_title");
    	$arr_string["statement_equip_view_explain"]   = $this->lang->line("statement_equip_view_explain");
    	$arr_string["statement_equip_view_fields"]= $this->lang->line("statement_equip_view_fields");
    	$arr_string["statement_equip_view_date"] = $this->lang->line("statement_equip_view_date");
    	$arr_string["statement_equip_view_cash"] = $this->lang->line("statement_equip_view_cash");
    	$arr_string["statement_equip_view_cash_fields"] = $this->lang->line("statement_equip_view_cash_fields");
    	
    	return $arr_string;
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
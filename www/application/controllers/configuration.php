<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends MY_Controller {

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
    
    public  function  spread_lp_view(){
    	// load template
    	$data['main_content'] = 'admin/configuration/401/401_spread_lp.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['list_lp'] =$this->GET_LIST_LP(false);
    	$this->load->view('includes/template', $data);
    }
    
    
    public  function  markup_bridge_view(){
    	// load template
    	$data['main_content'] = 'admin/configuration/401/401_markup_bridge.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['list_lp'] =$this->GET_LIST_LP(false);
    	$this->load->view('includes/template', $data);
    }
    
    
    public  function  designate_omni_view(){
    	// load template
    	$data['main_content'] = 'admin/configuration/402/402_designate_omni_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['data'] =$this->POST_DESIGNATE_OMNI_VIEW(false);
    	
    	$result = $this->getSesstionData();
    	
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	
    	$data['list_group'] = $this->admin_model->SP_LIST_GROUP($params);
    	$data['list_account'] = $this->admin_model->SP_LIST_ACCOUNT($params);

    	$this->load->view('includes/template', $data);
    }
    
    public  function  settle_price_view() {
    	// load template
    	$data['main_content'] = 'admin/configuration/403/403_settle_price_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	
    	$result = $this->getSesstionData();
    	 
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	 
    	$data['list_lp'] = $this->admin_model->SP_LIST_LP($params);
    	
    	$this->load->view('includes/template', $data);
    }
    
    public  function  agent_comm_view() {
    	// load template
    	$data['main_content'] = 'admin/configuration/404/404_agent_comm.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$data['list_lp'] = $this->admin_model->SP_LIST_LP($params);
    	 
    	$this->load->view('includes/template', $data);
    }
    
	public  function  lp_account_view() {
    	// load template
    	$data['main_content'] = 'admin/configuration/405/405_lp_account.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$data['list_lp'] = $this->admin_model->SP_LIST_LP($params);
    	 
    	$this->load->view('includes/template', $data);
    }
    
    /*****************************************************
     * API
     * ***************************************************/
    public function  POST_SPREAD_LP_VIEW($api = true) {
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
    	 
    	$lp_id = $this->input->post("i_lp_id");
    	 
    	$result = $this->getSesstionData();
    	 
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_last_id'] = $start;
    	$params['i_lp_id'] = $lp_id;
    	$params['i_list_count'] = $list_cnt;
    	 
    	$arrManagerInfo = $this->admin_model->SP_SPREAD_LP_VIEW($params);
    	 
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_SPREAD_LP_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_SPREAD_LP_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_SPREAD_LP_CNT($api=true) {
    
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
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_lp_id'] = $lp_id;
    	 
    	$count = $this->admin_model->SP_SPREAD_LP_VIEW_CNT($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  POST_SPREAD_LP_MODIFY($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    	 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_markup_bid'] = $this->input->post('i_markup_bid');
    	$params['i_markup_ask'] = $this->input->post('i_markup_ask');
    	$params['i_enabled'] = $this->input->post('i_enabled');
    
    	$result = $this->admin_model->SP_SPREAD_LP_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_SPREAD_LP_CREATE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_markup_bid'] = $this->input->post('i_markup_bid');
    	$params['i_markup_ask'] = $this->input->post('i_markup_ask');
    
    	$result = $this->admin_model->SP_SPREAD_LP_CREATE($params);
    
        if($api == true) {
        	$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  GET_LIST_LP($api=true) {
    
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	 
    	if(ADMIN_TEST == true) {
    		$logged_id = 'admin';
    		$level = 11;
    	}
    	 
    	$params = Array();
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	 
    	$arrCompany = $this->admin_model->SP_LIST_LP($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($arrCompany);
    		return;
    	}
    	return $arrCompany;
    }
    
    
    public function  POST_MARKUP_BRIDGE_VIEW($api = true) {
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
    
    	$lp_id = $this->input->post("i_lp_id");
    
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_last_id'] = $start;
    	$params['i_lp_id'] = $lp_id;
    	$params['i_list_count'] = $list_cnt;
    
    	$arrManagerInfo = $this->admin_model->SP_MARKUP_BRIDGE_VIEW($params);
    
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_MARKUP_BRIDGE_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_MARKUP_BRIDGE_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_MARKUP_BRIDGE_VIEW_CNT($api=true) {
    
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
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_lp_id'] = $lp_id;
    
    	$count = $this->admin_model->SP_MARKUP_BRIDGE_VIEW_CNT($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  POST_MARKUP_BRIDGE_MODIFY($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_markup_bid'] = $this->input->post('i_markup_bid');
    	$params['i_markup_ask'] = $this->input->post('i_markup_ask');
    	$params['i_swap_short'] = $this->input->post('i_swap_short');
    	$params['i_swap_long'] = $this->input->post('i_swap_long');
    	$params['i_digits'] = $this->input->post('i_digits');
    	$params['i_enabled'] = $this->input->post('i_enabled');
    
    	$result = $this->admin_model->SP_MARKUP_BRIDGE_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_MARKUP_BRIDGE_CREATE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_markup_bid'] = $this->input->post('i_markup_bid');
    	$params['i_markup_ask'] = $this->input->post('i_markup_ask');
    	$params['i_swap_short'] = $this->input->post('i_swap_short');
    	$params['i_swap_long'] = $this->input->post('i_swap_long');
    	$params['i_digits'] = $this->input->post('i_digits');
    	
    	$result = $this->admin_model->SP_MARKUP_BRIDGE_CREATE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    function POST_DESIGNATE_OMNI_VIEW($api=true) {
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    	
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	
    	$arrCompany = $this->admin_model->SP_OMNI_ACCOUNT_VIEW($params);
    	
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($arrCompany);
    		return;
    	}
    	return $arrCompany;
    }

    
    public function  POST_OMNI_ACCOUNT_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_tp'] = $this->input->post('i_tp');
    	$params['i_account'] = $this->input->post('i_account');
    	$params['i_account_name'] = $this->input->post('i_account_name');
    	$params['i_group_name'] = $this->input->post('i_group_name');
    	
    	$result = $this->admin_model->SP_OMNI_ACCOUNT_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    public function  POST_SETTLE_PRICE_VIEW($api = true) {
    
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_trade_dt'] = $this->input->post("i_trade_dt");
    
    	$arrManagerInfo = $this->admin_model->SP_SETTLE_PRICE_VIEW($params);
    
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['data']['last_num'] = 0;
    	$data['data']['recordsFiltered'] = count($arrManagerInfo);
    	$data['data']['recordsTotal'] = count($arrManagerInfo);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_SETTLE_PRICE_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_trade_dt'] = $this->input->post('i_trade_dt');
    	$params['i_symbol'] = $this->input->post('i_symbol');
    	$params['i_market_rate'] = $this->input->post('i_market_rate');
    	 
    	$result = $this->admin_model->SP_SETTLE_PRICE_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    public function  POST_AGENT_COMM_VIEW($api = true) {
    
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$arrManagerInfo = $this->admin_model->SP_AGENT_COMM_VIEW($params);
    
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = count($arrManagerInfo);
    	$data['data']['last_num'] = count($arrManagerInfo);
    	$data['data']['recordsFiltered'] = count($arrManagerInfo);
    	$data['data']['recordsTotal'] = count($arrManagerInfo);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_AGENT_COMM_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_group_idx'] = $this->input->post('i_group_idx');
    	$params['i_agent_comm'] = $this->input->post('i_agent_comm');
    	$params['i_spread_diff'] = $this->input->post('i_spread_diff');
    	$params['i_group_name'] = $this->input->post('i_group_name');
    	
    	$result = $this->admin_model->SP_AGENT_COMM_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    public function POST_IMPORT_SETTLE_PRICE_EXCEL($api=true) {
    	$logged_id = $this->getLoggedUserID();
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['file_path'] = $this->input->post('file_path');
    	$params['import_date'] = $this->input->post('import_date');
    	
    	$now = new DateTime();
    	$date = $now->format('Ymd');
    	
    	if($params['import_date'] != null && $params['import_date'] != "") {
    		$date = $params['import_date'];
    	}
    	
    	$data = $this->import_excel($params['file_path']);
    	
    	for($i = 0; $i < count($data['values']);$i++) {
    		$idx = ($i+2);
    		$row = $data['values'][$idx];
    		$params = Array();
    		$params['i_manager_id'] = $logged_id;
    		$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    		$params ['i_trade_dt'] = $date;
    		$params ['i_symbol'] = $row['A'];
    		$params ['i_market_rate'] = $row['B'];
    		
    		$this->admin_model->SP_SETTLE_PRICE_UPLOAD($params);
    	}
    	
    	if($api == true) {
    		$this->doRespondWithResult(VALUE_OK, $data);
    		return;
    	}
    	
    	return $data;
    }
    
    public function POST_IMPORT_MARKUP_BRIDGE_EXCEL($api=true) {
    	$logged_id = $this->getLoggedUserID();
    	 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['file_path'] = $this->input->post('file_path');
    	 
    	$data = $this->import_excel($params['file_path']);
    	 
    	for($i = 0; $i < count($data['values']);$i++) {
    		$idx = ($i+2);
    		$row = $data['values'][$idx];
    		$params = Array();
    		$params['i_manager_id'] = $logged_id;
    		$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    		$params ['i_symbol'] =  $row['A'];
    		$params ['i_markup_bid'] = $row['D'];
    		$params ['i_markup_ask'] = $row['E'];
    
    		$this->admin_model->SP_MARKUP_BRIDGE_UPLOAD($params);
    	}
    	 
    	if($api == true) {
    		$this->doRespondWithResult(VALUE_OK, $data);
    		return;
    	}
    	 
    	return $data;
    }
    
    public function POST_IMPORT_AGENT_COMM_EXCEL($api=true) {
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['file_path'] = $this->input->post('file_path');
    
    	$data = $this->import_excel($params['file_path']);
    
    	for($i = 0; $i < count($data['values']);$i++) {
    		$idx = ($i+2);
    		$row = $data['values'][$idx];
    		$params = Array();
    		$params['i_manager_id'] = $logged_id;
    		$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    		$params ['i_group_name'] =  $row['A'];
    		$params ['i_agent_comm'] = $row['C'];
    
    		$this->admin_model->SP_AGENT_COMM_UPLOAD($params);
    	}
    
    	if($api == true) {
    		$this->doRespondWithResult(VALUE_OK, $data);
    		return;
    	}
    
    	return $data;
    }
    
    public function  POST_LP_ACCOUNT_VIEW($api = true) {
    
    	$result = $this->getSesstionData();
    
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    
    	$arrManagerInfo = $this->admin_model->SP_LP_ACCOUNT_VIEW($params);
    
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = count($arrManagerInfo);
    	$data['data']['last_num'] = count($arrManagerInfo);
    	$data['data']['recordsFiltered'] = count($arrManagerInfo);
    	$data['data']['recordsTotal'] = count($arrManagerInfo);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  POST_LP_ACCOUNT_CREATE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_lp_account'] = $this->input->post('i_lp_account');
    	$params['i_lp_comments'] = $this->input->post('i_lp_comments');
    
    	$result = $this->admin_model->SP_LP_ACCOUNT_CREATE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_LP_ACCOUNT_MODIFY($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_lp_account'] = $this->input->post('i_lp_account');
    	$params['i_lp_comments'] = $this->input->post('i_lp_comments');
    
    	$result = $this->admin_model->SP_LP_ACCOUNT_MODIFY($params);
    
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
    	 
    	// Spread LP
    	$arr_string["configuration_spread_lp_title"]   = $this->lang->line("configuration_spread_lp_title");
    	$arr_string["configuration_spread_lp_explain"]   = $this->lang->line("configuration_spread_lp_explain");
    	$arr_string["configuration_spread_lp_fields"]= $this->lang->line("configuration_spread_lp_fields");
    	$arr_string["configuration_spread_lp_dlg_create_title"] = $this->lang->line("configuration_spread_lp_dlg_create_title");
    	
    	// Mark_bridge
    	$arr_string["configuration_markup_bridge_title"]   = $this->lang->line("configuration_markup_bridge_title");
    	$arr_string["configuration_markup_bridge_explain"]   = $this->lang->line("configuration_markup_bridge_explain");
    	$arr_string["configuration_markup_bridge_fields"]= $this->lang->line("configuration_markup_bridge_fields");
    	$arr_string["configuration_markup_bridge_other_fields"] = $this->lang->line("configuration_markup_bridge_other_fields");
    	$arr_string["configuration_markup_bridge_dlg_create_title"] = $this->lang->line("configuration_markup_bridge_dlg_create_title");
    	
    	// designate_omni
    	$arr_string["configuration_designate_omni_title"]   = $this->lang->line("configuration_designate_omni_title");
    	$arr_string["configuration_designate_omni_explain"]   = $this->lang->line("configuration_designate_omni_explain");
    	$arr_string["configuration_designate_omni_fields"]= $this->lang->line("configuration_designate_omni_fields");
    	$arr_string["configuration_designate_omni_dlg_create_title"] = $this->lang->line("configuration_designate_omni_dlg_create_title");
    	$arr_string["configuration_designate_omni_dlg_create_fields"] = $this->lang->line("configuration_designate_omni_dlg_create_fields");
    	
    	// settle_price
    	$arr_string["configuration_settle_price_title"]   = $this->lang->line("configuration_settle_price_title");
    	$arr_string["configuration_settle_price_explain"]   = $this->lang->line("configuration_settle_price_explain");
    	$arr_string["configuration_settle_price_fields"]= $this->lang->line("configuration_settle_price_fields");
    	$arr_string["configuration_settle_price_lp"] = $this->lang->line("configuration_settle_price_lp");
    	$arr_string["configuration_settle_price_date"] = $this->lang->line("configuration_settle_price_date");
    	
    	// agent_comm
    	$arr_string["configuration_agent_comm_title"]   = $this->lang->line("configuration_agent_comm_title");
    	$arr_string["configuration_agent_comm_explain"]   = $this->lang->line("configuration_agent_comm_explain");
    	$arr_string["configuration_agent_comm_fields"]= $this->lang->line("configuration_agent_comm_fields");
    	$arr_string["configuration_agent_comm_dlg_create_title"]= $this->lang->line("configuration_agent_comm_dlg_create_title");
    	$arr_string["configuration_agent_comm_dlg_update_title"]= $this->lang->line("configuration_agent_comm_dlg_update_title");
    	
    	// lp_account
    	$arr_string["configuration_lp_account_title"]   = $this->lang->line("configuration_lp_account_title");
    	$arr_string["configuration_lp_account_explain"]   = $this->lang->line("configuration_lp_account_explain");
    	$arr_string["configuration_lp_account_fields"]= $this->lang->line("configuration_lp_account_fields");
    	$arr_string["configuration_lp_account_dlg_create_title"]= $this->lang->line("configuration_lp_account_dlg_create_title");
    	$arr_string["configuration_lp_account_dlg_update_title"]= $this->lang->line("configuration_lp_account_dlg_update_title");
    	
    	return $arr_string;
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
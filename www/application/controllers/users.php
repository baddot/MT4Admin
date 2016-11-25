<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

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
    public function  user_info_view() {
    	
    	// load template
    	$data['main_content'] = 'admin/users/users.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
   		$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
  
    	$this->load->view('includes/template', $data);
    }
    
    public function  wl_info_view() {
    	// load template
    	$data['main_content'] = 'admin/users/103/103_wl_info_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	
    	$this->load->view('includes/template', $data);
    }
    
    public function  lp_info_view() {
    	// load template
    	$data['main_content'] = 'admin/users/104/104_lp_info_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	 
    	$this->load->view('includes/template', $data);
    }
    
    public function  ib_info_view() {
    	// load template
    	$data['main_content'] = 'admin/users/102/102_agent_info_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $this->getLoggedUserID();
    	$result = $this->getSesstionData();
    	$params['i_manager_level'] = $result['manager_level'];
    	$data['list_agent'] = $this->admin_model->SP_LIST_ACCOUNT($params);
    	$data['list_group'] = $this->admin_model->SP_LIST_GROUP($params);
    	
    	$this->load->view('includes/template', $data);
    }
    
    
    /*****************************************************
     * API 
     * $api : true이면 json데이터를  echo해준다.
     * $api : false이면 자료로 귀환
     * ***************************************************/
    public function  POST_USER_INFO_VIEW($api = true) {

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
  	    
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();

    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    	
    	$params['i_manager_id'] = $logged_id;
    	$params['i_basket_code'] = $basket_code;
    	$params['i_last_idx'] = $start;
    	$params['i_list_count'] = $list_cnt;
    	
    	$arrUserInfo = $this->admin_model->SP_USER_INFO_VIEW($params);
    	
    	for($i = 0; $i < count($arrUserInfo); $i++) {
    		$userInfo = $arrUserInfo[$i];
    		$userInfo['BALANCE'] = $this->util->getCommanMoney($userInfo['BALANCE']);
    		$userInfo['PREVBALANCE'] = $this->util->getCommanMoney($userInfo['PREVBALANCE']);
    		$userInfo['PREVMONTHBALANCE'] = $this->util->getCommanMoney($userInfo['PREVMONTHBALANCE']);
    		$userInfo['PASSWORD_PHONE'] = utf8_encode($userInfo['PASSWORD_PHONE']);
    		$userInfo['API_DATA'] = utf8_encode($userInfo['API_DATA']);
    		$arrUserInfo[$i] = $userInfo;
    	}
    	
    	$data['data']['data'] = $arrUserInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_USER_INFO_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_USER_INFO_VIEW_CNT(false);

    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}

    	return $data['data'];
    }
    
    
    public function  GET_USER_INFO_VIEW_CNT($api=true) {
    	
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
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    	
    	//
    	// get data from DB
    	//
    	$params['i_manager_id'] = $logged_id;
    	$params['i_basket_code'] = $basket_code;
    	$params['i_keyword'] = $keyword;
    	
    	$count = $this->admin_model->SP_USER_INFO_VIEW_CNT($params);
    	
    	//
    	// return data
    	// 
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public  function  GET_LIST_AGENT_BASKET($api=true) {
    	
    	$data = Array();
    	$logged_id = $this->getLoggedUserID();
    	
    	$account_id = $this->input->get('i_user_account');
    	
    	//
    	// get data from DB
    	// 
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_user_account'] = $account_id;
    	
    	
    	$data['list_basket'] = $this->admin_model->SP_LIST_BASKET($params);
    	$data['list_agent'] = $this->admin_model->SP_LIST_AGENT($params);
    	
    	if($api == true) {
    		$this->doRespond($data);
    		return;
    	}
    	
    	return $data;
    }
    
    public function  POST_UPDATE_USER_INFO_VIEW($api=true) {
   
    	$logged_id = $this->getLoggedUserID();
    	 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_account'] = $this->input->post('i_account');
    	$params['i_name'] = $this->input->post('i_name');
    	$params['i_leverage'] = $this->input->post('i_leverage');
    	$params['i_user_account'] = $this->input->post('i_user_account');
    	$params['i_group_name'] = $this->input->post('i_group_name');
    	$params['i_agent_account'] = $this->input->post('i_agent_account');
    	$params['i_status'] = $this->input->post('i_status');
    	$params['i_country'] = $this->input->post('i_country');
    	$params['i_city'] = $this->input->post('i_city');
    	$params['i_state'] = $this->input->post('i_state');
    	$params['i_zipcode'] = $this->input->post('i_zipcode');
    	$params['i_phone'] = $this->input->post('i_phone');
    	$params['i_email'] = $this->input->post('i_email');
    	 
    	$result = $this->admin_model->SP_USER_INFO_MODIFY($params);
    	 
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    	 
    	return $result;
    }
    
    
    public function  POST_WL_INFO_VIEW($api = true) {
    
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
    	 
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    	 
    	$params['i_manager_id'] = $logged_id;
    	$params['i_company_name'] = "";
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_last_idx'] = $start;
    	$params['i_list_count'] = $list_cnt;
    	 
    	$arrUserInfo = $this->admin_model->SP_WL_INFO_VIEW($params);
    	 
    	$data['data']['data'] = $arrUserInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_WL_INFO_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_WL_INFO_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_WL_INFO_VIEW_CNT($api=true) {
    	 
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
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    	 
    	//
    	// get data from DB
    	//
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_keyword'] = $keyword;
    	$params['i_company_name'] = "";
    	 
    	$count = $this->admin_model->SP_WL_INFO_VIEW_CNT($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
	    	$this->doRespond($count);
	    	return;
    	}
    	return $count;
    }
    
    
    public function  POST_UPDATE_WL_INFO_VIEW($api=true) {
    	 
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_company_name'] = $this->input->post('i_company_name');
    	$params['i_address'] = $this->input->post('i_address');
    	$params['i_phone'] = $this->input->post('i_phone');
    	$params['i_email'] = $this->input->post('i_email');
    	$params['i_enabled'] = $this->input->post('i_enabled');
    	$params['i_status'] = $this->input->post('i_status');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_omnibus_id'] = $this->input->post('i_omnibus_id');
    	 
    	$result = $this->admin_model->SP_WL_INFO_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    public function  POST_LP_INFO_VIEW($api = true) {
    
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
    
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_last_idx'] = $start;
    	$params['i_list_count'] = $list_cnt;
    
    	$arrUserInfo = $this->admin_model->SP_LP_INFO_VIEW($params);
    	 
    	for($i = 0; $i < count($arrUserInfo); $i++) {
    		$userInfo = $arrUserInfo[$i];
    		$userInfo['PHONE'] = $userInfo['PHONE1']."\n".$userInfo['PHONE2'];
    		$arrUserInfo[$i] = $userInfo;
    	}
    
    	$data['data']['data'] = $arrUserInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_LP_INFO_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_LP_INFO_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_LP_INFO_VIEW_CNT($api=true) {
    
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
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_keyword'] = $keyword;
    
    	$count = $this->admin_model->SP_LP_INFO_VIEW_CNT($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  POST_UPDATE_LP_INFO_VIEW($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_id'] = $this->input->post('i_lp_id');
    	$params['i_lp_name'] = $this->input->post('i_lp_name');
    	$params['i_enabled'] = $this->input->post('i_enabled');
    	$params['i_email'] = $this->input->post('i_email');
    	$params['i_phone1'] = $this->input->post('i_phone1');
    	$params['i_phone2'] = $this->input->post('i_phone2');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_addr'] = $this->input->post('i_addr');
    
    	$result = $this->admin_model->SP_LP_INFO_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_CREATE_LP_INFO_VIEW($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_lp_name'] = $this->input->post('i_lp_name');
    	$params['i_enabled'] = $this->input->post('i_enabled');
    	$params['i_email'] = $this->input->post('i_email');
    	$params['i_phone1'] = $this->input->post('i_phone1');
    	$params['i_phone2'] = $this->input->post('i_phone2');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_addr'] = $this->input->post('i_addr');
    
    	$result = $this->admin_model->SP_LP_INFO_CREATE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    public function  POST_AGENT_INFO_VIEW($api = true) {
    
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
    
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_keyword'] = $keyword;
    
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_last_idx'] = $start;
    	$params['i_list_count'] = $list_cnt;
    
    	$arrUserInfo = $this->admin_model->SP_AGENT_INFO_VIEW($params);
    
    	for($i = 0; $i < count($arrUserInfo); $i++) {
    		$userInfo = $arrUserInfo[$i];
    		//$userInfo['PHONE'] = $userInfo['PHONE1']."\n".$userInfo['PHONE2'];
    		$arrUserInfo[$i] = $userInfo;
    	}
    
    	$data['data']['data'] = $arrUserInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_AGENT_INFO_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_AGENT_INFO_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_AGENT_INFO_VIEW_CNT($api=true) {
    
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
    	$basket_code = 0;
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_keyword'] = $keyword;
    
    	$count = $this->admin_model->SP_AGENT_INFO_VIEW_CNT($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  POST_UPDATE_AGENT_INFO_VIEW($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_agent_account'] = $this->input->post('i_agent_account');
    	$params['i_agent_group'] = $this->input->post('i_agent_group');
    	$params['i_comm_tp'] = $this->input->post('i_comm_tp');
    	$params['i_agent_company'] = $this->input->post('i_agent_company');
    	$params['i_upper_agent'] = $this->input->post('i_upper_agent');
    	$params['i_hierarchy'] = $this->input->post('i_hierarchy');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_comm_value'] = $this->input->post('i_comm_value');
    	$params['i_enable'] = $this->input->post('i_enable');
    
    	$result = $this->admin_model->SP_AGENT_INFO_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_CREATE_AGENT_INFO_VIEW($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_agent_account'] = $this->input->post('i_agent_account');
    	$params['i_agent_group'] = $this->input->post('i_agent_group');
    	$params['i_comm_tp'] = $this->input->post('i_comm_tp');
    	$params['i_agent_company'] = $this->input->post('i_agent_company');
    	$params['i_upper_agent'] = $this->input->post('i_upper_agent');
    	$params['i_hierarchy'] = $this->input->post('i_hierarchy');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_comm_value'] = $this->input->post('i_comm_value');
    	$params['i_enable'] = $this->input->post('i_enable');
    
    	$result = $this->admin_model->SP_AGENT_INFO_CREATE($params);
    
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
    	
    	// 유저관리
    	$arr_string["users_userinfo_title"]   = $this->lang->line("users_userinfo_title");
    	$arr_string["users_userinfo_explain"] = $this->lang->line("users_userinfo_explain");
    	$arr_string["users_userinfo_search"] = $this->lang->line("users_userinfo_search");
    	$arr_string["users_userinfo_basket"] = $this->lang->line("users_userinfo_basket");
    	$arr_string["users_userinfo_fields"] = $this->lang->line("users_userinfo_fields");
    	$arr_string["users_userinfo_change"] = $this->lang->line("users_userinfo_change");
    	$arr_string["btn_title_cancel"] = $this->lang->line("btn_title_cancel");
    	$arr_string["btn_title_modify"] = $this->lang->line("btn_title_modify");
    	
    	// 유저정보변경 다이얼로그
    	$arr_string["users_dlg_change_title"] = $this->lang->line("users_dlg_change_title");
    	$arr_string["users_dlg_change_account"] = $this->lang->line("users_dlg_change_account");
    	$arr_string["users_dlg_change_name"] = $this->lang->line("users_dlg_change_name");
    	$arr_string["users_dlg_change_leverage"] = $this->lang->line("users_dlg_change_leverage");
    	$arr_string["users_dlg_change_group"] = $this->lang->line("users_dlg_change_group");
    	$arr_string["users_dlg_change_agentaccount"] = $this->lang->line("users_dlg_change_agentaccount");
    	$arr_string["users_dlg_change_status"] = $this->lang->line("users_dlg_change_status");
    	$arr_string["users_dlg_change_basket"] = $this->lang->line("users_dlg_change_basket");
    	$arr_string["users_dlg_change_country"] = $this->lang->line("users_dlg_change_country");
    	$arr_string["users_dlg_change_city"] = $this->lang->line("users_dlg_change_city");
    	$arr_string["users_dlg_change_state"] = $this->lang->line("users_dlg_change_state");
    	$arr_string["users_dlg_change_zipcode"] = $this->lang->line("users_dlg_change_zipcode");
    	$arr_string["users_dlg_change_phone"] = $this->lang->line("users_dlg_change_phone");
    	$arr_string["users_dlg_change_email"] = $this->lang->line("users_dlg_change_email");
    	
    	// W/L 관리
    	$arr_string["wl_info_title"]   = $this->lang->line("wl_info_title");
    	$arr_string["wl_info_explain"] = $this->lang->line("wl_info_explain");
    	$arr_string["wl_info_fields"] = $this->lang->line("wl_info_fields");
    	$arr_string["wl_dlg_change_title"] = $this->lang->line("wl_dlg_change_title");
    	
    	// W/L 관리
    	$arr_string["lp_info_title"]   = $this->lang->line("lp_info_title");
    	$arr_string["lp_info_explain"] = $this->lang->line("lp_info_explain");
    	$arr_string["lp_info_fields"] = $this->lang->line("lp_info_fields");
    	$arr_string["lp_dlg_change_title"] = $this->lang->line("lp_dlg_change_title");
    	$arr_string["lp_dlg_create_title"] = $this->lang->line("lp_dlg_create_title");
    	
    	// ib 관리
    	$arr_string["ib_info_title"]   = $this->lang->line("ib_info_title");
    	$arr_string["ib_info_explain"] = $this->lang->line("ib_info_explain");
    	$arr_string["ib_info_fields"] = $this->lang->line("ib_info_fields");
    	$arr_string["ib_dlg_change_title"] = $this->lang->line("ib_dlg_change_title");
    	$arr_string["ib_dlg_create_title"] = $this->lang->line("ib_dlg_create_title");
    	$arr_string["ib_dlg_fields"] = $this->lang->line("ib_dlg_fields");
    	
    	return $arr_string;
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
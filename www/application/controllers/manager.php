<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends MY_Controller {

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
    public function  manager_info_view() {
    	
    	// load template
    	$data['main_content'] = 'admin/manager/manager.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
   		$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
  		$data['list_company'] = $this->GET_LIST_COMPANY(false);
  		
  		$this->load->view('includes/template', $data);
    }
    
    
    public function  managers_basket_group() {
    	// load template
    	$data['main_content'] = 'admin/manager/501/501_managers_basket_group_view.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['list_group'] = $this->GET_LIST_GROUP(false);
    	$this->load->view('includes/template', $data);
    }
    
    public function  managers_basket_alloc_view() {
    	// load template
    	$data['main_content'] = 'admin/manager/501/501_managers_basket_alloc.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['list_group'] = $this->GET_LIST_GROUP(false);
    	$this->load->view('includes/template', $data);
    }
    
    public function trac_manager_view() {
    	// load template
    	$data['main_content'] = 'admin/manager/503/503_trace_manager.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$data['list_company'] = $this->GET_LIST_COMPANY(false);
    	$data['list_manager'] = $this->GET_LIST_MANAGER(false);
    	$this->load->view('includes/template', $data);
    }
    
    public function freemargin_warning_view() {
    	// load template
    	$data['main_content'] = 'admin/manager/504/504_freemargin_warning.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	$list_cnfg = $this->POST_CNFG_VIEW(false);
    	if(count($list_cnfg['data']) > 0) {
    		$data['cnfg'] = $list_cnfg['data'][0];
    	}
    	else {
    		$data['cnfg'] = Array("CNFG_NAME"=>"","CNFG_VALUE"=>0 );
    	}
    	$this->load->view('includes/template', $data);
    }
    
    /*****************************************************
     * API
     * $api : true이면 json데이터를  echo해준다.
     * $api : false이면 자료로 귀환
     * ***************************************************/
 	public  function  POST_MANAGER_LOGIN($api=true) {
    	
    	$data = Array();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_id'] =  $this->input->post('i_id');
    	$params['i_pwd'] =  $this->input->post('i_pwd');
    	$params['i_save_data'] =  $this->input->post('i_save_data');
    	
    	$result = $this->admin_model->SP_MANAGER_LOGIN($params);
    	$newdata = Array();
    	if($result['RESULT'] == VALUE_OK) {
    		
    		// save session data
    		$newdata['manager_id'] = $params['i_id'];
    		$newdata['manager_name'] = $result['MANAGER_NAME'];
    		$newdata['company_name'] = $result['COMPANY_NAME'];
    		$newdata['manager_level'] = $result['LEVEL'];
    		$newdata['manager_pwd'] = $params['i_pwd'];
    		
    		$this->session->set_userdata($newdata);
    	}
    	else {
    		$newdata = null;
    	}
    	
    	if($api == true) {
    		$this->doRespondWithResult($result['RESULT'], $newdata);
    		return;
    	}
    	
    	return $result;
    }
    
 	public function  POST_MANAGER_INFO_VIEW($api = true) {
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
  	    
    	$company_name = $this->input->post("i_company_name");
    	
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
    	$params['i_last_idx'] = $start;
    	$params['i_company_name'] = $company_name;
    	$params['i_list_count'] = $list_cnt;
    	
    	$arrManagerInfo = $this->admin_model->SP_MANAGER_INFO_VIEW($params);
    	
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_MANAGER_INFO_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_MANAGER_INFO_VIEW_CNT(false);

    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}

    	return $data['data'];
    }
    
    
    public function  GET_MANAGER_INFO_VIEW_CNT($api=true) {
    	 
    	//
    	// get parameters from requests.
    	//
    	$result = $this->getSesstionData();
    	
    	$logged_id = $result['manager_id'];
    	$level = $result['manager_level'];
    	$company_name = $result['company_name'];
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_company_name'] = $company_name;
    	
    	$count = $this->admin_model->SP_MANAGER_INFO_VIEW_CNT($params);
    	
    	//
    	// return data
    	// 
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    public function  GET_LIST_COMPANY($api=true) {
    
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
    	
    	$arrCompany = $this->admin_model->SP_LIST_COMPANY($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
	    	$this->doRespond($arrCompany);
	    	return;
    	}
    	return $arrCompany;
    }
    
    
    public function  GET_LIST_MANAGER($api=true) {
    
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
    	
    	/*
    	$list_cnt = $this->input->post("length");
    	if($list_cnt == null) {
    		$list_cnt = ADMIN_DEFAULT_LIST_CNT;
    	}
    	*/
    	
    	$params = Array();
    	
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_target_company_name'] = '';
    	//$params['i_list_count'] = $list_cnt;
    	
    	
    	$arrManager = $this->admin_model->SP_LIST_MANAGER($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
	    	$this->doRespond($arrManager);
	    	return;
    	}
    	return $arrManager;
    }
    	
    public function  POST_SAVE_TRACE($api=true) {
    	 
    	$logged_id = $this->getLoggedUserID();
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_module_name'] = $this->input->post('i_module_name');
    	$params['i_job_title'] = $this->input->post('i_job_title');
    	$params['i_job_detail'] = $this->input->post('i_job_detail');
    	
    	$result = $this->admin_model->SP_MANAGER_TRACE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_MANAGER_MODIFY($api=true) {
    	 
    	$logged_id = $this->getLoggedUserID();
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_target_manager_id'] = $this->input->post('i_target_manager_id');
    	$params['i_target_manager_name'] = $this->input->post('i_target_manager_name');
    	$params['i_target_manager_pwd'] = $this->input->post('i_target_manager_pwd');
    	$params['i_target_company_name'] = $this->input->post('i_target_company_name');
    	$params['i_target_comment'] = $this->input->post('i_target_comment');
    
    	$result = $this->admin_model->SP_MANAGER_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_MANAGER_CREATE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();

    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_new_manager_id'] = $this->input->post('i_new_manager_id');
    	$params['i_new_manager_pwd'] = $this->input->post('i_new_manager_pwd');
    	$params['i_new_company_name'] = $this->input->post('i_new_company_name');
    	$params['i_new_manager_name'] = $this->input->post('i_new_manager_name');
    	$params['i_new_comments'] = $this->input->post('i_new_comments');
    
    	$result = $this->admin_model->SP_MANAGER_CREATE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_MANAGERS_BASKET_VIEW($api = true) {
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
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_last_idx'] = $start;
    	$params['i_list_count'] = $list_cnt;
    	 
    	$arrManagerInfo = $this->admin_model->SP_MANAGERS_BASKET_VIEW($params);
    	 
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_MANAGERS_BASKET_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_MANAGERS_BASKET_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    public function  GET_MANAGERS_BASKET_VIEW_CNT($api=true) {
    
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
    	$params['i_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	 
    	$count = $this->admin_model->SP_MANAGERS_BASKET_VIEW_CNT($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
   
    
    
    public function  POST_MANAGERS_BASKET_MODIFY($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    	 
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_basket_manager'] = $logged_id;// $this->input->post('i_basket_manager');
    	$params['i_basket_code'] = $this->input->post('i_basket_code');
    	$params['i_basket_nm'] = $this->input->post('i_basket_nm');
    	$params['i_comment'] = $this->input->post('i_comment');
    	$params['i_tp'] = $this->input->post('i_tp');
    
    	$result = $this->admin_model->SP_MANAGERS_BASKET_MODIFY($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_MANAGERS_BASKET_CREATE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_basket_manager'] = $logged_id;// $this->input->post('i_basket_manager');
    	$params['i_basket_nm'] = $this->input->post('i_basket_nm');
    	$params['i_comment'] = $this->input->post('i_comment');
    
    	$result = $this->admin_model->SP_MANAGERS_BASKET_CREATE($params);
    
        if($api == true) {
        	$this->doRespondWithResult($result);
   			return;
    	}
    
   		return $result;
    }
    
    
    public function  POST_MANAGERS_BASKET_ALLOC($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_basket_manager'] = $logged_id;// $this->input->post('i_basket_manager');
    	$params['i_basket_code'] = $this->input->post('i_basket_code');
    	$params['i_user_account'] = $this->input->post('i_user_account');
    
    	$result = $this->admin_model->SP_MANAGERS_BASKET_ALLOC_USER($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    
    /*****************************************************
     * API
     * $api : true이면 json데이터를  echo해준다.
     * $api : false이면 자료로 귀환
     * ***************************************************/
    public function  POST_MANAGERS_BASKET_ALLOC_VIEW($api = true) {
    
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
    		$userInfo['ARR_BASKET'] = $this->GET_LIST_AGENT_BASKET($userInfo['LOGIN']);
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
    
    
    private  function  GET_LIST_AGENT_BASKET($user_account) {
     
	    $data = Array();
	    $logged_id = $this->getLoggedUserID();
	     
	    $account_id = $user_account;
	     
	    //
	    // get data from DB
	    //
	    $params = Array();
	    $params['i_manager_id'] = $logged_id;
	    $params['i_user_account'] = $account_id;
	     
	     
	    $data = $this->admin_model->SP_LIST_BASKET($params);
     
  		 return $data;
    }
    
    
    public function  POST_TRAC_MANAGER_VIEW($api = true) {
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
    	
    	
		$from_dt = $this->input->post("i_from_dt");
		$to_dt = $this->input->post("i_to_dt");
		$target_manager_id = $this->input->post("i_target_manager_id");
		$target_company_name = $this->input->post("i_target_company_name");
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $level;
    	$params['i_target_manager_id'] = $target_manager_id;
    	$params['i_from_dt'] = $from_dt;
    	$params['i_to_dt'] = $to_dt;
    	$params['i_keyword'] = $keyword;
    	$params['i_list_count'] = $list_cnt;
    	$params['i_last_idx'] = $start;
    	$params['i_target_company_name'] = $target_company_name;
    	 
    	$arrManagerInfo = $this->admin_model->SP_MANAGER_TRACE_VIEW($params);
    	 
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->admin_model->SP_MANAGER_TRACE_VIEW_CNT($params);
    	$data['data']['recordsTotal'] = $this->admin_model->SP_MANAGER_TRACE_VIEW_CNT($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_LIST_GROUP($api=true) {
    
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
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	 
    	$arrCompany = $this->admin_model->SP_LIST_GROUP($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($arrCompany);
    		return;
    	}
    	return $arrCompany;
    }
    
    public function  GET_LIST_GROUP_IN_BASKET($api=true) {
    
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
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_basket_code'] = $this->input->get('i_basket_code');
    
    	$arrCompany = $this->admin_model->SP_LIST_GROUP_IN_BASKET($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($arrCompany);
    		return;
    	}
    	return $arrCompany;
    }
    
    
    public function  POST_MANAGERS_BAKET_GROUP_ALLOC($api=true) {
    
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
    	$params['i_manager_level'] = $level;
    	$params['i_manager_id'] = $logged_id;
    	$params['i_basket_code'] = $this->input->post('i_basket_code');
    	$params['i_way'] = $this->input->post('i_way');
    	$params['i_group_name'] = $this->input->post('i_group_name');
    
    	$result = $this->admin_model->SP_MANAGERS_BAKET_GROUP_ALLOC($params);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $arrCompany;
    }
    
    public function  POST_CNFG_VIEW($api=true) {
    
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
    	$params['i_cnfg_id'] = 'FREE_MARGIN_LIMIT';
    	
    	$arrData = $this->admin_model->SP_CNFG_VIEW($params);
    
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
    
    public function  POST_CNFG_SAVE($api=true) {
    
    	$logged_id = $this->getLoggedUserID();
    
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $logged_id;
    	$params['i_manager_level'] = $this->getSesstionData()['manager_level'];
    	$params['i_cnfg_id'] = 'FREE_MARGIN_LIMIT';
    	$params['i_cnfg_value'] = $this->input->post('i_cnfg_value');
    	
    	$result = $this->admin_model->SP_CNFG_SAVE($params);
    
    	if($api == true) {
    		$this->doRespondWithResult($result);
    		return;
    	}
    
    	return $result;
    }
    
    public function  POST_FREEMARGIN_WARNING_VIEW($api=true) {
    
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
    
    	$arrData = $this->admin_model->SP_FREEMARGIN_WARNING_VIEW($params);
    
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
    
    /*****************************************************
     * other functions
     * ***************************************************/
    final function getUIStringArray() {
    	$arr_string = parent::getUIStringArray();
    	 
    	// 매니저관리 (management manager)
    	$arr_string["manager_info_title"]   = $this->lang->line("manager_info_title");
    	$arr_string["manager_info_explain"] = $this->lang->line("manager_info_explain");
    	$arr_string["users_userinfo_search"] = $this->lang->line("users_userinfo_search");
    	$arr_string["manager_info_companyname"] = $this->lang->line("manager_info_companyname");
    	$arr_string["manager_info_managername"] = $this->lang->line("manager_info_managername");
    	$arr_string["manager_info_fields"] = $this->lang->line("manager_info_fields");
    	$arr_string["manager_trace_fields"] = $this->lang->line("manager_trace_fields");
    	$arr_string["btn_title_cancel"] = $this->lang->line("btn_title_cancel");
    	$arr_string["btn_title_modify"] = $this->lang->line("btn_title_modify");
    	$arr_string["btn_title_update"] = $this->lang->line("btn_title_update");
    	 
    	// 매니저다이얼로그 (manager dialogue)
    	$arr_string["manager_dlg_change_title"] = $this->lang->line("manager_dlg_change_title");
    	$arr_string["manager_dlg_create_title"] = $this->lang->line("manager_dlg_create_title");
    	$arr_string["manager_dlg_managerid"] = $this->lang->line("manager_dlg_managerid");
    	$arr_string["manager_dlg_name"] = $this->lang->line("manager_dlg_name");
    	$arr_string["manager_dlg_password"] = $this->lang->line("manager_dlg_password");
    	$arr_string["manager_dlg_comments"] = $this->lang->line("manager_dlg_comments");
    	$arr_string["manager_dlg_companyname"] = $this->lang->line("manager_dlg_companyname");
    	
    	// 매니저바스키트 (manager basket)
    	$arr_string["managers_basket_group_title"] = $this->lang->line("managers_basket_group_title");
    	$arr_string["managers_basket_group_explain"] = $this->lang->line("managers_basket_group_explain");
    	$arr_string["managers_basket_group_fields"] = $this->lang->line("managers_basket_group_fields");
    	$arr_string["managers_basket_dlg_change_title"] = $this->lang->line("managers_basket_dlg_change_title");
    	$arr_string["managers_basket_dlg_create_title"] = $this->lang->line("managers_basket_dlg_create_title");
    	$arr_string["managers_basket_alloc_user_title"] = $this->lang->line("managers_basket_alloc_user_title");
    	$arr_string["managers_basket_alloc_user_explain"] = $this->lang->line("managers_basket_alloc_user_explain");
    	$arr_string["managers_basket_alloc_user_fields"] = $this->lang->line("managers_basket_alloc_user_fields");
    	$arr_string["managers_basket_group_btn_alloc"] = $this->lang->line("managers_basket_group_btn_alloc");
    	$arr_string["managers_basket_dlg_alloc_title"] = $this->lang->line("managers_basket_dlg_alloc_title");
    	$arr_string["managers_basket_group_list"] = $this->lang->line("managers_basket_group_list");
    	$arr_string["managers_basket_group_basket_list"] = $this->lang->line("managers_basket_group_basket_list");
    	
    	$arr_string["manager_freemargin_warning_title"] = $this->lang->line("manager_freemargin_warning_title");
    	$arr_string["manager_freemargin_warning_explain"] = $this->lang->line("manager_freemargin_warning_explain");
    	$arr_string["manager_freemargin_warning_fields"] = $this->lang->line("manager_freemargin_warning_fields");
    	$arr_string["manager_freemargin_warning_cf"] = $this->lang->line("manager_freemargin_warning_cf");
    	
    	return $arr_string;
    }
}

/* End of file Manager.php */
/* Location: ./application/controllers/Manager.php */
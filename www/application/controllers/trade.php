<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trade extends MY_Controller {

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
    
    public  function  trade_report_view(){
    	// load template
    	$data['main_content'] = 'admin/trade/304/304_trade_report.php';
    	$data['arr_ui_string'] = $this->getUIStringArray();
    	$data['page_length'] = ADMIN_DEFAULT_LIST_CNT;
    	
    	//
    	// get data from DB
    	//
    	$params = Array();
    	$params['i_manager_id'] = $this->getLoggedUserID();
    	$result = $this->getSesstionData();
    	$params['i_manager_level'] = $result['manager_level'];
    	$data['list_account'] = $this->admin_model->SP_LIST_ACCOUNT($params);
    	
    	$this->load->view('includes/template', $data);
    }
    
    
    
    /*****************************************************
     * API
     * ***************************************************/
    public function  POST_TRADE_REPORT_VIEW($api = true) {
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
    	$params['i_account'] = $this->input->post("i_account");
    	$params['i_from'] = $this->input->post("i_from");
    	$params['i_to'] = $this->input->post("i_to");
    	$params['i_list_count'] = $list_cnt;
    	 
    	$arrManagerInfo = $this->admin_model->SP_TRADE_REPORT_VIEW($params);
    	 
    	$data['data']['data'] = $arrManagerInfo;
    	$data['data']['list_cnt_per_page'] = $list_cnt;
    	$data['data']['last_num'] = $last_num;
    	$data['data']['recordsFiltered'] = $this->GET_TRADE_REPORT_VIEW_CNT(false);
    	$data['data']['recordsTotal'] = $this->GET_TRADE_REPORT_VIEW_CNT(false);
    
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($data['data']);
    		return;
    	}
    
    	return $data['data'];
    }
    
    
    public function  GET_TRADE_REPORT_VIEW_CNT($api=true) {
    
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
    	$params['i_account'] = $this->input->post("i_account");
    	$params['i_from'] = $this->input->post("i_from");
    	$params['i_to'] = $this->input->post("i_to");
    	 
    	$count = $this->admin_model->SP_TRADE_REPORT_VIEW_CNT($params);
    	 
    	//
    	// return data
    	//
    	if($api == true) {
    		$this->doRespond($count);
    		return;
    	}
    	return $count;
    }
    
    
    /*****************************************************
     * other functions
     * ***************************************************/
    final function getUIStringArray() {
    	$arr_string = parent::getUIStringArray();
    	 
    	// comm_settle_view
    	$arr_string["trade_report_title"]   = $this->lang->line("trade_report_title");
    	$arr_string["trade_report_explain"]   = $this->lang->line("trade_report_explain");
    	$arr_string["trade_report_fields"]= $this->lang->line("trade_report_fields");
    	$arr_string["trade_report_search_fields"] = $this->lang->line("trade_report_search_fields");
    	
    	return $arr_string;
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
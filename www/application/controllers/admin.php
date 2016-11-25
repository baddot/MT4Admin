<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

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
	public function index()
	{
		$logged_id = $this->getLoggedUserID();
		$this->clearSesstionData();
		$data['arr_ui_string'] = $this->getUIStringArray() ;
		$this->load->view('admin/manager/901/901_login.php', $data);
    }
    
    public  function  main(){
    	$logged_id = $this->getLoggedUserID();
    	
    	if($logged_id == null) {
    		$logged_id = $this->input->get('manager_id');
    	}
    	 
    	$data['arr_ui_string'] = $this->getUIStringArray() ;
    	if($logged_id == null) {
    		$this->load->view('admin/manager/901/901_login.php', $data);
    	}
    	else {
    		$data['main_content'] = 'admin/admin';
    		$data['arr_ui_string'] = $this->getUIStringArray() ;
    		$this->load->view('includes/template', $data);
    	}
    }
    
    public function test() {
    	$this->load->view('style/bootstrapdialog.html');
    }
    
    /*****************************************************
     * other functions
     * ***************************************************/
    final function getUIStringArray() {
    	$arr_string = parent::getUIStringArray();
    	 
    	// 로그인창
    	$arr_string["login_id"]   = $this->lang->line("login_id");
    	$arr_string["login_passwd"]   = $this->lang->line("login_passwd");
    	$arr_string["login_title"]= $this->lang->line("login_title");
    	$arr_string["msg_fail_login_idpwd"] = $this->lang->line("msg_fail_login_idpwd");
    	$arr_string["msg_input_idpwd"] = $this->lang->line("msg_input_idpwd");
    	return $arr_string;
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
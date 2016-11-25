<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        // Call the Model constructor
        parent::__construct ();

        if(ADMIN_DEBUG_MODE) {
        	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        }
        
        $this->load->database ();
      	$this->lang->load('admin');
        
      	$this->load->library('session');
        $this->load->model ( 'admin_model');
        $this->load->library('util');
        
        date_default_timezone_set('Asia/Seoul');
    }
    
    protected function doRespond($p_result)
    {
    	$this->output->set_content_type('application/json')->set_output(json_encode($p_result));
    }
    
    protected function  doRespondWithResult($p_result, $p_data=null) {
    	
    	$data = Array();
    	if($p_result != null) {
    		$data['result_code'] = $p_result;
    	}
    	
    	if($p_data != null) {
    		$data['result_data'] = $p_data;
    	}
    	
    	$this->output->set_content_type('application/json')->set_output(json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    }
    
    protected function  getUIStringArray() {
    	$lang = Array();
    	
    	// 타이틀
    	$lang["admin_title"] = $this->lang->line("admin_title");
    	
    	// 기본메뉴타이틀
    	$lang["menu_user"] = $this->lang->line("menu_user");
    	$lang["menu_statement"] = $this->lang->line("menu_statement");
    	$lang["menu_trade"] = $this->lang->line("menu_trade");
    	$lang["menu_manager"] = $this->lang->line("menu_manager");
    	$lang["menu_config"] = $this->lang->line("menu_config");
    	$lang["menu_notify"] = $this->lang->line("menu_notify");
    	
    	// 보조메뉴타이틀
    	$lang["menu_user_info"] = $this->lang->line("menu_user_info");
    	$lang["menu_manager_info"] = $this->lang->line("menu_manager_info");
    	$lang["menu_manager_basket"] = $this->lang->line("menu_manager_basket");
    	$lang["menu_manager_trac"] = $this->lang->line("menu_manager_trac");
    	$lang["menu_managers_basket_group"] = $this->lang->line("menu_managers_basket_group");
    	$lang["menu_managers_basket_alloc"] = $this->lang->line("menu_managers_basket_alloc");
    	$lang["menu_manager_freemargin_warning"] = $this->lang->line("menu_manager_freemargin_warning");
    	
    	$lang["menu_wl_info"] = $this->lang->line("menu_wl_info");
    	$lang["menu_lp_info"] = $this->lang->line("menu_lp_info");
    	$lang["menu_ib_info"] = $this->lang->line("menu_ib_info");
    	
    	$lang["menu_config_spread_lp"] = $this->lang->line("menu_config_spread_lp");
    	$lang["menu_config_designate_omni"] = $this->lang->line("menu_config_designate_omni");
    	$lang["menu_config_markup_bridge"] = $this->lang->line("menu_config_markup_bridge");
    	$lang["menu_config_agent_comm"] = $this->lang->line("menu_config_agent_comm");
    	$lang["menu_config_lp_account"] = $this->lang->line("menu_config_lp_account");
    	
    	$lang["menu_comm_settle_view"] = $this->lang->line("menu_comm_settle_view");
    	$lang["menu_statement_compare_order"] = $this->lang->line("menu_statement_compare_order");
    	$lang["menu_statement_settle_summary"] = $this->lang->line("menu_statement_settle_summary");
    	$lang["menu_statement_closed_orders"] = $this->lang->line("menu_statement_closed_orders");
    	$lang["menu_statement_opend_orders"] = $this->lang->line("menu_statement_opend_orders");
    	$lang["menu_statement_equip_view"] = $this->lang->line("menu_statement_equip_view");
    	
    	$lang["menu_trade_report_view"] = $this->lang->line("menu_trade_report_view");
    	
    	$lang["menu_config_settle_price"] = $this->lang->line("menu_config_settle_price");

    	// 바톤들
    	$lang["btn_title_prev"] = $this->lang->line("btn_title_prev");
    	$lang["btn_title_next"] = $this->lang->line("btn_title_next");
    	$lang["btn_select_all"] = $this->lang->line("btn_select_all");
    	$lang["btn_title_create"] = $this->lang->line("btn_title_create");
    	$lang["btn_title_cancel"] = $this->lang->line("btn_title_cancel");
    	$lang["btn_title_delete"] = $this->lang->line("btn_title_delete");
    	$lang["btn_title_register"] = $this->lang->line("btn_title_register");
    	$lang["btn_title_update"] = $this->lang->line("btn_title_update");
    	$lang["btn_title_search"] = $this->lang->line("btn_title_search");
    	$lang["btn_title_save"] = $this->lang->line("btn_title_save");
    	$lang["btn_title_export"] = $this->lang->line("btn_title_export");
    	$lang["btn_title_import"] = $this->lang->line("btn_title_import");
    	$lang["btn_title_download_import_template"] = $this->lang->line("btn_title_download_import_template");
    	
    	// notify
    	$lang["msg_fail_network"] = $this->lang->line("msg_fail_network");
    	$lang["msg_err_array"] = $this->lang->line("msg_err_array");
    	$lang["msg_export_ok"] = $this->lang->line("msg_export_ok");
    	$lang["msg_import_ok"] = $this->lang->line("msg_import_ok");
    	$lang["msg_save_ok"] = $this->lang->line("msg_save_ok");
    	
    	return $lang; 
    }
    
    protected function  getSesstionData() {
    	$result = Array();
    
    	$result['manager_id'] = $this->session->userdata('manager_id');
    	$result['manager_pwd'] = $this->session->userdata('manager_pwd');
    	$result['manager_name'] = $this->session->userdata('manager_name');
    	$result['company_name'] = $this->session->userdata('company_name');
    	$result['manager_level'] = $this->session->userdata('manager_level');
    	
    	return $result;
    }
    
    protected function  clearSesstionData() {
    	$this->session->sess_destroy();
    }
    
    protected  function getLoggedUserID() {
    	$sesstion_data = $this->getSesstionData();
    	return $sesstion_data['manager_id'];
    }
    
    
    protected function export_excel($file_name, $sheet_name, $field_array, $data) {
    
    	//load our new PHPExcel library
    	$this->load->library('excel');
    	 
    	//activate worksheet number 1
    	$this->excel->setActiveSheetIndex(0);
    	 
    	//name the worksheet
    	$this->excel->getActiveSheet()->setTitle($sheet_name);
    	 
    	$row_idx = 1;
    	$col_idx = 1;
    	 
    	$arr_alpha = Array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    	for($i = 0; $i < count($field_array); $i++) {
    		$this->excel->getActiveSheet()->setCellValue($arr_alpha[$col_idx-1] . ($row_idx), $field_array[$i]);
    		$col_idx++;
    	}
    	 
    	$row_idx++;
    	for($i = 0; $i < count($data);$i++) {
    		$row = $data[$i];
    		$keys = array_keys($row);
    		$col_idx = 1;
    
    		for($j = 0; $j < count($field_array); $j++) {
    			$this->excel->getActiveSheet()->setCellValue($arr_alpha[$col_idx-1].($row_idx), $row[$field_array[$j]]);
    			$col_idx++;
    		}
    
    		$row_idx++;
    	}
    
    	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    	//if you want to save it as .XLSX Excel 2007 format
    	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
    
    	//force user to download the Excel file without writing it to server's HD
    	$file_path = 'outputs/'.$this->util->getMilliTime() . "_" .$file_name.'.xlsx';
    	$objWriter->save($file_path);
    	return $file_path;
    }
    
    protected function  import_excel($file_path) {
    	//load the excel library
		$this->load->library('excel');
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file_path);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
		    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		    //header will/should be in row 1 only. of course this can be modified to suit your need.
		    if ($row == 1) {
		        $header[$row][$column] = $data_value;
		    } else {
		        $arr_data[$row][$column] = $data_value;
		    }
		}
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;

		return $data;
    }
    
    
    private function do_upload($file_name)
    {
    	$config['upload_path'] = './uploads/';
    	$config['allowed_types'] = '*';
    	$config['max_size']	= '10000KB';
    	$config['file_name'] = $this->util->getMilliTime() . "_" . $file_name;
    	$config['upload_url']=  base_url () ."uploads/";
    
    	$this->load->library('upload', $config);
    
    	if ( ! $this->upload->do_upload($file_name))
    	{
    		$error = array('error' => $this->upload->display_errors());
    		echo json_encode($error);
    		return null;
    	}
    	else
    	{
    		$data = array('upload_data' => $this->upload->data());
    		$imageURL = $config ['upload_url'] . $this->upload->file_name;
    		return $imageURL;
    	}
    }
    
    function upload_data_file() {
    
    	$imageURL = $this->do_upload ("upload_file");
    
    	if ($imageURL != null) {
    		$this->doRespondWithResult(VALUE_OK, Array("uploaded_url"=>$imageURL));
    		return;
    	}
    	else {
    		$this->doRespondWithResult(VALUE_FAIL);
    		return;
    	}
    }
   
}
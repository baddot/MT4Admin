

<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

define ("ARRAY_TRACE", serialize (Array(
		Array("MARKUP_BRIDGE_MODIFY", "401_markup_bridge", "Import Markup", "Import file to save Bridge Markup."),
		Array("USER_INFO_MODIFY", "101_user_info", "modify user info", "modify user info."),
		Array("MANAGERS_BAKET_GROUP_ALLOC", "501_managers_basket_group", "allocate group into basket", "allocate group into basket."),
		Array("MANAGER_MODIFY", "902_manager_info", "modify manager info", "modify manager info."),
		Array("MANAGER_CREATE", "902_manager_info", "create a new manager", "only admin can create a new manager."),
		Array("MANAGERS_BASKET_CREATE", "501_managers_basket", "create manager's basket", "create manager's basket."),
		Array("MANAGERS_BASKET_MODIFY", "501_managers_basket", "Modify or Delete basket", "Modify or Delete basket."),
		Array("MANAGERS_BASKET_ALLOC_USER", "501_managers_basket", "Allocate user into basket", "Allocate user into basket."),
		Array("MARKUP_BRIDGE_CREATE", "401_markup_bridge", "create information of spread of LP", "create information of spread of LP."),
		Array("MARKUP_BRIDGE_LP_MODIFY", "401_markup_bridge", "modify information of spread of LP", "modify information of spread of LP."),
		Array("MARKUP_BRIDGE_UPLOAD", "401_markup_bridge", "upload information of spread of LP", "upload information of spread of LP."),
		Array("WL_INFO_MODIFY", "103_wl_info", "modify White Lable info ", "modify White Lable info ."),
		Array("AGENT_INFO_CREATE", "102_agent_info", "create agent information ", "create agent information ."),
		Array("AGENT_INFO_MODIFY", "102_agent_info", "modify agent information ", "modify agent information ."),
		Array("LP_INFO_MODIFY", "104_lp_info", "modify lp info ", "modify lp info ."),
		Array("LP_INFO_CREATE", "104_lp_info", "creat lp info ", "creat lp info ."),
		Array("OMNI_ACCOUNT_SAVE", "402_designate_omni", "save omni account", "save omni account ."),
		Array("SETTLE_PRICE_SAVE", "403_settle_price", "save settle price", "save settle price."),
		Array("SETTLE_PRICE_UPLOAD", "403_settle_price", "upload settle price", "upload settle price."),
		Array("COMPARE_SAVE_LPORDER", "206_compare_order", "save compare lporder", "save compare lporder."),
		Array("AGENT_COMM_SAVE", "404_group_agent_comm", "save agent comm", "save agent comm."),
		Array("CASH_SAVE", "201_EquityView", "save cash", "save cash."),
		Array("CNFG_SAVE", "504_freemargin_warning", "save cnfg", "save cnfg."),
		Array("LP_ACCOUNT_CREATE", "405_lp_account", "create lp account", "create lp account."),
		Array("LP_ACCOUNT_MODIFY", "405_lp_account", "modify lp account", "modify lp account."),
		Array("LP_BALANCE_SAVE", "203_settle_summary", "save balance", "save balance")
		)
		)
		);

class Admin_model extends CI_Model {
	
	function __construct() {
		// Call the Model constructor
		parent::__construct ();
		$this->load->library('session');
		$this->load->library ( 'util' );
	}
	
	private function sqlForArray($sql, $parameter) {
		$res = $this->db->query ( $sql, $parameter);
		
		if ($res->num_rows () > 0) {
			$result = $res->result_array ();
		} else {
			$result = Array ();
		}
		
		$res->next_result ();
		$res->free_result ();
		
		return $result;
	}
	
	private function sqlForError($sql, $parameter) {
		$res = $this->db->query ( $sql, $parameter);
		if ($res->num_rows () > 0) {
			$result = $res->result_array ();
			$result = $result [0];
			if ($result ['RESULT'] == RESULT_OK) {
				$result = VALUE_OK;
			} else {
				$result = $result ['ERROR_CODE'];
			}
		} else {
			$result = VALUE_FAIL;
		}
		
		$res->next_result ();
		$res->free_result ();
		
		// save trace
		$trace_array =  unserialize (ARRAY_TRACE);
		for($i = 0; $i < count($trace_array); $i++) {
			
			$data = $trace_array[$i];
			if(strpos($sql, $data[0]) != false) {
				$param = Array();
				$param['i_manager_id'] = $this->session->userdata('manager_id');
				$param['i_module_name'] = $data[1];
				$param['i_job_title'] = $data[2];
				$param['i_job_detail'] = $data[3];
				$this->SP_ORIGNE_MANAGER_TRACE($param);
			}
		}
		
		return $result;
	}

	private function sqlForCnt($sql, $parameter) {
		$res = $this->db->query ( $sql, $parameter);
		
		if ($res->num_rows () > 0) {
			$result = $res->result_array ();
			$result = $result [0];
			if ($result ['RESULT'] == RESULT_OK) {
				$result = $result ['RECORD_CNT'];
			} else {
				$result = 0;
			}
		} else {
			$result = 0;
		}
		
		$res->next_result ();
		$res->free_result ();
		
		return $result;
	}
	
	private function excuteSql($sql, $parameters, $type) {
		$result = null;
		
		switch ($type) {
			case SQL_ARRAY:
				$result = $this->sqlForArray($sql, $parameters);
				break;
			case SQL_CNT:
				$result = $this->sqlForCnt($sql, $parameters);
				break;
			case SQL_ERROR:
				$result = $this->sqlForError($sql, $parameters);
				break;
		}	
		return $result;
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param $i_keyword varchar(20)
	 *        	('') 을 입력하면 전체조회 2) keyword 를 입력하면 조회 조건"
	 *        	$i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	$i_basket_code int 1) 0 입력하면 모든 basket 의 고객을 조회한다. 2) 0 이 아닌 basket code 를 입력하면 해당 basket 에 속하 유저정보만 가져온다."
	 *        	# $i_last_account int 1) 최초 조회시 0, 이후 조회시 직전 마지막 account no
	 *        	$i_list_count int 1) 하나의 페이지에 보여줄 리스트 숫자
	 *        	$i_last_idx int 1) offset
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_USER_INFO_VIEW($parms) {
		$sql = "CALL USER_INFO_VIEW(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_keyword'],
				$parms ['i_manager_id'],
				$parms ['i_basket_code'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		
		return $this->excuteSql($sql,$parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_keyword varchar(20) 1) 공백 ('') 을 입력하면 전체조회 2) keyword 를 입력하면 조회 조건"
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_basket_code int 1) 0 입력하면 모든 basket 의 고객을 조회한다. 2) 0 이 아닌 basket code 를 입력하면 해당 basket 에 속하 유저정보만 가져온다.
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_USER_INFO_VIEW_CNT($parms) {
		$sql = "CALL USER_INFO_VIEW_CNT(?,?,?)";
		$parameters = array (
				$parms ['i_keyword'],
				$parms ['i_manager_id'],
				$parms ['i_basket_code'] 
		);
		
		return $this->excuteSql($sql,$parameters, SQL_CNT);
	}
	
	/**
	 * 고객정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_account int
	 *        	i_name varchar(128)
	 *        	i_leverage int
	 *        	i_group_name varchar(16)
	 *        	i_agent_account int
	 *        	i_status varchar(16)
	 *        	i_country varchar(32)
	 *        	i_city varchar(32)
	 *        	i_state varchar(32)
	 *        	i_zipcode varchar(16)
	 *        	i_phone varchar(32)
	 *        	i_email varchar(48)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_USER_INFO_MODIFY($parms) {
		$sql = "CALL USER_INFO_MODIFY(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_account'],
				$parms ['i_name'],
				$parms ['i_leverage'],
				$parms ['i_group_name'],
				$parms ['i_agent_account'],
				$parms ['i_status'],
				$parms ['i_country'],
				$parms ['i_city'],
				$parms ['i_state'],
				$parms ['i_zipcode'],
				$parms ['i_phone'],
				$parms ['i_email'] 
		);
		
		return $this->excuteSql($sql,$parameters, SQL_ERROR);
	}
	
	/**
	 * 선택된 유저가 소속된 회사(W/L) 의 AGENT LIST 를 보여준다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LIST_BASKET($parms) {
		$sql = "CALL LIST_BASKET(?)";
		$parameters = array (
				$parms ['i_manager_id'] 
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 선택된 유저가 소속된 회사(W/L) 의 AGENT LIST 를 보여준다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LIST_AGENT($parms) {
		$sql = "CALL LIST_AGENT(?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_user_account'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * manager login
	 *
	 * @param
	 *        	i_id varchar(20)
	 *        	i_pwd varchar(20)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_LOGIN($parms) {
		$sql = "CALL MANAGER_LOGIN(?, ?)";
		$parameters = array (
				$parms ['i_id'],
				$parms ['i_pwd'] 
		);
		
		$result = $this->excuteSql($sql, $parameters, SQL_ARRAY);
		if(count($result) == 0) {
			$result['RESULT'] = VALUE_FAIL;
		}
		else {
			$result = $result[0];
			$result['RESULT'] = VALUE_OK;
		}
		
		return $result;
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_level INT 현재 접속한 manager 의 level. session 에서 가져온다.
	 *        	i_company_name varchar(30) 조회할 company_name. '' 이면 전체를 가져온다.
	 *        	i_list_count int 하나의 페이지에 보여줄 리스트 숫자
	 *        	i_last_idx int offset
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_INFO_VIEW($parms) {
		$sql = "CALL MANAGER_INFO_VIEW(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_level'],
				$parms ['i_company_name'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_level INT 현재 접속한 manager 의 level. session 에서 가져온다.
	 *        	i_company_name varchar(30) 조회할 company_name. '' 이면 전체를 가져온다.
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_MANAGER_INFO_VIEW_CNT($parms) {
		$sql = "CALL MANAGER_INFO_VIEW_CNT(?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_level'],
				$parms ['i_company_name'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 해당 관리자가 볼 수 있는 COMPANY LIST 반환
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_level INT
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS
	 */
	function SP_LIST_COMPANY($parms) {
		$sql = "CALL LIST_COMPANY(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_level'] 
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 관리자정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_manager_level int 1) 현재 접속한 manager 의 level. session 에서 가져온다.
	 *        	i_target_manager_id varchar(20) 수정대상 관리자 ID
	 *        	i_target_manager_name varchar(32) 수정대상 관리자 이름
	 *        	i_target_manager_pwd varchar(20) 수정대상 관리자 비번
	 *        	i_target_company_name varchar(30) 수정대상 관리자 회사
	 *        	i_target_comment varchar(200)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_MODIFY($parms) {
		$sql = "CALL MANAGER_MODIFY(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_target_manager_id'],
				$parms ['i_target_manager_name'],
				$parms ['i_target_manager_pwd'],
				$parms ['i_target_company_name'],
				$parms ['i_target_comment'] 
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 관리자 생성, admin계정만 생성가능하다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 작업하는 관리자 id
	 *        	i_new_manager_id varchar(20)
	 *        	i_new_manager_name varchar(32)
	 *        	i_new_manager_pwd varchar(20)
	 *        	i_new_company_name varchar(30)
	 *        	i_new_comments varchar(200)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_CREATE($parms) {
		$sql = "CALL MANAGER_CREATE(?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_new_manager_id'],
				$parms ['i_new_manager_name'],
				$parms ['i_new_manager_pwd'],
				$parms ['i_new_company_name'],
				$parms ['i_new_comments'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_company_name varchar(30)
	 *        	i_list_count int
	 *        	i_last_idx int offset
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_WL_INFO_VIEW($parms) {
		$sql = "CALL WL_INFO_VIEW(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_company_name'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_company_name varchar(30)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_WL_INFO_VIEW_CNT($parms) {
		$sql = "CALL WL_INFO_VIEW_CNT(?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_company_name'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 관리자정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_company_name varchar(30)
	 *        	i_address varchar(128)
	 *        	i_phone varchar(32)
	 *        	i_email varchar(64)
	 *        	i_comment varchar(64)
	 *        	i_status varchar(16) Y/N
	 *        	i_enabled char(1) Y/N
	 *        	i_omnibus_id int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_WL_INFO_MODIFY($parms) {
		$sql = "CALL WL_INFO_MODIFY(?,?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_company_name'],
				$parms ['i_address'],
				$parms ['i_phone'],
				$parms ['i_email'],
				$parms ['i_comment'],
				$parms ['i_status'],
				$parms ['i_enabled'],
				$parms ['i_omnibus_id'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_list_count int
	 *        	i_last_idx int offset
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_INFO_VIEW($parms) {
		$sql = "CALL LP_INFO_VIEW(?,?)";
		$parameters = array (
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	empty
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_LP_INFO_VIEW_CNT($parms) {
		$sql = "CALL LP_INFO_VIEW_CNT()";
		$parameters = array ();
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 관리자정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_id int
	 *        	i_lp_name varchar(30)
	 *        	i_enabled char(1) Y/N
	 *        	i_email varchar(100)
	 *        	i_phone1 varchar(20)
	 *        	i_phone2 varchar(20)
	 *        	i_addr varchar(200)
	 *        	i_comment varchar(200)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_INFO_MODIFY($parms) {
		$sql = "CALL LP_INFO_MODIFY(?,?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_lp_name'],
				$parms ['i_enabled'],
				$parms ['i_email'],
				$parms ['i_phone1'],
				$parms ['i_phone2'],
				$parms ['i_addr'],
				$parms ['i_comment'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 관리자정보 CREATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_name varchar(30)
	 *        	i_enabled char(1) Y/N
	 *        	i_email varchar(100)
	 *        	i_phone1 varchar(20)
	 *        	i_phone2 varchar(20)
	 *        	i_addr varchar(200)
	 *        	i_comment varchar(200)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_INFO_CREATE($parms) {
		$sql = "CALL LP_INFO_CREATE(?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_name'],
				$parms ['i_enabled'],
				$parms ['i_email'],
				$parms ['i_phone1'],
				$parms ['i_phone2'],
				$parms ['i_addr'],
				$parms ['i_comment'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_list_count int
	 *        	i_last_idx int offset
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_INFO_VIEW($parms) {
		$sql = "CALL AGENT_INFO_VIEW(?,?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_AGENT_INFO_VIEW_CNT($parms) {
		$sql = "CALL AGENT_INFO_VIEW_CNT(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 관리자정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_agent_account int
	 *        	i_agent_group varchar(16)
	 *        	i_agent_company varchar(100)
	 *        	i_upper_agent int
	 *        	i_hierarchy varchar(100)
	 *        	i_comm_value double
	 *        	i_comm_tp char(1) always 'P'
	 *        	i_enable char(1)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_INFO_MODIFY($parms) {
		$sql = "CALL AGENT_INFO_MODIFY(?,?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_agent_account'],
				$parms ['i_agent_group'],
				$parms ['i_agent_company'],
				$parms ['i_upper_agent'],
				$parms ['i_hierarchy'],
				$parms ['i_comm_value'],
				$parms ['i_comm_tp'],
				$parms ['i_enable'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 관리자정보 CREATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_agent_account int
	 *        	i_agent_group varchar(16)
	 *        	i_agent_company varchar(100)
	 *        	i_upper_agent int
	 *        	i_hierarchy varchar(100)
	 *        	i_comm_value double
	 *        	i_comm_tp char(1) always 'P'
	 *        	i_enable char(1)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_INFO_CREATE($parms) {
		$sql = "CALL AGENT_INFO_CREATE(?,?,?,?,?,?,?,?,?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_agent_account'],
				$parms ['i_agent_group'],
				$parms ['i_agent_company'],
				$parms ['i_upper_agent'],
				$parms ['i_hierarchy'],
				$parms ['i_comm_value'],
				$parms ['i_comm_tp'],
				$parms ['i_enable'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 1) MT4 고객정보를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 작업하는 관리자 id
	 *        	i_list_count int
	 *        	i_last_idx int offset
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGERS_BASKET_VIEW($parms) {
		$sql = "CALL MANAGERS_BASKET_VIEW(?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 1) MT4 고객정보 총 수를 반환한다.
	 * 2) 조건에 따라 반환값이 다를 수 있다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 작업하는 관리자 id
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_MANAGERS_BASKET_VIEW_CNT($parms) {
		$sql = "CALL MANAGERS_BASKET_VIEW_CNT(?)";
		$parameters = array (
				$parms ['i_manager_id'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 관리자정보 UPDATE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_basket_manager varchar(20)
	 *        	i_basket_code int
	 *        	i_basket_nm varchar(50)
	 *        	i_comment varchar(200)
	 *        	i_tp char(1) D:DELETE U:UPDATE
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGERS_BASKET_MODIFY($parms) {
		$sql = "CALL MANAGERS_BASKET_MODIFY(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_basket_manager'],
				$parms ['i_basket_code'],
				$parms ['i_basket_nm'],
				$parms ['i_comment'],
				$parms ['i_tp'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * Allocate user into basket
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_basket_manager varchar(20)
	 *        	i_basket_code int
	 *        	i_user_account int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGERS_BASKET_ALLOC_USER($parms) {
		$sql = "CALL MANAGERS_BASKET_ALLOC_USER(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_basket_manager'],
				$parms ['i_basket_code'],
				$parms ['i_user_account'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return spread info
	 *
	 * @param
	 *        	i_lp_id int if 0 - all
	 *        	i_list_count int
	 *        	i_last_id int
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SPREAD_LP_VIEW($parms) {
		$sql = "CALL SPREAD_LP_VIEW(?,?,?)";
		$parameters = array (
				$parms ['i_lp_id'],
				$parms ['i_list_count'],
				$parms ['i_last_id'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return view count
	 *
	 * @param
	 *        	i_lp_id int if 0 - all
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_SPREAD_LP_VIEW_CNT($parms) {
		$sql = "CALL SPREAD_LP_VIEW_CNT(?)";
		$parameters = array (
				$parms ['i_lp_id'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * modify information of spread of LP
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_id int
	 *        	i_symbol varchar(30)
	 *        	i_markup_bid double
	 *        	i_markup_ask double
	 *        	i_enabled char(1) Y/N
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SPREAD_LP_MODIFY($parms) {
		$sql = "CALL SPREAD_LP_MODIFY(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_symbol'],
				$parms ['i_markup_bid'],
				$parms ['i_markup_ask'],
				$parms ['i_enabled'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * create information of spread of LP
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_id int
	 *        	i_symbol varchar(30)
	 *        	i_markup_bid double
	 *        	i_markup_ask double
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SPREAD_LP_CREATE($parms) {
		$sql = "CALL SPREAD_LP_CREATE(?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_symbol'],
				$parms ['i_markup_bid'],
				$parms ['i_markup_ask'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * 선택된 유저가 소속된 회사(W/L) 의 LP LIST 를 보여준다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LIST_LP($parms) {
		$sql = "CALL LIST_LP(?)";
		$parameters = array (
				$parms ['i_manager_id'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * storing the trace
	 *
	 * @param
	 *        	i_manager_id	varchar(20)
	 *        	i_module_name	varchar(64)
	 *        	i_job_title		varchar(128)
	 *        	i_job_detail	varchar(512)
	 * 
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_TRACE($parms) {
		$sql = "CALL MANAGER_TRACE(?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_module_name'],
				$parms ['i_job_title'],
				$parms ['i_job_detail']
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	private function SP_ORIGNE_MANAGER_TRACE($params) {
		$sql = "CALL MANAGER_TRACE(?,?,?,?)";
		$parameters = array (
				$params ['i_manager_id'],
				$params ['i_module_name'],
				$params ['i_job_title'],
				$params ['i_job_detail']
		);
		
		$res = $this->db->query ( $sql, $parameters);
		
		if ($res->num_rows () > 0) {
			$result = $res->result_array ();
			$result = $result [0];
			if ($result ['RESULT'] == RESULT_OK) {
				$result = VALUE_OK;
			} else {
				$result = $result ['ERROR_CODE'];
			}
		} else {
			$result = VALUE_FAIL;
		}
		
		$res->next_result ();
		$res->free_result ();
		
		return $result;
	}
	
	
	/**
	 * view of trace
	 *
	 * @param
	 *        	i_manager_id			varchar(20)
	 *        	i_manager_level			int
	 *        	i_target_manager_id		varchar(20)
	 *        	i_from_dt				char(8)
	 *        	i_to_dt					char(8)
	 *        	i_keyword				varchar(20) Note: If this value is '', view all data.
	 *        	i_list_count			int
	 *        	i_last_idx				int
	 * 			i_target_company_name	varchar(100)
	 * 
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_TRACE_VIEW($parms) {
		$sql = "CALL MANAGER_TRACE_VIEW(?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_target_manager_id'],
				$parms ['i_from_dt'],
				$parms ['i_to_dt'],
				$parms ['i_keyword'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] ,
    			$parms['i_target_company_name']
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * view of trace count (number of trace for specific manager)
	 *
	 * @param
	 *        	i_manager_id		varchar(20)
	 *        	i_manager_level		int
	 *        	i_target_manager_id	varchar(20)
	 *        	i_from_dt			char(8)
	 *        	i_to_dt				char(8)
	 *        	i_keyword			varchar(20) Note: If this value is '', view all data.
	 * 
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGER_TRACE_VIEW_CNT($parms) {
		$sql = "CALL MANAGER_TRACE_VIEW_CNT(?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_target_manager_id'],
				$parms ['i_from_dt'],
				$parms ['i_to_dt'],
				$parms ['i_keyword']
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * 선택된 유저가 소속된 회사(W/L) 의 LP LIST 를 보여준다.
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_manager_level INT
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LIST_GROUP($parms) {
		$sql = "CALL LIST_GROUP(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * shows group list in basket
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level INT
	 *        	i_basket_code int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LIST_GROUP_IN_BASKET($parms) {
		$sql = "CALL LIST_GROUP_IN_BASKET(?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_basket_code'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * Allocate user into basket
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_way int 1 : save on BASKET, 2 : delete from BASKET
	 *        	i_basket_code int
	 *        	i_group_name varchar(16)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MANAGERS_BAKET_GROUP_ALLOC($parms) {
		$sql = "CALL MANAGERS_BASKET_GROUP_ALLOC(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_way'],
				$parms ['i_basket_code'],
				$parms ['i_group_name'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return spread info
	 *
	 * @param
	 *        	i_lp_id int if 0 - all
	 *        	i_list_count int
	 *        	i_last_id int
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MARKUP_BRIDGE_VIEW($parms) {
		$sql = "CALL MARKUP_BRIDGE_VIEW(?,?,?)";
		$parameters = array (
				$parms ['i_lp_id'],
				$parms ['i_list_count'],
				$parms ['i_last_id'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return view count
	 *
	 * @param
	 *        	i_lp_id int if 0 - all
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_MARKUP_BRIDGE_VIEW_CNT($parms) {
		$sql = "CALL MARKUP_BRIDGE_VIEW_CNT(?)";
		$parameters = array (
				$parms ['i_lp_id'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * modify information of spread of LP
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_id int
	 *        	i_symbol varchar(30)
	 *        	i_markup_bid double
	 *        	i_markup_ask double
	 *        	i_swap_short double
	 *        	i_swap_long double
	 *        	i_digits int
	 *        	i_enabled char(1) Y/N
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MARKUP_BRIDGE_MODIFY($parms) {
		$sql = "CALL MARKUP_BRIDGE_MODIFY(?,?,?,?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_symbol'],
				$parms ['i_markup_bid'],
				$parms ['i_markup_ask'],
				$parms ['i_swap_short'],
				$parms ['i_swap_long'],
				$parms ['i_digits'],
				$parms ['i_enabled'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * create information of spread of LP
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_lp_id int
	 *        	i_symbol varchar(30)
	 *        	i_markup_bid double
	 *        	i_markup_ask double
	 *        	i_swap_short double
	 *        	i_swap_long double
	 *        	i_digits int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MARKUP_BRIDGE_CREATE($parms) {
		$sql = "CALL MARKUP_BRIDGE_CREATE(?,?,?,?,?,?, ?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_symbol'],
				$parms ['i_markup_bid'],
				$parms ['i_markup_ask'],
				$parms ['i_swap_short'],
				$parms ['i_swap_long'],
				$parms ['i_digits'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return spread info
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_basket_code int 0 is all
	 *        	i_from char(8)
	 *        	i_to char(8)
	 *        	i_list_count int
	 *        	i_last_idx int
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMM_SETTLE_VIEW($parms) {
		$sql = "CALL COMM_SETTLE_VIEW(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_basket_code'],
				$parms ['i_from'],
				$parms ['i_to'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		$res = $this->db->query ( $sql, $parameters );
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return view count
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_basket_code int 0 is all
	 *        	i_from char(8)
	 *        	i_to char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_COMM_SETTLE_VIEW_CNT($parms) {
		$sql = "CALL COMM_SETTLE_VIEW_CNT(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_basket_code'],
				$parms ['i_from'],
				$parms ['i_to'],
				0,
				0 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * shows account list
	 *
	 * @param
	 *        	i_manager_id varchar(20) 1) 현재 접속한 manager 의 id. session 에서 가져온다.
	 *        	i_manager_level INT
	 * @return SUCCESS of the first column of recordset means sucess and FAIL means failure.
	 */
	function SP_LIST_ACCOUNT($parms) {
		$sql = "CALL LIST_ACCOUNT(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return TRADE_REPORT_LIST
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_account int
	 *        	i_from char(8)
	 *        	i_to char(8)
	 *        	i_list_count int
	 *        	i_last_idx int
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_TRADE_REPORT_VIEW($parms) {
		$sql = "CALL TRADE_REPORT_VIEW(?,?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_account'],
				$parms ['i_from'],
				$parms ['i_to'],
				$parms ['i_list_count'],
				$parms ['i_last_idx'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return view count
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_account int
	 *        	i_from char(8)
	 *        	i_to char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_TRADE_REPORT_VIEW_CNT($parms) {
		$sql = "CALL TRADE_REPORT_VIEW_CNT(?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_account'],
				$parms ['i_from'],
				$parms ['i_to'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_CNT);
	}
	
	/**
	 * return TRADE_REPORT_LIST
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_OMNI_ACCOUNT_VIEW($parms) {
		$sql = "CALL OMNI_ACCOUNT_VIEW(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return view count
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_tp int 1:save, 2:delete
	 *        	i_account int
	 *        	i_account_name varchar(128)
	 *        	i_group_name varchar(16)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 RECORD_CNT와 함께 성공
	 */
	function SP_OMNI_ACCOUNT_SAVE($parms) {
		$sql = "CALL OMNI_ACCOUNT_SAVE(?,?,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_tp'],
				$parms ['i_account'],
				$parms ['i_account_name'],
				$parms ['i_group_name'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return SETTLE_PRICE_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_PRICE_VIEW($parms) {
		$sql = "CALL SETTLE_PRICE_VIEW(?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return SETTLE_PRICE_SAVE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_market_rate double
	 *        	i_trade_dt char(8)
	 *        	i_symbol varchar(30)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_PRICE_SAVE($parms) {
		$sql = "CALL SETTLE_PRICE_SAVE(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'],
				$parms ['i_symbol'],
				$parms ['i_market_rate'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return AGENT_COMM_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_COMM_VIEW($parms) {
		$sql = "CALL AGENT_COMM_VIEW(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return AGENT_COMM_SAVE
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_group_name save
	 *        	i_agent_comm int
	 *        	i_spread_diff int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_COMM_SAVE($parms) {
		$sql = "CALL AGENT_COMM_SAVE(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_group_name'],
				$parms ['i_agent_comm'],
				$parms ['i_spread_diff'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return AGENT_COMM_UPLOAD
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_group_name save
	 *        	i_agent_comm int
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_AGENT_COMM_UPLOAD($parms) {
		$sql = "CALL AGENT_COMM_UPLOAD(?,?, ? ,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_group_name'],
				$parms ['i_agent_comm']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return COMPARE_OPENORD_OMNI_SUB
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMPARE_OPENORD_OMNI_SUB($parms) {
		$sql = "CALL COMPARE_OPENORD_OMNI_SUB(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return COMPARE_LIST_OPENORDER
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMPARE_LIST_OPENORDER($parms) {
		$sql = "CALL COMPARE_LIST_OPENORDER(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return COMPARE_OPENORDER_SYMBOL
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMPARE_OPENORDER_SYMBOL($parms) {
		$sql = "CALL COMPARE_OPENORDER_SYMBOL(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return COMPARE_NONMATCH_OPENORDER
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMPARE_NONMATCH_OPENORDER($parms) {
		$sql = "CALL COMPARE_NONMATCH_OPENORDER(?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'] 
		);

		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return COMPARE_SAVE_LPORDER
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_symbol varchar(30)
	 *        	i_invast_vol double
	 *        	i_sensus_vol double
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_COMPARE_SAVE_LPORDER($parms) {
		$sql = "CALL COMPARE_SAVE_LPORDER(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_symbol'],
				$parms ['i_invast_vol'],
				$parms ['i_sensus_vol'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return SETTLE_SUMMARY_A
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_SUMMARY_A($parms) {
		$sql = "CALL SETTLE_SUMMARY_A(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return SETTLE_SUMMARY_B
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_SUMMARY_B($parms) {
		$sql = "CALL SETTLE_SUMMARY_B(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return SETTLE_SUMMARY_A_GROUP
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_close_yn char(1) (Y, N)
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_SUMMARY_A_GROUP($parms) {
		$sql = "CALL SETTLE_SUMMARY_A_GROUP(?, ?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_close_yn'],
				$parms ['i_trade_dt'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return CLOSED_ORDERS_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_CLOSED_ORDERS_VIEW($parms) {
		$sql = "CALL CLOSED_ORDERS_VIEW(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'] 
		);
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return OPENED_ORDERS_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *        	
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_OPENED_ORDERS_VIEW($parms) {
		$sql = "CALL OPENED_ORDERS_VIEW(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'] 
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return EQUITY_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_EQUITY_VIEW($parms) {
		$sql = "CALL EQUITY_VIEW(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt']
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return EQUITY_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_trade_dt char(8)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_CASH_VIEW($parms) {
		$sql = "CALL CASH_VIEW(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt']
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	

	/**
	 * return CASH_SAVE
	 *
	 * @param
	 *        	i_manage_id			varchar(20)
				i_manager_level		int
				i_trade_dt			char(8)
				i_type_name			VARHAR(10)
				i_account_name		varchar(20)
				i_amount			decimal(15,2)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_CASH_SAVE($parms) {
		$sql = "CALL CASH_SAVE(?,?, ? ,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'],
				$parms ['i_type_name'],
				$parms ['i_account_name'],
				$parms ['i_amount']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	
	/**
	 * return CNFG_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_cnfg_id varchar(30)  cnfg_id 에 따른 값을 보여준다. (shows value depended on cnfg_id)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_CNFG_VIEW($parms) {
		$sql = "CALL CNFG_VIEW(?, ?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_cnfg_id']
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	
	/**
	 * return CNFG_SAVE
	 *
	 * @param
	 *        	i_manage_id			varchar(20)
	 i_manager_level		int
	 i_trade_dt			char(8)
	 i_cnfg_id	varchar(30)
	i_cnfg_value	varchar(30)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_CNFG_SAVE($parms) {
		$sql = "CALL CNFG_SAVE(?,?, ? ,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_cnfg_id'],
				$parms ['i_cnfg_value']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return FREEMARGIN_WARNING_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_FREEMARGIN_WARNING_VIEW($parms) {
		$sql = "CALL FREEMARGIN_WARNING_VIEW(?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level']
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * 	MANAGER LIST
	 *
	 * @param	i_manager_id			varchar(20)
	 i_level					INT
	 i_target_company_name	varchar(100)
	
	 @return	Result set of Manager List on SUCCESS.
	 */
	function  SP_LIST_MANAGER($parms) {
		$sql = "CALL LIST_MANAGER(?,?,?)";
		$parameters = array($parms['i_manager_id'], $parms['i_level'], $parms['i_target_company_name']);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	/**
	 * return COMPARE_SAVE_LPORDER
	 *
	 * @param
				 i_manager_id	varchar(20)
				i_manager_level	int
				i_trade_dt	char(8)
				i_symbol	varchar(30)
				i_market_rate	double
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_SETTLE_PRICE_UPLOAD($parms) {
		$sql = "CALL SETTLE_PRICE_UPLOAD(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_trade_dt'],
				$parms ['i_symbol'],
				$parms ['i_market_rate']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return MARKUP_BRIDGE_UPLOAD
	 *
	 * @param
	 i_manager_id	varchar(20)
	 i_manager_level	int
	 i_symbol	varchar(30)
	 i_markup_bid	double
     i_markup_ask	double
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_MARKUP_BRIDGE_UPLOAD($parms) {
		$sql = "CALL MARKUP_BRIDGE_UPLOAD(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_symbol'],
				$parms ['i_markup_bid'],
				$parms ['i_markup_ask']
		);
		
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return LP_ACCOUNT_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_ACCOUNT_VIEW($parms) {
		$sql = "CALL LP_ACCOUNT_VIEW(?, ?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level']
		);
	
		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	
	/**
	 * return LP_ACCOUNT_CREATE
	 *
	 * @param
	 *        	i_manage_id			varchar(20)
				i_manager_level		int
				i_lp_id	int
				i_lp_account	varchar(30)
				i_lp_comments	varchar(100
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_ACCOUNT_CREATE($parms) {
		$sql = "CALL LP_ACCOUNT_CREATE(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_lp_account'],
				$parms ['i_lp_comments']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return LP_ACCOUNT_MODIFY
	 *
	 * @param
	 *        	i_manage_id			varchar(20)
				 i_manager_level		int
				 i_lp_id	int
				 i_lp_account	varchar(30)
				 i_lp_comments	varchar(100
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_ACCOUNT_MODIFY($parms) {
		$sql = "CALL LP_ACCOUNT_MODIFY(?,?, ? ,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_lp_id'],
				$parms ['i_lp_account'],
				$parms ['i_lp_comments']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
	
	/**
	 * return LP_BALANCE_VIEW
	 *
	 * @param
	 *        	i_manager_id varchar(20)
	 *        	i_manager_level int
	 *        	i_dt varchar(8)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_BALANCE_VIEW($parms) {
		$sql = "CALL LP_BALANCE_VIEW(?, ?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_dt']
		);

		return $this->excuteSql($sql, $parameters, SQL_ARRAY);
	}
	
	
	/**
	 * return LP_BALANCE_SAVE
	 *
	 * @param
	 *        	i_manage_id	varchar(20)
				i_manager_level	int
				i_dt	char(8)
				i_lp_account	VARCHAR(30)
				i_buy_volume	decimal(15,2)
				i_sell_volume	decimal(15,2)
				i_gross_volume	decimal(15,2)
				i_deposit		decimal(15,2)
				i_withdrawal	decimal(15,2)
				i_profit	decimal(15,2)
				i_swaps	decimal(15,2)
				i_balance	decimal(15,2)
				i_floating_profit	decimal(15,2)
				i_prev_equity	decimal(15,2)
				i_curr_equity	decimal(15,2)
	 *
	 * @return 레코드셋의 첫번째 column (RESULT) 이 FAIL 이면 실패, SUCCESS 이면 성공
	 */
	function SP_LP_BALANCE_SAVE($parms) {
		$sql = "CALL LP_BALANCE_SAVE(?,?, ? ,?,?,?, ? ,?,?,?, ? ,?,?,?,?)";
		$parameters = array (
				$parms ['i_manager_id'],
				$parms ['i_manager_level'],
				$parms ['i_dt'],
				$parms ['i_lp_account'],
				$parms ['i_buy_volume'],
				$parms ['i_sell_volume'],
				$parms ['i_gross_volume'],
				$parms ['i_deposit'],
				$parms ['i_withdrawal'],
				$parms ['i_profit'],
				$parms ['i_swaps'],
				$parms ['i_balance'],
				$parms ['i_floating_profit'],
				$parms ['i_prev_equity'],
				$parms ['i_curr_equity']
		);
		return $this->excuteSql($sql, $parameters, SQL_ERROR);
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */
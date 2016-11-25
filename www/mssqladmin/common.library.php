<?php
//=======================================================================================
// File Name	:	common.library.php
// Author		:	kkang(sinbiweb)
// Update		:	2013-01-30
// Description	:	File I/O Handler
//=======================================================================================

include_once dirname(__FILE__)."/lib/class.FileHandler.php";
include_once dirname(__FILE__)."/lib/class.Database.php";

class Config
{
	var $file_handler;
	
	function Config()
	{
		$this->file_handler = new FileHandler();
	}
	
	function getServerArray() {
		$str_servers_xml = $this->file_handler->read(dirname(__FILE__).'/config/server_config.xml');
		$servers = new SimpleXMLElement($str_servers_xml);
				
		return $servers->Server;
	}
	
	function modifyServer($idx, $data) {
		$str_servers_xml = $this->file_handler->read(dirname(__FILE__).'/config/server_config.xml');
		$servers = new SimpleXMLElement($str_servers_xml);
		
		$id = intval($idx);
		$servers->Server[$id]->ServerName = $data['ServerName'];
		$servers->Server[$id]->IP = $data['IP'];
		$servers->Server[$id]->UserName = $data['UserName'];
		$servers->Server[$id]->MSSQLPort = $data['MSSQLPort'];
		$servers->Server[$id]->Password = $data['Password'];
		
		$result_xml = $servers->asXML();
		$this->saveXml($result_xml);
	}
	
	private function saveXml($result_xml) {
		$this->file_handler->open(dirname(__FILE__).'/config/server_config.xml');
		$this->file_handler->write($result_xml);
		$this->file_handler->close();
	}
	
	function  addServer($data) {
		$str_servers_xml = $this->file_handler->read(dirname(__FILE__).'/config/server_config.xml');
		$servers = new SimpleXMLElement($str_servers_xml);
		
		$server = $servers->addChild("Server");
		$server->addChild("ServerName", $data['ServerName']);
		$server->addChild("IP", $data['IP']);
		$server->addChild("ServerPort", 33333);
		$server->addChild("MSSQLPort", $data['MSSQLPort']);
		$server->addChild("UserName", $data['UserName']);
		$server->addChild("Password", $data['Password']);
		
		$result_xml = $servers->asXML();
		$this->saveXml($result_xml);
	}
	
	function deleteServer($id) {
		$str_servers_xml = $this->file_handler->read(dirname(__FILE__).'/config/server_config.xml');
		$servers = new SimpleXMLElement($str_servers_xml);
		$i = 0;
		foreach($servers->Server as $seg)
		{
			if($i == intval($id)) {
				$dom=dom_import_simplexml($seg);
				$dom->parentNode->removeChild($dom);
			}
			
			$i++;
		}
		
		$result_xml = $servers->asXML();
		$this->saveXml($result_xml);
	}
}


class Model {
	var $db_type = "sqlsrv";
	var $db_host = "localhost";
	var $db_name = "MGN_LEND";
	var $db_user = "root";
	var $db_password = "root";
	var $db_port = "1433";
	
	function Model($db_host, $db_port, $db_user, $db_passwd)
	{
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_password = $db_passwd;
	}
	
	function q1_query1() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_CRNT_TRDE_DT', 'TRDE_DT, MANAGE_GB_KS, MANAGE_GB_FU');
			Database::close();
			return $result;
		}
		
		Database::close();
		return false;
	}
	
	function q1_query2() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_DAILY_BATCH', 'JOB_GROUP, STEP, JOB_NM, EXEC_TP, EXEC_NM, START_TM, SUCC_YN, FORCLY_YN, EXEC_TP_DESC, LAST_EXEC_DT, LAST_EXEC_TM');
			Database::close();
			return $result;
		}
	
		Database::close();
		return false;
	}
	
	function q2_query() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		
		if($ret == true) {
			$retResult = Array();
			
			$result = Database::select('HT_T_CRNT_TRDE_DT', 'TRDE_DT, MANAGE_GB_KS, MANAGE_GB_FU');
			if($result == false) {
				Database::close();
				return false;
			}
			
			$retResult['TRDE_DT'] = $result[0]['TRDE_DT'];
			$retResult['MANAGE_GB_KS'] = $result[0]['MANAGE_GB_KS'];
			$retResult['MANAGE_GB_FU'] = $result[0]['MANAGE_GB_FU'];
			
			$result = Database::select('HT_T_NCLR', 'COUNT(*) as NCLR_COUNT', array('where' => array('GDS_CODE' => '00' )));
			if($result == false) {
				Database::close();
				return false;
			}
			$retResult['NCLR_COUNT'] = $result[0]['NCLR_COUNT'];
			
			$result = Database::select('HT_T_ORD', 'COUNT(*) AS ORD_COUNT', array('where' => array('GDS_CODE' => '00', "ORD_REMN_QTY > 0")));
			if($result == false) {
				Database::close();
				return false;
			}
			
			$retResult['ORD_COUNT'] = $result[0]['ORD_COUNT'];
			Database::close();
			return $retResult;
		}
		
		Database::close();
		return false;
	}
	
	function q3_query() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
	
		if($ret == true) {
			$retResult = Array();
				
			$result = Database::select('HT_T_CRNT_TRDE_DT', 'TRDE_DT, MANAGE_GB_KS, MANAGE_GB_FU');
			if($result == false) {
				Database::close();
				return false;
			}
				
			$retResult['TRDE_DT'] = $result[0]['TRDE_DT'];
			$retResult['MANAGE_GB_KS'] = $result[0]['MANAGE_GB_KS'];
			$retResult['MANAGE_GB_FU'] = $result[0]['MANAGE_GB_FU'];
				
			$result = Database::select('HT_T_NCLR', 'COUNT(*) as NCLR_COUNT', array('where' => array('GDS_CODE' => '02' )));
			if($result == false) {
				Database::close();
				return false;
			}
			$retResult['NCLR_COUNT'] = $result[0]['NCLR_COUNT'];
				
			$result = Database::select('HT_T_ORD', 'COUNT(*) AS ORD_COUNT', array('where' => array('GDS_CODE' => '02', "ORD_REMN_QTY > 0")));
			if($result == false) {
				Database::close();
				return false;
			}
				
			$retResult['ORD_COUNT'] = $result[0]['ORD_COUNT'];
			Database::close();
			return $retResult;
		}
	
		Database::close();
		return false;
	}
	
	function q4_query1() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_LOSSCUT_SISE', 'STK_CODE, NOW_PRC, TM', array('orderBy' => 'TM DESC' ));
			Database::close();
			return $result;
		}
		
		Database::close();
		return false;
	}
	
	function q4_query2() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_PRC_LIST_FU', 'STK_CODE, TM, NOW_PRC, OPEN_PRC, HIGH_PRC, LOW_PRC, SELL_HOGA_1, SELL_RMNQ_1,BUY_HOGA_1, BUY_RMNQ_1', array('orderBy' => 'TM DESC', 'where' => array("RTRIM(STK_CODE) <>''")));
			Database::close();
			return $result;
		}
	
		Database::close();
		return false;
	}
	
	function q4_query3() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_PRC_LIST_KS', 'STK_CODE, TM, NOW_PRC, OPEN_PRC, HIGH_PRC, LOW_PRC, SELL_HOGA_1, SELL_RMNQ_1,BUY_HOGA_1, BUY_RMNQ_1', array('orderBy' => 'TM DESC', 'where' => array("RTRIM(STK_CODE) <>''")));
			Database::close();
			return $result;
		}
	
		Database::close();
		return false;
	}
	
	function q5_query1() {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::select('HT_T_ARTC_MASTER', 'ARTC_CODE, MANAGE_GB');
			Database::close();
			return $result;
		}
	
		Database::close();
		return false;
	}
	
	function excute_query($query) {
		// initialize the database connection, only needs to be called once
		$ret = Database::initialize($this->db_type, $this->db_host,  $this->db_port, $this->db_name, $this->db_user, $this->db_password);
		if($ret == true) {
			$result = Database::query($query);
			Database::close();
			return $result;
		}
		
		Database::close();
		return false;
	}
}

function url(){
	return sprintf(
			"%s://%s:%d",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'], $_SERVER['SERVER_PORT'] 
	);
}

?>
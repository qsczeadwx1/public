<?
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'*  파 일 명 : config.inc.php
'*  작 성 자 : NOHMIN
'*  작 성 일 : 2020-11-11
'*  버     전 : V3.0
'*  기     능 : ERP 연동 환경설정
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

require_once M_CLASS."/class.Object.DB.Console.inc.php";


//define('ERP_IP', '192.168.123.177');
// BMS 42867
define('ERP_IP', '192.169.45.11');
//define('ERP_ID','gw');
//define('ERP_PW','gw1972');
define('ERP_DB','unilite');


//define('ERP_ID','sa');
//define('ERP_PW','admin123!@#');

define('ERP_ID','unilite');
define('ERP_PW','UNILITE');

define('MES_IP', '192.168.123.205');
define('MES_ID','sa');
define('MES_PW','tkadnjs0704!');
define('MES_DB','flexmes_samwon');

define ('C_TRIP_CAR' , 'C_TRIP_CAR');				// 법인차량 관리 마스터
define ('C_TRIP_CAR_RECORD' , 'C_TRIP_CAR_RECORD');				// 법인차량 운행기록

class erpEnv extends Object_Console
{
	/*
	*	ERP Connect
	*/
	function ERP_connect()
	{

		$DSN[]		= 'mssql://'.ERP_ID.":".ERP_PW."@".ERP_IP;  # Base DB
		# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		# DSN_OPTION
		# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		$DSN_OPTIONS	    = array
		(
			'debug' => 2,
			'result_buffering' => true,
		);
		$this->erp_db = new AnyDB($DSN[0],$DSN_OPTIONS);
	}

	/*
	*	MES Connect
	*/
	function MES_connect()
	{

		$DSN[]		= 'mssql://'.MES_ID.":".MES_PW."@".MES_IP."/".MES_DB;  # Base DB
		# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		# DSN_OPTION
		# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		$DSN_OPTIONS	    = array
		(
			'debug' => 2,
			'result_buffering' => true,
		);
		$this->mes_db = new AnyDB($DSN[0],$DSN_OPTIONS);
	}

}
?>
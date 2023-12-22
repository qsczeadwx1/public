<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'*  파 일 명 : class.syncTemplate.inc.php
'*  기     능 : 결재양식 연동처리
'*  작 성 자 : NOHMIN(nohmin@dbvalley.com)
'*  작 성 일 : 2016-12-26
'*  버     전 : V3
'*  비     고 :
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
# CLASS
# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
require_once $_SERVER['DOCUMENT_ROOT']."/config/config.inc.php";
require_once M_CLASS."/class.Object.DB.Console.inc.php";
require_once M_CLASS."/class.Object.DB.inc.php";
require_once ANYMATE_MINI_PATH."/dcs/config.inc.php";

class syncTemplate extends Object_Console
{
	function __construct()
	{
		parent::__construct();
		$this->debug= true;
		$this->decho("DCS sync process start.");
	}

	/**
	 * 결재테이블 및 관련변수 초기화.
	 */
	private function init()
	{
		$this->sel_year = date("Y");

		$this->TB_DCS		= T_DCS . $this->sel_year;
		$this->TB_PROC	= T_DCS_PROC . $this->sel_year;
		$this->TB_CONTENT = T_DCS_CONTENT . $this->sel_year;

		$this->CREATE_IP 	= $_SERVER["SERVER_ADDR"];
	}

	function __default()
	{
		$this->init();
		
		$LIST = $this->getSyncData();
		
		$result = false;

		for ($i=0; $i<count($LIST); $i++)
		{
			$row = $LIST[$i];

			$sync_iid = $row['sync_iid'];			
			$dcs_tem_id = $row['dcs_tem_id'];

			// 양식번호별 실행루틴 호출
			switch ($dcs_tem_id)		{
				case 48:	// 자금청구서
					include_once ANYMATE_BASE_PATH . "/erp/class/class.erpTemplate.inc.php";	
					$oErp = new erpTemplate();
					$result = $oErp->syncFundsBillApproval($row);	
					break; 
				case 50:	// 자금청구서 수정
					include_once ANYMATE_BASE_PATH . "/erp/class/class.erpTemplate.inc.php";	
					$oErp = new erpTemplate();
					$result = $oErp->syncFundsBillApproval($row);	
					break;
				case 51:	// 자금청구서 삭제
					break;
				default :								break;
			}
			if ($result === true)
			{
				unset($d);
				$d['update_dt']	= date("Y-m-d H:i:s");
				$d['update_flag']	= 2;
				$this->db->update(	T_DCS_SYNC_TEMPLATE , $d, " WHERE sync_iid = " . $sync_iid);
			}
		}
		$this->decho("DCS sync process end.");
	}
	
	function getSyncData()
	{
		$sql = "SELECT * FROM " . T_DCS_SYNC_TEMPLATE . " WHERE update_flag = 1";
		$this->db->que = $sql;
		$this->db->query();
		$arr = array();
		while ($row = $this->db->getRow())
		{
			$arr[] = $row;
		}
		return $arr;
	}
	
}

$oSync = new syncTemplate();
$oSync->__default();
?>
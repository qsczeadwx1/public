<?
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'*  파 일 명 : class.custom.inc.php
'*  기    능  : 결재완료시 custom 처리
'*  작 성 자 : NOHMIN(nohmin@dbvalley.com)
'*  작 성 일 : 2012-05-15
'*  버     전 : V3.0
'*  비     고 : T.O.P
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

require_once $_SERVER['DOCUMENT_ROOT']."/config/config.inc.php";
require_once M_CLASS."/class.Object.DB.Console.inc.php";
require_once M_CLASS."/class.Model.inc.php";
require_once ANYMATE_BASE_PATH ."/dcs/class/class.env.inc.php";
require_once ANYMATE_BASE_PATH ."/dcs/class/class.Alarm.inc.php"; // 알람모듈

//require_once ANYMATE_BASE_PATH ."/dcsdata/config.inc.php";

class execDcs extends Object_Console
{
	function __construct()
	{
		parent::__construct();
		$this->debug= true;
		$this->db->debug= true;
		//$this->decho("expire dcs start.OK");
	}


	public function proc($sel_year, $dcs_id)
	{
		$this->sel_year = $sel_year;
		$this->dcs_id = $dcs_id;

		$this->oEnv = new dcsEnv('CC');

		$sql = "Select D.dcs_tem_id  FROM " . T_DCS . $this->sel_year . " D WHERE D.dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
		$dcs_tem_id = $this->db->getOne();

		switch ($dcs_tem_id) {
		case 48:		// 자금청구서
		case 50:		// 자금청구서 수정
		case 51:		// 자금청구서 삭제
			$this->oEnv->syncTemplate($this->sel_year , $this->dcs_id, 'C');
			break;
			
		}
	}

	//  문서기안시
	function procDraft($sel_year,$dcs_id,$dcs_tem_id)
	{
		$this->sel_year = $sel_year;
		$this->dcs_id = $dcs_id;

		$this->oEnv = new dcsEnv('CA');

		switch ($dcs_tem_id) {
		case 48:			// 자금청구서

			break;
		default :								break;
		}		
	}
	
// 	public function procBan($sel_year, $dcs_id,$status='D',$dcs_tem_id='')
// 	{
// 		$this->sel_year = $sel_year;
// 		$this->dcs_id = $dcs_id;
// 
// 		$this->oEnv = new dcsEnv('CA');
// 		switch ($dcs_tem_id) {
// 
// 			$this->oEnv->syncTemplate($this->sel_year , $this->dcs_id, 'X');
// 			break;
// 			default :								break;
// 		}
// 
// 	}

	//  문서삭제시
	public function draftModify($sel_year,$dcs_id,$dcs_tem_id)
	{
		$this->sel_year = $sel_year;
		$this->dcs_id = $dcs_id;

		$this->oEnv = new dcsEnv('CA');

		$sql = "Select D.dcs_tem_id  FROM " . T_DCS . $this->sel_year . " D WHERE D.dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
		$dcs_tem_id = $this->db->getOne();
		
		switch ($dcs_tem_id) {
		case 48:		// 자금청구서
			$this->oEnv->syncTemplate($this->sel_year , $this->dcs_id, 'X');
			break;
		}
	}





}

?>
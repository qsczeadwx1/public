<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'* 파 일 명: class.erpTemplate.inc.php
'* 기     능: 자금청구서 연동
'* 작 성 자: NOHMIN(nohmin@dbvalley.com)
'* 작 성 일: 2021-01-15
'* 비     고: Anymate G.O
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

require_once M_CLASS."/class.Object.DB.Console.inc.php";
require_once ANYMATE_BASE_PATH ."/dcs/class/class.env.inc.php";

#* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
#  class
#* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

class erpTemplate extends Object_Console
{
	// private :
	var $cpn_code;

	function __construct($cpn_code=DFT_CPN_CODE)
	{
		parent::__construct();
		$this->cpn_code = $cpn_code;
		
		//$this->db->debug= true;
	}
	
	function init($row)
	{
		$this->sync_iid			= $row['sync_iid'];
		$this->sel_year		= $row['sel_year'];
		$this->dcs_id			= $row['dcs_id'];
		$this->dcs_tem_id	= $row['dcs_tem_id'];
		$this->status			= $row['status'];
		
		$this->TB_DCS = T_DCS . $this->sel_year;
		$this->TB_DCS_CONTENT = T_DCS_CONTENT . $this->sel_year;

		$sql = "SELECT cpn_code FROM " . $this->TB_DCS . " WHERE dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
		$this->cpn_code = $this->db->getOne();

		$this->oDcsEnv = new dcsEnv($this->cpn_code);
	}

	function __default($row)
	{

	}

	function syncFundsBillApproval($row)
	{
		$this->init($row);

		$this->debug= true;
		$this->decho("[FundsBillApproval] " . $this->sync_iid . " / dcs_id : " . $this->sel_year . " > " . $this->dcs_id . " / " . $this->status . " >>> START");

		switch ($this->status) {
		case 'C':		// 결재문서 완료처리
			$this->setProcess('C');
			break;
		case 'X':		// 결재문서 삭제처리
			$this->delProcess();
			break;
		}

		$this->decho("[FundsBillApproval] " . $this->sync_iid . " / dcs_id : " . $this->sel_year . " > " . $this->dcs_id . " / " . $this->status . " >>> END");
		return true;
	}

	// 결재완료시 처리
	function setProcess($status = 'C')
	{
		$sql = "Select D.acc_no , D.cpn_code , D.title , D.dcs_tem_id , C.content FROM " . T_DCS . $this->sel_year . " D , " . T_DCS_CONTENT . $this->sel_year . " C  WHERE D.dcs_id = C.dcs_id AND D.dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
		$row = $this->db->getRow();

		$content = $row['content'];
		$acc_no = $row['acc_no'];

		$DATA = $this->oDcsEnv->parseContents($content);
		
		// 기존자료 삭제
		$sql = "DELETE FROM C_FUNDS_BILL WHERE dcs_year = " . $this->sel_year . " AND dcs_id = ". $this->dcs_id;
		$this->db->query($sql);
		for ($i=1; $i<=60; $i++)
		{
			if (isset($DATA["itemA{$i}_1"]) && empty($DATA["itemA{$i}_1"]) === true) continue;

			$remark			= $DATA["itemA{$i}_1"];
			$company		= $DATA["itemA{$i}_5"];		// 거래처명
			$amount		= str_replace(",","",$DATA["itemA{$i}_2"]);
			$bill_dt			= $DATA["itemA{$i}_3"];

			unset($d);
			$d['acc_no']		= $acc_no;
			$d['dcs_year']	= $this->sel_year;
			$d['dcs_id']		= $this->dcs_id;
			$d['status']		= 9;
			$d['kind']		= $DATA['kind'];
			$d['company']	= $company;
			$d['remark']	= $remark;
			$d['amount']	= $amount;
			$d['bill_dt']		= $bill_dt;
			$d['reg_dt']		= date("Y-m-d H:i:s");
			$this->db->Insert("C_FUNDS_BILL",$d, "추가");
		}
	}

	
	// 결재문서 삭제처리
	function delProcess()
	{
		$sql = "DELETE FROM C_FUNDS_BILL WHERE dcs_year = '" . $this->sel_year . "' AND dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
	}

	// 일일업무일지(회계) 데이타 
	function syncDailyFundsApproval($row)
	{
		$this->init($row);

		$this->debug= true;
		$this->decho("[FundsDailyApproval] " . $this->sync_iid . " / dcs_id : " . $this->sel_year . " > " . $this->dcs_id . " / " . $this->status . " >>> START");

		switch ($this->status) {
		case 'A':		// 결재문서 기안
		case 'C':		// 결재문서 완료처리
			$this->setDailyProcess('C');
			break;
		case 'X':		// 결재문서 삭제처리
			$this->delDailyProcess();
			break;
		}

		$this->decho("[FundsDailyApproval] " . $this->sync_iid . " / dcs_id : " . $this->sel_year . " > " . $this->dcs_id . " / " . $this->status . " >>> END");
		return true;
	}

	// 결재완료시 처리
	function setDailyProcess($status = 'C')
	{
		$sql = "Select D.acc_no , D.cpn_code , D.title , D.dcs_tem_id , C.content FROM " . T_DCS . $this->sel_year . " D , " . T_DCS_CONTENT . $this->sel_year . " C  WHERE D.dcs_id = C.dcs_id AND D.dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
		$row = $this->db->getRow();

		$content = $row['content'];
		$acc_no = $row['acc_no'];

		$DATA = $this->oDcsEnv->parseContents($content);
		
		// 기존자료 삭제
		$sql = "DELETE FROM C_DAILY_FUNDS WHERE kind ='" . $DATA['company'] . "' AND (( dcs_year = " . $this->sel_year . " AND dcs_id = ". $this->dcs_id . ") OR funds_dt = '" . $DATA['rpt_dt'] . "')";
		$this->db->query($sql);

		unset($d);
		$d['acc_no']		= $acc_no;
		$d['dcs_year']	= $this->sel_year;
		$d['dcs_id']		= $this->dcs_id;
		$d['kind']		= $DATA['company'];
		$d['funds_dt']		= $DATA['rpt_dt'];
		$d['amount1']	= str_replace(",","",$DATA['today_amount1']);
		$d['amount2']	= str_replace(",","",$DATA['today_amount2']);
		$d['amount3']	= str_replace(",","",$DATA['today_amount3']);
		$d['amount4']	= str_replace(",","",$DATA['today_amount4']);
		$d['sum_amount']	= str_replace(",","",$DATA['today_sum']);
		$d['reg_dt']		= date("Y-m-d H:i:s");
		$this->db->Insert("C_DAILY_FUNDS",$d, "추가");
	
	}

	// 결재문서 삭제처리
	function delDailyProcess()
	{
		$sql = "DELETE FROM C_DAILY_FUNDS WHERE dcs_year = '" . $this->sel_year . "' AND dcs_id = " . $this->dcs_id;
		$this->db->query($sql);
	}

}


?>

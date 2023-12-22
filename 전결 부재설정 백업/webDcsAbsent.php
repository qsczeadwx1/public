<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'*  기     능 : 전자결재 부재중 설정
'*  파 일 명 : /dcs/class/class.webDcsAbsent.inc.php
'*  작 성 자 : NOHMIN(nohmin@dbvalley.com)
'*  작 성 일 : 2011-05-04
'*  버     전 : V3.0
'*  비     고 : T.O.P
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
STEP 1. 기본설정
STEP 2. 부재 배열
STEP 3. 정보 가져오기

FUN 1. 부재중 정보 로딩 loadDB()
EVENT FUN 1 부재중 정보저장
*/
require_once ANYMATE_MINI_PATH."/dcs/config.inc.php";
require_once M_CLASS."/class.EditViewApp.inc.php";

# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
# CLASS
# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

class webDcsAbsent extends EditViewApp
{
	var $cpn_code;
	var $useyn = 'N';

	function __construct($company_code = '')
	{
//		$this->debug= true;
		parent::__construct();
//		$this->db->debug = true;

		$this->cpn_code = (empty($this->oUser->cpn_code)) ? DFT_CPN_CODE : $this->oUser->cpn_code;

	}

	function __default()
	{
		$this->oUX->setSetupMenuSelect("M03001");

		// STEP 1. 기본설정
		$this->setTemplate('setup');
		$this->oUX->setPageTitle('부재설정');

		$this->event = "update";

		// STEP 2. 부재 배열
		$useynArray = array (
				'Y'		=> mecho('설정'),
				'N'		=> mecho('해제')
			);

		$absentTypeArray = array (
				1		=> mecho('대결'),
				2		=> mecho('후결')
		);

		// 부재시간 select 목록
		$V_arrayTime = array (
			'00:00'=>'00:00', '00:30'=>'00:30', '01:00'=>'01:00', '01:30'=>'01:30', '02:00'=>'02:00', '02:30'=>'02:30', '03:00'=>'03:00', '03:30'=>'03:30', '04:00'=>'04:00', 
			'04:30'=>'04:30', '05:00'=>'05:00', '05:30'=>'05:30', '06:00'=>'06:00',	'06:30'=>'06:30', '07:00'=>'07:00', '07:30'=>'07:30', '08:00'=>'08:00', '08:30'=>'08:30', 
			'09:00'=>'09:00', '09:30'=>'09:30', '10:00'=>'10:00', '10:30'=>'10:30', '11:00'=>'11:00', '11:30'=>'11:30', '12:00'=>'12:00', '12:30'=>'12:30', '13:00'=>'13:00', 
			'13:30'=>'13:30', '14:00'=>'14:00', '14:30'=>'14:30', '15:00'=>'15:00', '15:30'=>'15:30', '16:00'=>'16:00',	'16:30'=>'16:30', '17:00'=>'17:00', '17:30'=>'17:30',
			'18:00'=>'18:00', '18:30'=>'18:30', '19:00'=>'19:00', '19:30'=>'19:30', '20:00'=>'20:00', '20:30'=>'20:30', '21:00'=>'21:00',	'21:30'=>'21:30', '22:00'=>'22:00', 
			'22:30'=>'22:30', '23:00'=>'23:00', '23:30'=>'23:30', '23:59'=>'23:59'
		);
		$this->V_arrayTime = $V_arrayTime;

		// STEP 3. 정보 가져오기
		$row = $this->loadDB();

		$this->useyn = (count($row) > 0 ) ? 'Y':'N';

		$srt_dt = ($row['srt_dt'] != '') ? substr($row['srt_dt'],0,10)  : date("Y-m-d");
		$end_dt = ($row['end_dt'] != '') ? substr($row['end_dt'],0,10)  : date("Y-m-d");
		$start_time = ($row['srt_dt'] != '') ? substr($row['srt_dt'],11,5) : "00:00";
		$end_time = ($row['end_dt'] != '') ? substr($row['end_dt'],11,5) : "23:59";

		$sel_starttime = Form::select('start_time',$this->V_arrayTime,$start_time,'');
		$DATA['edit']['sel_starttime'] = $sel_starttime;

		$sel_endtime = Form::select('end_time',$this->V_arrayTime,$end_time,'');
		$DATA['edit']['sel_endtime'] = $sel_endtime;

		# 부재기간 ( 달력 )
		$this->oUX->addCalendar("srt_dt",'',$srt_dt);
		$this->oUX->addCalendar("end_dt",'',$end_dt);

		// 부재중 결재방식
		$DATA['absent_type'] = form::radio_print("absent_type",$absentTypeArray, $row['absent_type']);
		// 부재중 대결자 선택
		$DATA['absent_acc_no'] = ($row['absent_acc_no'] > 0) ? 'U:'.$row['absent_acc_no']:'';

		// 설정/해제
		$DATA['useyn'] = form::select("useyn", $useynArray, $this->useyn);

		// 부재기간(시간별)
		$DATA['absent'] = '';
		if ($row) $DATA['absent'] = "( " . $row['srt_dt'] . " 부터 " . $row['end_dt'] . " )";

		# 도움말
		$this->oUX->addTip("부재설정은 휴가, 연수 및 기타 부득이한 상황에 결재공백을 없애기 위해 대결/후결을 설정합니다.");
		$this->oUX->addTip("부재의 기간은 시작 설정시간부터 종료 설정 자정입니다.");
		$this->oUX->addTip("부재중 결재방식에서 대결인 경우 대결자를 지정하며 후결인 경우 다음결재자에게로 진행되며 복귀 후 결재를 하실수 있습니다.");
		$this->oUX->addTip("대결자 지정의 기준은 결재문서의 도착일을 기준으로 합니다.");
		$this->oUX->addTip("일정조정으로 복귀기일이 앞당겨 졌을 때는 반드시 부재설정을 해제로 변경하여야 합니다.");
		$this->oUX->addTip("대결은 결재, 협조(합의), 참조의 결재유형에 해당됩니다. 수신/최종수신자는 제외");

		return $DATA;
		// 끝
	}

	/**
     * 부재중 정보 로딩
	 * loadDB()
	 * @param
	 * @return array
	 */
	function loadDB()
	{
		$sql = "SELECT * FROM " . T_DCS_ABSENT . " WHERE acc_no ='" . $this->oUser->acc_no . "' and cpn_code = '" . $this->cpn_code . "'";
		$this->db->que = $sql;
		$this->db->query();

		return $this->db->getRow();

	}

	/**
     * 부재중 정보저장
	 * update()
	 * @param
	 * @return
	 */
	function update()
	{
		// 삭제
		$sql = "DELETE FROM " . T_DCS_ABSENT . " WHERE acc_no ='" . $this->oUser->acc_no . "' and cpn_code = '" . $this->oUser->cpn_code . "'";
		$this->db->que = $sql;
		$this->db->query();

		// Insert
		if ($this->useyn == 'Y')
		{
			if ($this->srt_dt > $this->end_dt) MSG::display(mecho("시작일이 종료일 보다 작습니다."),1);
			if ($this->srt_dt == $this->end_dt && $this->start_time > $this->end_time) MSG::display(mecho("종료일은 시작일보다 빠를 수 없습니다."),1);
			// if ($this->srt_dt == date("Y-m-d")) $srt_dt = date("Y-m-d H:i:s");
			// else $srt_dt = $this->srt_dt . ' 00:00:00';

			$d['acc_no']				= $this->oUser->acc_no;
			$d['srt_dt']				= $this->srt_dt . ' ' . $this->start_time . ':00';
			$d['end_dt']				= $this->end_dt . ' ' . $this->end_time . ':59';
			$d['reg_dt']				= date("Y-m-d H:i:s");
			$d['absent_type']			= $this->absent_type;
			if ($d['absent_type'] == 1 && $this->select_absent_acc_no) list($tmp , $d['absent_acc_no'])	= explode(':',$this->select_absent_acc_no);
			$d['cpn_code']				= $this->cpn_code;

			if ($d['absent_type'] == 1 && $d['absent_acc_no'] == $this->oUser->acc_no) MSG::display("자기 자신을 선택할 수 없습니다",1);
			$err = $this->db->Insert(T_DCS_ABSENT,$d,"부재중 설정");

			if ($d['absent_type'] == 1 && $this->isDate($d['absent_acc_no'], $d['srt_dt'] , $d['end_dt']) === FALSE)
			{
				$sql = "DELETE FROM " . T_DCS_ABSENT . " WHERE acc_no ='" . $this->oUser->acc_no . "' and cpn_code = '" . $this->oUser->cpn_code . "'";
				$this->db->que = $sql;
				$this->db->query();

				MSG::display(mecho("대결지정이 중복된 사용자(부재기간으로)가 있습니다"), 1);
			}

		}

		return $this->__default();
	}

	/**
	* 대결기간 중복 체크
	* isDate()
	* @param srt_dt date, end_dt date
	* @return boolean
	**/
	function isDate($absent_acc_no , $srt_dt , $end_dt)
	{
		// 내가 대결자로 지정한 사람이 나를 대결자로 지정했나요?
		$sql = "SELECT * FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $absent_acc_no . " AND absent_acc_no = " . $this->oUser->acc_no;
		$this->db->que = $sql;
		$this->db->query();
		$row = $this->db->getRow();

		if ($row)
		{
			// 기간으로 검색
			// STEP1. 내가 설정한 날짜 시작일이 상대의 기간에 포함되는지? 최종일이 상대의 기간에 포함되는지?
			$sql = "SELECT count(*) FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $absent_acc_no . " AND absent_acc_no = " . $this->oUser->acc_no;
			$sql .= " AND ( '" . $srt_dt . "' BETWEEN srt_dt AND end_dt OR  '" . $end_dt . "' BETWEEN srt_dt AND end_dt ) ";
			$this->db->que = $sql;
			$this->db->query();
			if ($this->db->getOne() > 0) return false;

			// STEP2. 상대방이 설정한 날짜 시작일이 내가 설정한 날짜에 포함되는지? 최종일이 나의 기간에 포함되는지?
			$sql = "SELECT count(*) FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $this->oUser->acc_no . " AND absent_acc_no = " . $absent_acc_no;
			$sql .= " AND ( '" . $row['srt_dt'] . "' BETWEEN srt_dt AND end_dt OR  '" . $row['end_dt'] . "' BETWEEN srt_dt AND end_dt ) ";
			$this->db->que = $sql;
			$this->db->query();
			if ($this->db->getOne() > 0) return false;

		}
		else return true;

		return true;
	}
}


?>
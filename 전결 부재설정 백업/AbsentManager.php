<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
'*  기     능 : 부재설정 관리자모드
'*  파 일 명 : /dcs/class/class.AbsentManager.inc.php
'*  작 성 자 : NOHMIN(nohmin@dbvalley.com)
'*  작 성 일 : 2017-05-15
'*  버     전 : V3.0
'*  비     고 : T.O.P
'* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
require_once ANYMATE_BASE_PATH .  "/dcs/class/class.env.inc.php";
require_once ANYMATE_MINI_PATH."/dcs/config.inc.php";
require_once M_CLASS."/class.EditListApp.inc.php";
require_once ANYMATE_LIB."/class.io.inc.php";

# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
# CLASS
# * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

class AbsentManager extends EditListApp
{
	var $cpn_code;
	var $WHERE;

	function __construct()
	{
		parent::__construct();
		$this->cpn_code = (empty($this->oUser->cpn_code)) ? DFT_CPN_CODE : $this->oUser->cpn_code;
		
		// model init
		$this->oModel = AM_Model::factory(T_DCS_ABSENT);

		$this->setTemplate('admin');

		$this->oEnv = new dcsEnv;
		$this->oEnv->loadDB($this->cpn_code);
	}

	function init()
	{
		if(!isset($this->page)) $this->page =1;
		if(!isset($this->page_size)) $this->page_size =20;
		if(!isset($this->sort)) $this->sort='desc';
		if(!isset($this->s_name)) $this->s_name='';
		if(!isset($this->s_id)) $this->s_id='';

		
	}
	function __default()
	{
		$this->oUX->setAdminMenuSelect("M05020");
		$this->init();

		$useynArray = array (
				'Y'		=> mecho('설정'),
				'N'		=> mecho('해제')
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
		





		// 검색창 메뉴생성
		$data['s_name'] = (isset($this->s_name)) ? $this->s_name:"";
		$data['s_id'] = (isset($this->s_id)) ? $this->s_id:"";

		$this->oUX->addHiddenField("page",$this->page);
		$this->oUX->addHiddenField("s_name",$this->s_name);
		$this->oUX->addHiddenField("s_id",$this->s_id);

		$this->WHERE = " WHERE S.cpn_code = '" . $this->cpn_code . "'";

		$this->oUX->setPageTitle('부재설정관리');
		// 안내문구 출력
		$this->oUX->addTip("사용자가 설정한 부재설정을 관리할수 있습니다.");
		// 컬럼 생성
		$this->oUX->addTableColumn("번호","5%","center");
		$this->oUX->addTableColumn("사용자","15%");
		$this->oUX->addTableColumn("부재기간","*");
		$this->oUX->addTableColumn("결재방식","10%","center");
		$this->oUX->addTableColumn("대결자","15%");
		$this->oUX->addTableColumn("설정일","120","center");
		$this->oUX->addTableColumn("수정","60","center");
		$this->oUX->addTableColumn("삭제","60","center");

		// 목록
		$LIST = $this->getListArray();

		$n = $this->total - ($this->page - 1) * $this->page_size;
		for($i=0;$i<count($LIST);$i++)
		{
			$row = $LIST[$i];

			$my_no = $n;
			$my_pk = $row['dcs_abs_id'];
			$my_check = '<input name="checkbox[]" id="selc'.$i.'" type="checkbox" value="'.$my_pk.'" />';
			$my_name = $row['dept_name'] . " " . $row['name'];
			$my_date = $row['srt_dt'] . " ~ " .  $row['end_dt'];
			$my_reg_dt = IO::getDatetime($row['reg_dt']);
			$my_absent_name = $row['absent_dept_name'] . " " .$row['absent_name'];
			$my_absent_type = $_ENV['DCS']['ABSENT']['TYPE'][$row['absent_type']];

			$btn_edit	= UX::getButton("","수정","edit($i);");
			$btn_del	= UX::getButton("","삭제","del($i);");

			$this->oUX->addTableRow($my_check,$my_no,$my_name, $my_date , $my_absent_type , $my_absent_name , $my_reg_dt , $btn_edit, $btn_del);
			$n--;
		}
		
		// 편집모드인 경우 편집창에 출력될 편집대상 데이터를 미리 구한다.
		if($this->_edit_mode === true)
		{
			$oModel = $this->oModel;
			$oModel->get($this->checkbox[0]);

			// 편집창 기본값 설정.
			$data['edit']['acc_no']	= "U:". $oModel->acc_no . ":".$this->cpn_code;
			$data['edit']['absent_type']	= form::radio_print("absent_type",$_ENV['DCS']['ABSENT']['TYPE'],$oModel->absent_type);

			# 부재기간 ( 달력 )
			$this->oUX->addCalendar("srt_dt",'',substr($oModel->srt_dt,0,10));
			$this->oUX->addCalendar("end_dt",'',substr($oModel->end_dt,0,10));

			# 부재시간
			$sel_starttime = Form::select('start_time',$this->V_arrayTime,substr($oModel->srt_dt,11,5),'');
			$data['edit']['sel_starttime'] = $sel_starttime;
			$sel_endtime = Form::select('end_time',$this->V_arrayTime,substr($oModel->end_dt,11,5),'');
			$data['edit']['sel_endtime'] = $sel_endtime;
			
			// 부재기간(시간별)
			$data['edit']['absent'] = "( " . $oModel->srt_dt. " 부터 " . $oModel->end_dt . " )";
			
			if ($oModel->absent_acc_no)	$data['edit']['absent_acc_no']		= "U:". $oModel->absent_acc_no . ":" . $this->cpn_code;
			else $data['edit']['absent_acc_no'] = '';
			$data['edit']['useyn'] = form::select("useyn", $useynArray, "Y");

			// 편집대상  레코드 Primary Key를 위한 hidden 필드 생성.
			$this->oUX->addHiddenField("dcs_abs_id",$oModel->dcs_abs_id);

		}
		else // 기본값으로 초기화
		{
			$data['edit']['acc_no']	= "";
			$data['edit']['absent_type']	= form::radio_print("absent_type",$_ENV['DCS']['ABSENT']['TYPE'],1);

			# 부재기간 ( 달력 )
			$this->oUX->addCalendar("srt_dt",'',date("Y-m-d"));
			$this->oUX->addCalendar("end_dt",'',date("Y-m-d"));
			# 부재시간
			$sel_starttime = Form::select('start_time',$this->V_arrayTime,"00:00",'');
			$data['edit']['sel_starttime'] = $sel_starttime;
			$sel_endtime = Form::select('end_time',$this->V_arrayTime,"23:59",'');
			$data['edit']['sel_endtime'] = $sel_endtime;

			$data['edit']['absent'] = '';
			$data['edit']['absent_acc_no']		= "";
			$data['edit']['useyn'] = form::select("useyn", $useynArray, "Y");
		}
		return $data;
	}

	public function getListArray()
	{
		$data = array();
		// 총계
		$this->total = $this->getTotal();
		$sql = $this->getListQuery();

		// 페이징 객체 생성
		$this->setPage($this->total,$this->page,"mode=" . $this->mode . "&s_name=".$this->s_name."&s_id=".$this->s_id."&order_idx=".$this->order_idx."&sort=".$this->sort,$this->page_size);
		$this->db->que = $sql;
		$this->db->setLimit($this->page_size,$this->oPage->Start); // LIMIT 설정
		$this->db->query($sql);

		if($this->total==0) return $data;

		while($row = $this->db->getRow())
		{
			$data[] = $row;
		}
		return $data;

	}



	/**
	 * 목록 쿼리문  반환
	 */
	protected function getListQuery()
	{

		// 탭정렬 필드정의
		if(!isset($this->order_idx)) $this->order_idx = 0;
		// 탭정렬 방향
		$this->sort = $sort	= (isset($this->sort) && !empty($this->sort)) ? $this->sort : "desc";

		switch($this->order_idx)
		{
			case '0': $order_by ='A.reg_dt';		break;
			case '1': $order_by ='U.name';	break;
			case '3': $order_by ='A.reg_dt';	break;
			default : $order_by = 'A.reg_dt';		break;
		}

		$sql = "SELECT A.*, U.name , U.dept_name , U1.name absent_name, U1.dept_name absent_dept_name 
						FROM " . V_USER . " U ,  " . T_DCS_ABSENT . " A  LEFT JOIN " . V_USER . " U1 ON A.absent_acc_no = U1.acc_no " . $this->WHERE;
		$sql .=" ORDER BY $order_by $sort";
		return $sql;

	}


	public function getTotal()
	{
		$this->WHERE = " WHERE A.acc_no = U.acc_no AND U.cpn_code = '" . $this->cpn_code . "'";
		$sql = $this->WHERE;
		$sql .= " AND U.acc_level <= ".GC_LEVEL_USER;
		$this->WHERE = $sql;
		$sql = "SELECT count(*) FROM " . V_USER . " U ,  " . T_DCS_ABSENT . " A  LEFT JOIN " . V_USER . " U1 ON A.absent_acc_no = U1.acc_no " . $this->WHERE;
		$this->db->query($sql);
		return $this->db->getOne();
	}

	/**
     * 부재중 정보저장
	 * update()
	 * @param
	 * @return
	 */
	function update()
	{
		@list(,$this->acc_no , ) = explode(":",$this->acc_no);
		// 삭제
		$sql = "DELETE FROM " . T_DCS_ABSENT . " WHERE acc_no ='" . $this->acc_no . "' and cpn_code = '" . $this->cpn_code . "'";
		$this->db->que = $sql;
		$this->db->query();

		// Insert
		if ($this->useyn == 'Y')
		{
			if ($this->srt_dt > $this->end_dt) MSG::display(mecho("시작일이 종료일 보다 작습니다."),1);
			if ($this->srt_dt == $this->end_dt && $this->start_time > $this->end_time) MSG::display(mecho("종료일은 시작일보다 빠를 수 없습니다."),1);
			// if ($this->srt_dt == date("Y-m-d")) $srt_dt = date("Y-m-d H:i:s");
			// else $srt_dt = $this->srt_dt . ' 00:00:00';

			$d['acc_no']					= $this->acc_no;
			$d['srt_dt']					= $this->srt_dt . ' ' . $this->start_time . ':00';
			$d['end_dt']					= $this->end_dt . ' ' . $this->end_time . ':59';
			$d['reg_dt']					= date("Y-m-d H:i:s");
			$d['absent_type']		= $this->absent_type;
			if ($d['absent_type'] == 1 && $this->absent_acc_no) list($tmp , $d['absent_acc_no'])	= explode(':',$this->absent_acc_no);
			$d['cpn_code']				= $this->cpn_code;

			if ($d['absent_type'] == 1 && $d['absent_acc_no'] == $this->acc_no) MSG::display("자기 자신을 선택할 수 없습니다",1);
			$err = $this->db->Insert(T_DCS_ABSENT,$d,"부재중 설정");

			if ($d['absent_type'] == 1 && $this->isDate($d['absent_acc_no'], $d['srt_dt'] , $d['end_dt']) === FALSE)
			{
				$sql = "DELETE FROM " . T_DCS_ABSENT . " WHERE acc_no ='" . $this->acc_no . "' and cpn_code = '" . $this->oUser->cpn_code . "'";
				$this->db->que = $sql;
				$this->db->query();

				MSG::display("대결지정이 중복된 사용자(부재기간으로)가 있습니다", 1);
			}

		}

		MSG::display ("","./?mode=" . $this->mode);
	}

	/**
     * 부재중 정보저장
	 * update()
	 * @param
	 * @return
	 */
	function add()
	{
		$this->update();
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
		$sql = "SELECT * FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $absent_acc_no . " AND absent_acc_no = " . $this->acc_no;
		$this->db->que = $sql;
		$this->db->query();
		$row = $this->db->getRow();

		if ($row)
		{
			// 기간으로 검색
			// STEP1. 내가 설정한 날짜 시작일이 상대의 기간에 포함되는지? 최종일이 상대의 기간에 포함되는지?
			$sql = "SELECT count(*) FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $absent_acc_no . " AND absent_acc_no = " . $this->acc_no;
			$sql .= " AND ( '" . $srt_dt . "' BETWEEN srt_dt AND end_dt OR  '" . $end_dt . "' BETWEEN srt_dt AND end_dt ) ";
			$this->db->que = $sql;
			$this->db->query();
			if ($this->db->getOne() > 0) return false;

			// STEP2. 상대방이 설정한 날짜 시작일이 내가 설정한 날짜에 포함되는지? 최종일이 나의 기간에 포함되는지?
			$sql = "SELECT count(*) FROM " . T_DCS_ABSENT . " WHERE acc_no = " . $this->acc_no . " AND absent_acc_no = " . $absent_acc_no;
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
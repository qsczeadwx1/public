<?
// 달력기본 정의
$this->module->oUX->_calendar_return = 1;
$this->module->oUX->_calendar_input_style = "margin-right:3px;margin-left:3px;width:65px";
$calendar_options = "changeMonth: true,changeYear: true,";

if (!$DATA[0]["srch_start_date"]) $DATA[0]["srch_start_date"] = date(Y.'-'.m.'-'.d);
$this->module->oUX->addCalendar("srch_start_date","",$DATA[0]["srch_start_date"],"onchange='getDateTerm()'");
$srch_start_date = $this->module->oUX->showCalendar(0,1);

if (!$DATA[0]["srch_end_date"]) $DATA[0]["srch_end_date"] = date(Y.'-'.m.'-'.d);
$this->module->oUX->addCalendar("srch_end_date","",$DATA[0]["srch_end_date"],"onchange='getDateTerm(); getEndDate();'");
$srch_end_date = $this->module->oUX->showCalendar(1,1);
?>
<script>
$(document).ready(function(){
	//getSignDate();
});

function getDateTerm(){
	var sdate_tmp = document.getElementById('srch_start_date').value;
	var edate_tmp = document.getElementById('srch_end_date').value;

	sdate = new Date(sdate_tmp.substr(0,4), sdate_tmp.substr(5,2)-1, sdate_tmp.substr(8,2));
	edate = new Date(edate_tmp.substr(0,4), edate_tmp.substr(5,2)-1, edate_tmp.substr(8,2));

	if(sdate.getTime()<edate.getTime()){
		termSec = edate.getTime() - sdate.getTime();
		termDay = termSec/(60*60*24)/1000 + 1;
		termMon = Math.floor(termDay/30);
		termYear = Math.floor(termMon/12);
	}
	else if(sdate.getTime()==edate.getTime()){
		termDay = 1;
	}
	else termDay = 0;

	if(sdate.getTime() > 0  && edate.getTime() > 0 && sdate.getTime() > edate.getTime()){
        //alert("기간 중 시작 날이 마치는 날보다 최근일자입니다.");
	    document.getElementById('srch_end_date').value = document.getElementById('srch_start_date').value;
	}
	document.getElementById('term_Y').value = termYear;
	document.getElementById('term_M').value = termMon%12;
}
function getSignDate()
{
	date = $("#srch_end_date").val();
	sign_dt = date.split("-");
	$("#sign_dt_yy").val(sign_dt[0]);
}


// 최종 근무일 선택 시 하단 퇴직일 선택 처리
function getEndDate()
{
	var edate = document.getElementById('srch_end_date').value; // 최종근무일
	var edate_arr = edate.split("-");
	
	edate_arr[1] = parseInt(edate_arr[1], 10); // 숫자로 변환하여 0 제거
	edate_arr[2] = parseInt(edate_arr[2], 10); // 숫자로 변환하여 0 제거
	
	// 하단 퇴직일 선택 처리
	document.getElementById('sday_dt_yy').value = edate_arr[0];
	document.getElementById('sday_dt_mm').value = edate_arr[1];
	document.getElementById('sday_dt_dd').value = edate_arr[2];

}

/*
function getEndDate()
{
	var edate = document.getElementById('srch_end_date');

	var edate_val = edate.value;

	var edate_dt = edate_val.split("-");

	var sday_yy = document.getElementById('sday_dt_yy');
 	var sday_mm = document.getElementById('sday_dt_mm');
 	var sday_dd = document.getElementById('sday_dt_dd');
	
	// 월과 일은 9이하의 숫자들의 값이 01, 02, 03식으로 넘어오기 때문에, 0을 빼줌
    if (edate_dt[1][0] === "0") {
        edate_dt[1] = edate_dt[1].substr(1,1);
	}
	if (edate_dt[2][0] === "0") {
		edate_dt[2] = edate_dt[2].substr(1,1);
	}

	var optionYear = sday_yy.querySelector('option[value="' + edate_dt[0] + '"]');
	var optionMonth = sday_mm.querySelector('option[value="' + edate_dt[1] + '"]');
	var optionDay = sday_dd.querySelector('option[value="' + edate_dt[2] + '"]');

	optionYear.selected = true;
	optionMonth.selected = true;
	optionDay.selected = true;
}
*/

</script>
<input type="hidden" name="title" value="사직서">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dcs_part_write">
<col width="15%"></col>
<col width="20%"></col>
<col width="15%"></col>
<col width="15%"></col>
<col width="15%"></col>
<col width="20%"></col>
<tr>
	<th><?=mecho("성명")?></th>
	<td class="default"><?=mecho($DATA['drafter'])?></td>
	<th><?=mecho("직급")?></th>
	<td class="default"><?=mecho($DATA['ptn_name'])?></td>
	<th><?=mecho("근무기간")?></th>
	<td class="default">
		<input type='text' id="term_Y" name='term_Y' value="<?=$DATA[0]['term_Y']?>" size=3 style='font-size:9pt' class="text_f">년
		<input type='text' id="term_M" name='term_M' value="<?=$DATA[0]['term_M']?>" size=3 style='font-size:9pt' class="text_f">개월
	</td>
</tr>
<tr>
	<th><?=mecho("근무부서")?></th>
	<td colspan="3" class="default"><?=mecho($DATA['dept_name'])?></td>
	<th><?=mecho("입사일자")?></th>
	<td class="default"><?=$srch_start_date?></td>
</tr>
<tr>
	<th><?=mecho("생년월일")?></th>
	<td colspan="3" class="default"><input type="text" name="birth" class="input02" style="width:36%;" value="<?=$DATA[0]['birth']?>"></td>
	<th><?=mecho("최종근무일")?></th>
	<td class="default"><?=$srch_end_date?></td>
</tr>
<tr>
	<th><?=mecho("퇴직 후 연락처")?></th>
	<td colspan="5" class="default"><input type="text" name="phone_num" class="input02" style="width:21%;" value="<?=$DATA[0]['phone_num']?>"></td>
</tr>
<tr>
	<th><?=mecho("퇴직사유")?></th>
	<td colspan="5" class="default"><textarea name="reason" style="width:100%;height:100px" class="input02"><?=$DATA[0]['reason']?></textarea></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dcs_part_write">
<col width="14%"></col>
<col width="8%"></col>
<col width="58%"></col>
<col width="20%"></col>
<tr>
<td><p>&nbsp;</p></td>
<td><p>&nbsp;</p></td>
<td>
	<br><b><p align="center">서약서</p><br>
	&nbsp;본인은 <?=Form::SELECT("sday_dt_yy", "YY", $DATA[0]['sday_dt_yy'])?>년<?=Form::SELECT("sday_dt_mm", "MM", $DATA[0]['sday_dt_mm'])?>월<?=Form::SELECT("sday_dt_dd", "DD", $DATA[0]['sday_dt_dd'])?>일로 (주)골든크라운을
	<br>퇴직함에 있어 다음의 내용을 준수 할 것을 서약합니다.
	<br><br>1. 재직시 습득한 회사의 모든 기밀 사항을 외부의 누구에게도
	<br>&nbsp;&nbsp;&nbsp;누설하지 않겠습니다.
	<br>2. 기밀 누설시 모든 법적 책임은 본인에게 있음을 서약합니다.</b>
	<br><br><center><b>
	<!--
	<input type="text" id="sign_dt" name="sign_dt" class="input03" style="width:30%;font-weight:bold;color:#646464;" value="" readonly>
	-->
	<?=mecho($DATA['reg_dt'])?>
	<br>서약자 성명 : <?=mecho($DATA['drafter'])?></center><br>
</td>
<td><p>&nbsp;</p></td>
</tr>
<tr>
	<td colspan="4" align="right">(주)골든크라운 대표이사 귀하&nbsp;</td>
</tr>
</table>

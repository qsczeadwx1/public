<?
// 달력기본 정의
$this->module->oUX->_calendar_return = 1;

// 작성일자
$this->module->oUX->_calendar_input_style = "margin-right:6px;margin-left:6px;width:62px";

if (!$DATA[0]["srch_start_date"]) $DATA[0]["srch_start_date"] = date(Y.'-'.m.'-'.d);
$this->module->oUX->addCalendar("srch_start_date","",$DATA[0]["srch_start_date"],"onchange=\"fn_date_term('srch_start_date', 'srch_end_date', 'term');\"");
$srch_start_date = $this->module->oUX->showCalendar(0,1);

if (!$DATA[0]["srch_end_date"]) $DATA[0]["srch_end_date"] = date(Y.'-'.m.'-'.d);
$this->module->oUX->addCalendar("srch_end_date","",$DATA[0]["srch_end_date"],"onchange=\"fn_date_term('srch_start_date', 'srch_end_date', 'term');\"");
$srch_end_date = $this->module->oUX->showCalendar(1,1);

if (!$DATA[0]["sendDept"])   $DATA[0]["sendDept"] = $DATA['dept_name'];
if (!$DATA[0]["sendCoCode"])   $DATA[0]["sendCoCode"] = $DATA['emp_serial'];
//if (!$DATA[0]["sendName"])   $DATA[0]["sendName"] = $DATA['ptn_name']." ".$DATA['drafter'];
if (!$DATA[0]["sendName"])   $DATA[0]["sendName"] = $DATA['drafter'];
?>
<script>
function inputData(str)
{
	var obj_vacation = document.getElementById('vacation');
	var obj_reason2 = document.getElementById('reason2');

	obj_vacation.value = str;
	obj_reason2.value = str;
}

function use_function()
{
	var form = document.getElementById('draw_form');
	form.title.value = form.reason2.value + " <?=mecho("신청서")?>";

	reason2 = form.reason2.value;

	if (!reason2)
	{
		alert("<?=mecho("휴가종류를 선택해주세요")?>");
		return false;
	}
	term = form.term.value;
	form.reason.value = form.reason1.value+ "<br>시간 : "+ form.sday_dt_HH.value + "<?=mecho("시")?>" + form.sday_dt_II.value + "<?=mecho("분 ~ ")?>" + form.eday_dt_HH.value + "<?=mecho("시")?>" + form.eday_dt_II.value + "<?=mecho("분")?>"  ;

	var submit_check = false;

	$( "#dialog-message-check" ).dialog({
				modal: true
	});

	$.ajax({
			type: "POST",
			url: "/m/dcs/",
			cache:false,
			async:false,
			data: "mode=scheduleAct&event=getHoliday&acc_no=<?=$DATA['acc_no']?>&reason2=" + reason2 +"&term=" + term,
			success: function(msg){
				if (msg == 'OK')
				{
					$("#dialog-message-check").dialog("close");
					submit_check = true;
				}
				else
				{

					$("#dialog-message-check").dialog("close");
					alert("년차개수를 확인해주세요" + "[" + msg + "]");
					submit_check = false;
				}
			}
	});

	return submit_check;
}

function getDateTerm()
{

	var sd = document.getElementById('srch_start_date').value;
	var ed = document.getElementById('srch_end_date').value;

	if (sd && ed)
	{
		$( "#dialog-message-check" ).dialog({
				modal: true
		});

		 // 남은 연차개수 출력
		$.ajax({
				type: "POST",
				url: "/m/dcs/",
				data: "mode=scheduleAct&event=getTerm&sd=" + sd + "&ed=" + ed,
				success: function(msg){
					if (msg > 0)	$("#term").val(msg);
					else $("#term").val(0);
				}
		});

		$("#dialog-message-check").dialog("close");
	}
	/*
	var sdate_tmp = document.getElementById('srch_start_date').value;
	var edate_tmp = document.getElementById('srch_end_date').value;
	sdate = new Date(sdate_tmp.substr(0,4), sdate_tmp.substr(5,2)-1, sdate_tmp.substr(8,2));
	edate = new Date(edate_tmp.substr(0,4), edate_tmp.substr(5,2)-1, edate_tmp.substr(8,2));
	if(sdate.getTime()<edate.getTime()) {
		termSec = edate.getTime() - sdate.getTime();
		termDay = termSec/(60*60*24)/1000 + 1;
	}
	else if(sdate.getTime()==edate.getTime()) {
		termDay = 1;
	}
	else termDay = 0;

	if(sdate.getTime() > 0  && edate.getTime() > 0 && sdate.getTime() > edate.getTime()) {
        //alert("기간 중 시작 날이 마치는 날보다 최근일자입니다.");
	    document.getElementById('srch_end_date').value = document.getElementById('srch_start_date').value;
	}
	document.getElementById('term').value = termDay;

	*/


}

$(window).load(function(){

	 // 남은 연차개수 출력
	$.ajax({
			type: "POST",
			url: "/m/dcs/",
			cache:false,
			async:false,
			data: "mode=scheduleAct&event=setHoliday&acc_no=<?=$DATA['acc_no']?>",
			success: function(msg){
				$("#holiday").text(msg);
			}
	});

});

/**
 * 주소록창 열기 
 */
function openAddrWin(obj_id,hidden_id,type)
{
	nw = tNewWin('/addr/index.php?type='+type+'&obj_select='+obj_id+'&obj_hidden='+hidden_id,'test', 550, 450, 'no', 'yes');
	nw.focus();

}

function user_script(data)
{
	var tmp = data.split('@');
	var arr = tmp[0].split(',');
	var hidden_id = tmp[1].split(',');
	var obj_hidden = document.getElementById(hidden_id);

	str = arr[0].split('^');
	obj_hidden.value = str[2];
}

</script>
<!-- dialog -->
<div>
<div id="dialog-message-check" title="요청 처리중.." style="display:none;">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		 데이타를 검증중입니다.  잠시만 기다려 주세요
	</p>
         <p></p>

<p>
</p>
</div>

</div>
<!--//dialog  -->
<input type="hidden" id="title"  name="title" value="휴가원">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dcs_part_write">
<col width="15%"></col>
<col width="35%"></col>
<col width="15%"></col>
<col width="35%"></col>
	<tr>
		<th><?=mecho("소속")?></th>
		<td class="default"><input type='text' name='sendDept' id='sendDept' value="<?=$DATA[0]["sendDept"]?>" class="input02"></td>
		<th><?=mecho("사번")?></th>
		<td class="default"><input type='text' name='sendCoCode' id='sendCoCode' value="<?=$DATA[0]["sendCoCode"]?>" class="input02"></td>
	</tr>
	<tr>
		<th><?=mecho("성명")?></th>
		<td class="default"><input type='text' name='sendName' id='sendName' value="<?=$DATA[0]["sendName"]?>" style='width:80%;' class="input02">
		<a href='#' onclick="openAddrWin('USER','sendName',3);"><img src="/design/image/button/dcs_contact.png"></a>
		</td>
		<th><?=mecho("행선지")?></th>
		<td class="default"><input type='text' name='place' value="<?=$DATA[0][place]?>" class="input02"></td>
	</tr>
	<tr>
		<th><?=mecho("사유")?></th>
		<td class="default" colspan="3" height="60"><textarea name="reason1"  class="input02" style='width:99%;height:100%'><?=$DATA[0][reason1]?></textarea></td>

		<input type="hidden" name="reason"  class="input02" style='width:99%;height:100%'>
	</tr>
	<tr>
		<td class="default" colspan="4" align="right"> <?=mecho("사용가능한 년차는 ")?><b><span id="holiday" style="font-weight:bold"></span></b> 개 입니다.</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="1" width="100%" bordercolorlight="#999999" bordercolordark="#FFFFFF" class="dcs_part_write">
<col width="40%"></col>
<col width="*"></col>
	<tr>
		<td class='default'>
			<input type="radio" id="type1" name="type1" value="공무외출" <?=($DATA[0][type1] == '공무외출') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("공무외출")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="사무외출" <?=($DATA[0][type1] == '사무외출') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("사무외출")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="조퇴" <?=($DATA[0][type1] == '조퇴') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("조퇴")?>
		</td>
		<td>
		<?=Form::SELECT("sday_dt_HH", "HH", "08", "class=select_f style='font-size:9pt'")?><?=mecho("시")?>
		<?=Form::SELECT("sday_dt_II", "II", "20", "class=select_f style='font-size:9pt'")?><?=mecho("분")?> ~
		<?=Form::SELECT("eday_dt_HH", "HH", "17", "class=select_f style='font-size:9pt'")?><?=mecho("시")?>
		<?=Form::SELECT("eday_dt_II", "II", "20", "class=select_f style='font-size:9pt'")?><?=mecho("분")?>
		</td>
	</tr>
<?
if (empty($DATA[0]['term']) == TRUE) {
	$DATA[0]['term'] = '1';
}
?>
	<tr>
		<td class='default' colspan='2'>
			<input type="radio" id="type1" name="type1" value="훈련" <?=($DATA[0][type1] == '훈련') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("훈련")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="년차" <?=($DATA[0][type1] == '년차') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("년차")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="반차" <?=($DATA[0][type1] == '반차') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("반차")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="공가" <?=($DATA[0][type1] == '공가') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("공가")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="병가" <?=($DATA[0][type1] == '병가') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("병가")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="생휴" <?=($DATA[0][type1] == '생휴') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("생휴")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="특별휴가" <?=($DATA[0][type1] == '특별휴가') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("특별휴가")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="결근" <?=($DATA[0][type1] == '결근') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("결근")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="출장" <?=($DATA[0][type1] == '출장') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("출장")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="교육" <?=($DATA[0][type1] == '교육') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("교육")?><br>
			<input type="radio" id="type1" name="type1" value="특근" <?=($DATA[0][type1] == '특근') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("특근")?>&nbsp;&nbsp;&nbsp;
			<input type="radio" id="type1" name="type1" value="취소" <?=($DATA[0][type1] == '취소') ? 'checked' : ''?> onClick="inputData(this.value)"> <?=mecho("취소")?>
		</td>
	</tr>
	<tr>

		<th>
			<input type="text" id="vacation"  name="vacation" maxlength="10"  style='width:60; border:0; text-align:center; background:#F2F2F2; font-size:8pt; text-align:right;' value=""><?=mecho('일자')?>
		</th>
		<td class="default" colspan='2'>
	<?=$srch_start_date?>

	<?=$srch_end_date?>
					&nbsp;&nbsp; ( <input type='text' id="term" name='term' value="<?=$DATA[0]['term']?>" readonly size=3 style='font-size:9pt' class="text_f"> ) <?=mecho("일간")?>
		</td>

	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="1" width="100%" bordercolorlight="#999999" bordercolordark="#FFFFFF">
<TR>
	<TD height=130 valign=middle colspan=4>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" bordercolorlight="#999999" bordercolordark="#FFFFFF">
			<TR>
				<TD height=35 align=center><span class="list_art1"><?=mecho("상기와 같이")?> (<input type="text" id="reason2" name="reason2" maxlength="10" class="text_f" style='width:60;border:0;text-align:center;' value="<?=$DATA[0][reason2]?>" readonly>)<?=mecho("신청을 하고자 하오니 허락하여 주시기 바랍니다.")?></span></TD>
			</TR>
			<TR>
				<TD height=35 align=center><span class="list_art1">
					<!--<?=substr(date("Y".mecho('년')."m".mecho('월')."d".mecho('일').""),0,7)?>&nbsp;
					<?=substr(date("Y".mecho('년')."m".mecho('월')."d".mecho('일').""),7,5)?>&nbsp;
					<?=substr(date("Y".mecho('년')."m".mecho('월')."d".mecho('일').""),12,7)?>-->
					<?=date("Y")?><?=mecho('년')?>&nbsp;<?=date("m")?><?=mecho('월')?>&nbsp;<?=date("d")?><?=mecho('일')?>

					</span>
				</TD>
			</TR>
			<TR>
				<TD height=35 align=right style="padding-right:30pt;"><span class="list_art1"><?=mecho("작성자")?> : <?=$DATA['drafter']?>&nbsp;&nbsp;&nbsp;</span></TD>
			</TR>
		</table>
	</TD>
</TR>
</table>
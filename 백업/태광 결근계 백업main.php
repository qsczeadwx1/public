<?
$text1 =str_replace(" ", "&nbsp;", $DATA[0][reason]);
$text_1 = nl2br($text1);
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dcs_part_write">
<col width="15%"></col>
<col width="35%"></col>
<col width="15%"></col>
<col width="35%"></col>
	<tr>
		<th><?=mecho("소속")?></th>
		<td class="default"><?=$DATA[0]["sendDept"]?></td>
		<th><?=mecho("사번")?></th>
		<td class="default"><?=$DATA[0]["sendCoCode"]?></td>
	</tr>
	<tr>
		<th><?=mecho("성명")?></th>
		<td class="default"><?=$DATA[0]["sendName"]?> </td>
		<th><?=mecho("행선지")?></th>
		<td class="default"><?=$DATA[0][place]?></td>
	</tr>
	<tr>
		<th><?=mecho("사유")?></th>
		<td class="default" colspan="3" height="60"><?=nl2br($DATA[0][reason1])?></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="1" width="100%" bordercolorlight="#999999" bordercolordark="#FFFFFF" class="dcs_part_write">
<col width="30%"></col>
<col width="*"></col>
	<tr>
		<th><?=$DATA[0]['type1']?>&nbsp;<?=mecho("시간")?></th>
		<td class="default" colspan='3'>
		<?=$DATA[0]['sday_dt_HH']?><?=mecho("시")?> <?=$DATA[0]['sday_dt_II']?><?=mecho("분")?> ~ 
		<?=$DATA[0]['eday_dt_HH']?><?=mecho("시")?> <?=$DATA[0]['eday_dt_II']?><?=mecho("분")?>
		</td>
	</tr>
	<tr>
		<th><?=$DATA[0]['type1']?>&nbsp;<?=mecho("기간")?></th>
		<td class="default" colspan='3'>
			&nbsp;<?=$DATA[0]['srch_start_date']?>
	~ 
			&nbsp;<?=$DATA[0]['srch_end_date']?>

				 ( <?=$DATA[0]['term']?> <?=mecho("일간")?> )
		</td>

	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="dcs_part_write">
	<TR>
		<th><br><?=mecho("상기와 같이")?> (<?=$DATA[0][reason2]?>)<?=mecho("신청을 하고자 하오니 허락하여 주시기 바랍니다.")?></span>
			<br><br><?=$DATA['reg_dt']?>
			<br><br><?=mecho("작성자")?> &nbsp;:&nbsp; <?=$DATA['name']?>&nbsp;&nbsp;&nbsp;
		</th>
	</TR>
</table>

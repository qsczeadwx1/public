<script>
function goSave()
{
	var frm = document.getElementById('form1');
	editor_save("comment");
	
	var type = frm.type.value;

	if(type == "edit")
	{
		frm.event.value = "update";
	}
	else
	{
		frm.event.value = "add";
	}
	frm.mode.value = "act";
	

	if(frm.cpn_name.value == '')
	{
		alert('<?=mecho('상호(업체명)','input')?>');
		return false;
	}
	if(frm.bus_regi_num.value == '')
	{
		alert('<?=mecho('사업자번호','input')?>');
		return false;
	}
	if(frm.ceo_name.value == '')
	{
		alert('<?=mecho('대표자명','input')?>');
		return false;
	}
	frm.submit();
}


</script>

<!--내용-->
<form action="./" name="form1" id="form1" method="post" style="margin:0;" onsubmit="return false;">
<input type="hidden" name="mode" value="<?=$this->module->mode?>" />
<input type="hidden" name="type" value="<?=$this->module->type?>" />
<input type="hidden" name="event" value="" />
<input type="hidden" name="tmp_no" value = "<?=$this->module->tmp_no?>">
<input type="hidden" name="page" value="<?=$this->module->page?>" />
<input type="hidden" name="order_idx" value="<?=isset($this->module->order_idx) ? $this->module->order_idx:'';?>">
<input type="hidden" name="sort" value="<?=isset($this->module->sort) ? $this->module->sort:''?>">
<input type="hidden" name="sel_search" value="<?=$this->module->sel_search?>" />
<input type="hidden" name="sch_txt" value="<?=$this->module->sch_txt?>" />
<input type="hidden" name="cpn_no" value="<?=isset($this->module->cpn_no) ? $this->module->cpn_no:'';?>" />
<input type="hidden" name="acc_no" value="<?=$DATA['acc_no']?>" />
<input type="hidden" name="cpn_code" value="<?=$DATA['cpn_code']?>" />
	
<div class="breadcrumbs">
	<button type="button" class="wide"></button>
	<h2 style="background-image:url(/imgs/common/icon_gnb0201.png);"><?=$this->module->PAGE_TITLE;?></h2>
</div>

<div class="board-condition cell">
	<ul>
		<li><?=$this->module->oUX->showButtonMenu()?></li>
	</ul>
</div>

<div class="tbd-wrap mrl30">
	<table class="tbd" summary="게시판 글쓰기">
		<caption></caption>
		<tbody>



<div id="contens_SUB_box">
<div id="board_border" class="divborder"  >
<!--ui object -->
<div id="view_mail">

<div class="board_part">
	<fieldset>
	<table class="board_part_write" width="100%" summary="mail_read">
		<col width="10%"></col>
		<col width="15%"></col>
		<col width="10%"></col>
		<col width="15%"></col>
		<col width="10%"></col>
		<col width="15%"></col>
		<col width="10%"></col>
		<col width="15%"></col>

		<tr id="tr_1">
			<th><?=mecho('상호(업체명)');?> </th>
			<td colspan="3"><input type="text" name="cpn_name" value="<?=$DATA['cpn_name']?>" class="input02"></td>
			<th><?=mecho('사업자번호');?> </th>
			<td><input type="text" name="bus_regi_num" value="<?=$DATA['bus_regi_num']?>" class="input02"></td>
			<th><?=mecho('법인번호');?> </th>
			<td><input type="text" name="corporate_regi_num" value="<?=$DATA['corporate_regi_num']?>" class="input02"></td>
		</tr>
	   <tr id="tr_1">
			<th><?=mecho('업태');?> </th>
			<td colspan="3"><input type="text" name="bus_type" value="<?=$DATA['bus_type']?>" class="input02"></td>
			<th><?=mecho('업종');?> </th>
			<td colspan="3"><input type="text" name="bus_category" value="<?=$DATA['bus_category']?>" class="input02"></td>
		</tr>
		<tr id="tr_1">
			<th><?=mecho('대표자명');?> </th>
			<td><input type="text" name="ceo_name" value="<?=$DATA['ceo_name']?>" class="input02"></td>
			<th><?=mecho('대표전화');?> </th>
			<td><input type="text" name="ceo_tel" value="<?=$DATA['ceo_tel']?>" class="input02"></td>
			<th><?=mecho('FAX');?> </th>
			<td><input type="text" name="fax" value="<?=$DATA['fax']?>" class="input02"></td>
			<th><?=mecho('휴대폰');?> </th>
			<td><input type="text" name="phone_num" value="<?=$DATA['phone_num']?>" class="input02"></td>
		</tr>
		<tr id="tr_1">
			<th><?=mecho('이메일');?> </th>
			<td colspan="3"><input type="text" name="email" value="<?=$DATA['email']?>" class="input02"></td>
			<th><?=mecho('홈페이지');?> </th>
			<td colspan="3"><input type="text" name="homepage_url" value="<?=$DATA['homepage_url']?>" class="input02"></td>
		</tr>
		<tr id="tr_1">
			<th><?=mecho('주소');?> </th>
			<td colspan="5"><input type="text" name="cpn_addr" value="<?=$DATA['cpn_addr']?>" class="input02"></td>
			<th><?=mecho('작성자');?> </th>
			<td><?=$DATA['writer']?></td>
		</tr>
		<tr id="tr_2">
			<th align="center"><?=mecho('비고');?> </th>
			<td colspan="7"> <?=$this->module->oUX->showEditor("comment",$DATA['comment'],'100%','150px','form1');?></td>
		</tr>
	</table>
	</fieldset>
</div>
</div>
</div>
</div>
</form>


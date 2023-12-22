<?
if ($_SERVER['SERVER_NAME'] == "gw.hd-chiller.com") header("location:http://gw.hd-cotran.com:10088");
else if ($_SERVER['SERVER_NAME'] == "gw.hj-future.com") header("location:https://gw.hjncs.com/main/?cpn_code=CC");
?>
<?
if ($_GET['cpn_code'] == 'CB' || $_GET['cpn_code'] == 'CC')
{
	$logo = $address = '';
	if ($_GET['cpn_code'] == 'CB') 
	{
		$logo = "/data/com/CB/custom/image/logo.png";
		$address = '대구광역시 동구 율암로 88 (율암동)';
	}
	else 
	{
		$logo = "/data/com/CC/custom/image/logo.png";
	}

?>
	<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>_DATA_SITE_NAME_</title>
<!--//DATA_SCRIPT-->
<link href="/design/css/login4.css" rel="stylesheet" type="text/css">
</head>
<body>
 <form id="form1">
<div id="loginW">
  <h1 class="nopngBG"><img src="<?=$logo?>"  class="png_24"></h1>
  <div id="loginBOXw">
<div id="loginBOX">
			<div class="login_top"><img src="../image/login/login4/background.image.png"></div>
			<div class="loginFORM">
            <div class="loginFORM_align">
			  <table class="logintable" summary="login">
<?php if( !empty($GLOBALS['GA_CONFIG']['CUSTOM']['LOGIN']['SELECT_CPN_CODE']) ){ ?>
				<tr>
				  <th width="75" height="18"><img src="../image/login/login4/label.company.gif"  alt="company"></th>
				  <td width="280">
<? if ($_GET['cpn_code'] == 'CB') { ?>
<select id="sel_cpn_code" name="sel_cpn_code" class='select_login'>
<option value="CB"  >(주)에이치디시</option>
</select>
<? } else { ?>
<select id="sel_cpn_code" name="sel_cpn_code" class='select_login'>
<option value="CC"  >(주)에이치제이퓨처</option>
</select>
<? } ?>
</td>
				  <td width="143" rowspan="4"><img id="btn_login" src="../image/login/login4/btn.login.gif"  alt="login" style="cursor:hand;cursor:pointer;"></td>
				</tr>
				<tr>
				  <th height="18"><img src="../image/login/login4/label.id.gif"  alt="id"></th>
				  <td><input id="id" type="text" class="input_login" tabindex="1" />&nbsp;
				 <input type="checkbox" id="saveid" name="saveid" style="vertical-align:middle" value="save" tabindex="3" />
				  <span style="font-size:11px; font-family:tahoma; color:#fff; font-weight:bold">save</span></td>
				</tr>
<?php }else{ ?>
				<tr>
				  <th height="18"><img src="../image/login/login4/label.id.gif"  alt="id"></th>
				  <td><input id="id" type="text" class="input_login" tabindex="1" />&nbsp;
				 <input type="checkbox" id="saveid" name="saveid" style="vertical-align:middle" value="save" tabindex="3" />
				  <span style="font-size:11px; font-family:tahoma; color:#fff; font-weight:bold">save</span></td>
				  <td width="143" rowspan="4"><img id="btn_login" src="../image/login/login4/btn.login.gif"  alt="login" style="cursor:hand;cursor:pointer;"></td>
				</tr>
<?php } ?>
				<tr>
				  <th height="18"><img src="../image/login/login4/label.pass.gif"  alt="password"></th>
				  <td><input id="pass" type="password" value="" class="input_login" tabindex="2" onkeyup="checkCapsLock(event)"/> _DATA_SEL_JOIN_</td>
				</tr>
				<tr>
				  <th height="18"><img src="../image/login/login4/label.lang.gif"  alt="language"></th>
				  <td>_DATA_SEL_LANG_</td>
				</tr>
			  </table>
              </div>
			</div>

  </div>
  </div>
  <div style="margin:0 auto;width:912px;">
  <div style="float:left;width:300px;padding-top:5px;text-align:left;display:">_DATA_MSG_CHROME_</div>
  <div style="float:right;width:200px;text-align:right"><a href="/design/main/chrome.html" target="_blank">
  <img src="../image/login/label.chromeinstall.gif" style="margin-top:5px;"></a></div>
  </div>

  <div id="copyright">
	<div style="float:left;width:300px; padding:15px 0 0 0;">
    <img src="../image/login/ci.copy1.png"  alt="DBvalley" style="margin-right:30px;" class="png_24">
    <img src="../image/login/ci.copy2.png"  alt="Anymate" class="png_24">
    </div>
	<div style="float:right;width:400px; padding-top:15px;text-align:right">
   <? if ($_GET['cpn_code'] != 'CA') { ?>
	<?=$address?>
	<? } else { ?>
	<!--//DATA_ADDRESS-->
    <? } ?>
	</div>
	</div>

</div>


</form>

<!-- dialog -->
<!--//DATA_DIALOG-->
<!--//dialog -->
</body>
</html>
<?
}
else 
{
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>_DATA_SITE_NAME_</title>
<!--//DATA_SCRIPT-->
<link href="/design/css/login.custom.css?time=1234" rel="stylesheet" type="text/css">
<script>
function checkCapsLock(event)  {
	// onfocus="checkCapsLock(event)"
  if (event.getModifierState("CapsLock")) {    alert("<?=mecho('Caps Lock이 켜져 있습니다.')?>");   }
}
</script>
</head>

<body>
 <form id="form1">

<div id="loginW">
	<div id="loginBOXw">
		  <div id="loginBOX">
				<div class="loginLogo">
					<img src="/data/com/CA/custom/login/image/ci.group.png" alt="HANJUNG NCS">
				</div>

				<div class="loginFORM">
					<div class="loginTxt">
						<img src="/data/com/CA/custom/login/image/txt.login.png" width="440">
					</div>
					<ul>
						<li><select id="sel_cpn_code" name="sel_cpn_code" class='select_login'>
<option value="CA"  selected >(주)한중엔시에스</option>
</select></li>
						<li><input id="id" type="text" class="input_login icon_id" tabindex="1" placeholder="ID"></li>
						<li><input id="pass" type="password" class="input_login icon_pw" tabindex="2"  placeholder="PASSWORD" ></li>
						<li>_DATA_SEL_LANG_</li>
						<li><input type="checkbox" id="saveid" name="saveid" style="vertical-align:middle" value="save" tabindex="3" checked /> 
						<label for="saveid" style="cursor:pointer;">Remember me?</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://gw.hjncs.com/main/?cpn_code=CB" style="font-size:13px;color:#fff"><b>(주) 에이치디시</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="https://gw.hjncs.com/main/?cpn_code=CC" style="font-size:13px;color:#fff"><b>(주)에이치제이퓨처</a>
						</li> 
						<li><input id="btn_login" type="button" class="formBtn" value="LOGIN"></li>
						<li style="text-align:center"></li>
					</ul>
				</div>
		  </div>  
	</div>
</div>
<div class="copyright">
	<div class="copyrightWrap">
		<div class="chromeBox">
			<a href="/design/main/chrome.html" target="_blank">
			<img src="../image/login/label.chromeinstall.png"></a><br>
		</div>
		<div class="copyrightTxt">
			<!--//DATA_ADDRESS-->
		</div>
	</div>
</div>
</form>
<script>
$("#sel_cpn_code").addClass("icon_company");
$("#language").addClass("icon_lang");
</script>
<!-- dialog -->
<!--//DATA_DIALOG-->
<!--//dialog -->
</body>
</html>
<? } ?>
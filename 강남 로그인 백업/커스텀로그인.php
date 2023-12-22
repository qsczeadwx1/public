<?
if ($_SERVER['HTTP_HOST'] == "gw.jebi.co.kr") Header("location:http://nest.kangnam.co.kr");
?>
<?
/* 커스텀 로그인 화면 적용방법 BMS:40159
* 1. 기간변수 지정 $start_date ~ $end_date
* 2. 변경될 배경화면 이미지 업로드 (/image/login/custom/login/bg_c.jpg)
* 3. /design/css/login.custom_c.css 파일에서 이미지 캐시방지 (nocache 값 수정)
     ../image/login/custom/login/bg_c.jpg?nocache=20210205
*/
$start_date = "2023-12-20 00:00:00";
$end_date = "2024-01-05 23:59:59";

//if(date('Y-m-d') >= $start_date && date('Y-m-d') <= $end_date){
if((strtotime(date('Y-m-d H:i:s')) >= strtotime($start_date)) && (strtotime(date('Y-m-d H:i:s')) <= strtotime($end_date))){
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
<meta http-equiv="x-ua-compatible" content="IE=9" >
<title>_DATA_SITE_NAME_</title>
<!--//DATA_SCRIPT-->
<script type="text/javascript" src="/design/js/jquery.placeholder.js"></script>
<script type="text/javascript">
//(function ($) {
//  $(document).ready(function () {
//    $("input, textarea").placeholder();
//  });
//})(jQuery); 
</script>
<link href="../design/css/login.custom_c.css?nocache=20231219" rel="stylesheet" type="text/css">
</head>
<body>


 <form id="form1">

<div id="loginW">
	
	<div id="loginBOXw">
		  <div id="loginBOX">
				<div class="login_top">
					<img src="../image/login/custom/login/ci.group_20231219.png?nocache=20231219"  alt="nest">
					<!-- <img src="../image/login/custom/login/ci.group_2020_07.gif?nocache=<?=time()?>"  alt="nest"> -->
				 </div>
				<div class="loginFORM">
					<ul>
						<!--<li><select class="select_login"><option>COMPANY</option></select></li>-->
						<li><input id="id" type="text" class="input_login" tabindex="1" placeholder="USER ID" /></li>
						<li><input id="pass" type="password" class="input_login"  placeholder="PASSWORD"  tabindex="2" value="" /></li>
						<li>_DATA_SEL_LANG_</li>
						<li><img id="btn_login" src="../image/login/custom/login/btn.login_new.png"  alt="LOGIN" style="cursor:hand;cursor:pointer;margin-top:40px;"></li>
						<li><input type="checkbox" id="saveid" name="saveid" style="vertical-align:middle" value="save" tabindex="3"  /> Remember me</li>
					</ul>
				</div>
				<div class="copyright">
					<img src="../image/login/custom/login/ci.group2_2023_0921.png?nocache=20230921"  >
				</div>
		  </div>
	</div>
	<div class="chromeBox">
			<a href="/design/main/chrome.html" target="_blank">
			<img src="../image/login/custom/login/label.chromeinstall_new.png"></a><br>
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
<meta content="text/html; charset=UTF-8" http-equiv="content-type"/>
<meta http-equiv="x-ua-compatible" content="IE=9" >
<title>_DATA_SITE_NAME_</title>
<!--//DATA_SCRIPT-->
<script type="text/javascript" src="/design/js/jquery.placeholder.js"></script>
<script type="text/javascript">
(function ($) {
  $(document).ready(function () {
    $("input, textarea").placeholder();
  });
})(jQuery); 
</script>
<link href="../design/css/login.custom_new.css?nocache=20210110" rel="stylesheet" type="text/css">
</head>
<body>


 <form id="form1">

<div id="loginW">
	<div id="loginBOXw">
		  <div id="loginBOX">
				<div class="login_top" style="margin:135px 0 0 32px;">
					<img src="../image/login/custom/login/ci.group_new.png?nocache=20170201"  alt="nest">
					<!-- <img src="../image/login/custom/login/ci.group_2020_07.gif?nocache=<?=time()?>"  alt="nest"> -->
				 </div>
				<div class="loginFORM">
					<ul>
						<!--<li><select class="select_login"><option>COMPANY</option></select></li>-->
						<li><input id="id" type="text" class="input_login" tabindex="1" placeholder="USER ID" /></li>
						<li><input id="pass" type="password" class="input_login"  placeholder="PASSWORD"  tabindex="2" value="" /></li>
						<li>_DATA_SEL_LANG_</li>
						<li><img id="btn_login" src="../image/login/custom/login/btn.login_new.png"  alt="LOGIN" style="cursor:hand;cursor:pointer;margin-top:40px;"></li>
						<li><input type="checkbox" id="saveid" name="saveid" style="vertical-align:middle" value="save" tabindex="3"  /> Remember me</li>
					</ul>
				</div>
				<div class="copyright">
					<img src="../image/login/custom/login/ci.group2_new.png?nocache=20170314"  >
				</div>
		  </div>
	</div>
	<div class="chromeBox">
			<a href="/design/main/chrome.html" target="_blank">
			<img src="../image/login/custom/login/label.chromeinstall_new.png"></a><br>
	</div>
</div>
</form>

<!-- dialog -->
<!--//DATA_DIALOG-->
<!--//dialog -->
</body>
</html>

<? } ?>
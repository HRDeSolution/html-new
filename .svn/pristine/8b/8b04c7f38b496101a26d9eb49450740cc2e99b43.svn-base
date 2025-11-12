<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php"; //DB연결 및 각종 함수 정의

unset($_SESSION["LoginMemberID"]);
unset($_SESSION["LoginName"]);
unset($_SESSION["LoginEduManager"]);
unset($_SESSION["LoginMemberType"]);
unset($_SESSION["LoginTestID"]);

unset($_SESSION["IsPlaying"]); // Brad (2021.11.27)

$sitemode = Replace_Check_XSS2($sitemode);

if($sitemode == "flex") $url = "/hrdflex/main/main.html";  else $url="/hrdedu/main/main.html";

//Session_destroy();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	location.href="<?=$url?>";
//-->
</SCRIPT>
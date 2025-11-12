<?
include "../include/include_function.php"; 

// Clear JWT cookies on logout
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_jwt_generator.php";

setCookie("LoginAdminID","",0);
setCookie("LoginAdminName","",0);
setCookie("LoginAdminDepart","",0);
setCookie("LoginAdminDept","",0);
setCookie("LoginAdminDeptString","",0);
setCookie("LoginAdminTopMenuGrant","",0);
setCookie("LoginAdminSubMenuGrant","",0);
setCookie("LoginDate","",0);

unset($_SESSION["LoginAdminID"]);

SSOJWTGenerator::clearJWTCookie();

mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="./index.php";
//-->
</SCRIPT>

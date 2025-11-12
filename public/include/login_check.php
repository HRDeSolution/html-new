<?
if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	//alert("<?= "LOGIN_OK_SESSION2-".	$_SESSION["LoginMemberID"] ?>");
	alert("로그인후에 이용이 가능합니다.");
	top.location.href="/public/member/login.html";
//-->
</script>
<?
exit;
}
?>
<?
if(empty($_SESSION['LoginMemberID'])) {
?>
<script type="text/javascript">
<!--
	alert("로그인후에 이용하세요.");
	opener.location.href="/pulic/member/login.html";
	self.close();
//-->
</script>
<?
exit;
}
?>
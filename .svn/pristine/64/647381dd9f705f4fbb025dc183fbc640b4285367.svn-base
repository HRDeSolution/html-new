<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php"; //DB연결 및 각종 함수 정의

require_once ('../../include/KISA_SHA256.php');

$sitemode = Replace_Check_XSS2($sitemode);

$MemberType = Replace_Check_XSS2($MemberType);
$idSave = Replace_Check_XSS2($idSave); //아이디 저장여부
$ID = Replace_Check_XSS2($ID); //아이디
$Pwd = Replace_Check_XSS2($Pwd); //비밀번호

$TopLogin = Replace_Check_XSS2($TopLogin); //상단에서 로그인 여부

$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화

$Sql = "SELECT * FROM Member WHERE BINARY(ID)='$ID' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    if($Row['Sleep']=="Y") {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("현재 휴면계정 상태입니다.\n\n[휴면계정 복구] 메뉴를 통해 계정을 복구하세요.");
	//-->
	</SCRIPT>
<?
	   exit;
	}
	if($Row['MemberOut']=="Y") {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("탈퇴한 회원입니다.");
		top.DataResultClose();
	//-->
	</SCRIPT>
<?
	   exit;
	}
	if($Row['Pwd']!=$enc_pwd) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("아이디 또는 비밀번호를 잘못 입력했습니다.");
		location.href = "/public/member/login.html";
	//-->
	</SCRIPT>
<?
	   exit;
	}	
	
	//필수동의여부 체크를 안한 경우
	if($Row['Mandatory']=="N") {
	    $pwchg = $Row['PassChange'];
	    $url = "/public/member/after_join_terms.html?pwchg=$pwchg";
	//비밀번호를 변경해야 하는 경우
	}else if($Row['PassChange']=="N") {
	    $url = "/public/mypage/memberinfo.html";
	    $TopLogin="N";
	//테스트용 아디이일 경우, 강의페이지로 이동
	} else if ($Row['TestID']=="Y") {
	    $url = "/public/mypage/lecture_status.html";
    //교육담당자는 결제관리페이지로 이동
	} else if ($Row['EduManager']=="Y") { 
	    $url = "/public/mypage/manager_payment.html";
	}else if($sitemode == "flex"){
	    $url = "/hrdflex/main/main.html";
	}else if($sitemode == "flex2"){
	    $url = "/hrdflex/contents/main.html";
	}else if($sitemode == "flex3"){
	    $url = "/hrdflex/curation/step01.html";
	} else {
	    $url = "/public/mypage/lecture_status.html";
	}
	
	//최종로그인 날짜, IP 등록
	$Sql2 = "UPDATE Member SET LastLogin=NOW(), LastLoginIP='$UserIP' WHERE ID='$ID'";
	mysqli_query($connect, $Sql2);

	//로그인 히스토리 등록
	$Sql3 = "INSERT INTO LoginHistory(ID, Device, IP, RegDate) VALUES('$ID', 'PC', '$UserIP', NOW())";
	mysqli_query($connect, $Sql3);

	//로그인 중복처리를 위한 
	$Sql4 = "DELETE FROM LoginIng WHERE ID='$ID'";
	mysqli_query($connect, $Sql4);

	//로그인 상태 등록
	$maxno = max_number("idx","LoginIng");
	$SessionID = session_id();
	$Sql5 = "INSERT INTO LoginIng(idx, ID, SessionID, IP, RegDate) VALUES($maxno, '$ID', '$SessionID', '$UserIP', NOW())";
	mysqli_query($connect, $Sql5);


/* 20190218 대리수강 방지 2월말까지 잠정적으로 중지
	//대리수강 방지
	if($Row['ProtectID']=="Y") { //대리수강 방지 기능이 사용중이면
    	if (isset($_COOKIE["MemberProtectID"])) { //대리수강 방지 쿠키가 존재하면
	   	if($_COOKIE["MemberProtectID"] != $Row['ID']) {
            //블랙리스트에 등록
			$ProtectID = $_COOKIE["MemberProtectID"];
			$LoginID = $Row['ID'];
			$Sql_b = "INSERT INTO BlackList(ProtectID, LoginID, LoginIP, RegDate) VALUES('$ProtectID', '$LoginID', '$UserIP', NOW())";
			mysqli_query($connect, $Sql_b);
?>
    <script type="text/javascript">
        <!--
    	//alert("대리수강 방지를 위해 같은 기기에서 다른 아이디로\n\n로그인할 수 없습니다.\n\n\n\n만약 공동 PC로 수강을 진행하셔야 한다면 교육운영팀에 문의하셔서\n\n대리수강방지 기능을 해지하시기 바랍니다");
    	//-->
    </script>
<?
			exit;
		}
	}else{ //대리수강 방지 쿠키가 없다면
    	setCookie("MemberProtectID",$Row['ID'],time()+15768000,"/");
	}
}else{ //대리수강 방지 기능이 미사용중이면
	//setCookie("MemberProtectID","",0,"/"); //초기화는 당부간 보류
}
*/
	
	//아이디 저장 체크시 쿠키에 저장
	if($idSave=="on") {
		setCookie("MemberSavedID",$Row['ID'],time()+15768000,"/");
	}else{
		setCookie("MemberSavedID","",0,"/");
	}
	//로그인 세션 처리
	$_SESSION["LoginMemberID"] = $Row['ID'];
	$_SESSION["LoginName"] = $Row['Name'];
	$_SESSION["LoginEduManager"] = $Row['EduManager'];
	$_SESSION["LoginMemberType"] = $Row['MemberType'];
	$_SESSION["LoginTestID"] = $Row['TestID'];

    //echo "LOGIN_OK_SESSION-".	$_SESSION["LoginMemberID"]."<br>";

	// Brad(2021.11.27) : 수강여부 체크 세션
	$_SESSION["IsPlaying"] = "N";
?>
<script type="text/javascript">
<!--
	<?
	if($TopLogin=="Y") {
	?>
		//alert("<?= "LOGIN_OK_SESSION1-".	$_SESSION["LoginMemberID"]?>");
		top.location.reload();
	<?
	}else{
	?>
		//alert("<?= "LOGIN_OK_SESSION2-".	$_SESSION["LoginMemberID"]."-".$url?>");
		//alert("<?= "ID SAVE    ".$idSave?>");
		top.location.href="<?=$url?>";
	<?
	}
	?>
//-->
</script>
<?
}else{
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("아이디 또는 비밀번호를 잘못 입력했습니다.");
	location.href = "/public/member/login.html";
//-->
</SCRIPT>
<?
}

mysqli_close($connect);
?>
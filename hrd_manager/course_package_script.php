<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$ClassGrade = Replace_Check($ClassGrade); //등급
$LectureCode = Replace_Check($LectureCode); //과정코드
$UseYN = Replace_Check($UseYN); //사이트 노출
$HrdCode = Replace_Check($HrdCode); //HRD-NET과정코드
$ContentsName = Replace_Check($ContentsName); //과정명

$cmd = false;


//패키지여부 확인(패키지는 1개만 사용 가능)
$Sql = "SELECT COUNT(*) AS CNT FROM Course WHERE Del='N' AND UseYN='Y' AND PackageYN  = 'Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$CNT = $Row[0];
if($CNT > 1 && $UseYN=="Y"){
?>
<script type="text/javascript">
	alert("패키지는 1개만 사용가능합니다.\n현재 사용중인 패키지가 있습니다.\n해당 패키지를 미사용으로 변경부탁드립니다.");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
</script>
<?
   exit;
}


//새글 작성---------------------------------------------------------------------------------------------------------
if($mode=="new") { 
	//과정코드 중복체크
	$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
	?>
	<script type="text/javascript">
		alert("동일한 과정코드가 존재하거나 삭제된 과정코드입니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	</script>
	<?
	   exit;
	}

	$maxno_package = max_number_package();
	$maxno = max_number("idx","Course");

	$Sql = "INSERT INTO Course (idx, LectureCode, UseYN, Category1, Category2, ContentsName, ContentsStart, ContentsEnd, UploadDate, Del, RegDate, PackageYN, PackageRef, PackageLectureCode, HrdCode, ContentsURL, MobileURL, ctype , ServiceType)
            VALUES($maxno, '$LectureCode', '$UseYN', 0, 0, '$ContentsName', NOW(), NOW(), NOW(), 'N', NOW(), 'Y',$maxno_package,'', '$HrdCode' , '', '' , 'A', 'A')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package_read.php?idx=".$maxno;
}

//글 수정---------------------------------------------------------------------------------------------------------
if($mode=="edit") {
	$Sql = "UPDATE Course SET UseYN='$UseYN', ContentsName='$ContentsName' , HrdCode='$HrdCode'
            WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package_read.php?idx=".$idx;
}

//글 삭제---------------------------------------------------------------------------------------------------------
if($mode=="del") { 
	$Sql = "UPDATE Course SET Del='Y' 
            WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package.php?col=".$col."&sw=".$sw;
}

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.<?=$Sql?>";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
</SCRIPT>
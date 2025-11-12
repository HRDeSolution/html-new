<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Notice = Replace_Check($Notice);
$Title = Replace_Check($Title);
$UseYN = Replace_Check($UseYN);
$Content = Replace_Check2($Content);
/*
$FileDel1 = Replace_Check($FileDel1);
$FileDel2 = Replace_Check($FileDel2);
$FileDel3 = Replace_Check($FileDel3);
$FileDel4 = Replace_Check($FileDel4);
$FileDel5 = Replace_Check($FileDel5);
*/
$FileNameA1 = Replace_Check($file1); //첨부파일1
$RealFileNameA1 = Replace_Check($fileName1); //첨부파일1 실제파일
$FileNameA2 = Replace_Check($file2); //첨부파일2
$RealFileNameA2 = Replace_Check($fileName2); //첨부파일1 실제파일
$FileNameA3 = Replace_Check($file3); //첨부파일3
$RealFileNameA3 = Replace_Check($fileName3); //첨부파일1 실제파일
$FileNameA4 = Replace_Check($file4); //첨부파일4
$RealFileNameA4 = Replace_Check($fileName4); //첨부파일1 실제파일
$FileNameA5 = Replace_Check($file5); //첨부파일5
$RealFileNameA5 = Replace_Check($fileName5); //첨부파일1 실제파일

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;
/*
$Folder = "/Notice";
include "./include/include_upload_file.php";
*/

if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	$maxno = max_number("idx","Notice");

	$Sql = "INSERT INTO Notice 
				(idx, UseYN, Notice, Title, Content, 
				FileName1, RealFileName1, FileName2, RealFileName2, FileName3, RealFileName3, FileName4, RealFileName4, FileName5, RealFileName5, 
				ViewCount, Del, RegDate) 
				VALUES ($maxno, '$UseYN', '$Notice', '$Title', '$Content', 
				'$FileNameA1', '$RealFileNameA1', '$FileNameA2', '$RealFileNameA2', '$FileNameA3', '$RealFileNameA3', '$FileNameA4', '$RealFileNameA4', '$FileNameA5', '$RealFileNameA5', 
				0, 'N', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "notice_read.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------
	$FileQuery1 = ", FileName1='$FileNameA1', RealFileName1='$RealFileNameA1'";
	$FileQuery2 = ", FileName2='$FileNameA2', RealFileName2='$RealFileNameA2'";
	$FileQuery3 = ", FileName3='$FileNameA3', RealFileName3='$RealFileNameA3'";
	$FileQuery4 = ", FileName4='$FileNameA4', RealFileName4='$RealFileNameA4'";
	$FileQuery5 = ", FileName5='$FileNameA5', RealFileName5='$RealFileNameA5'";

	$Sql = "UPDATE Notice SET UseYN='$UseYN', Notice='$Notice', Title='$Title', Content='$Content' $FileQuery1 $FileQuery2 $FileQuery3 $FileQuery4 $FileQuery5 WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "notice_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Notice SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "notice.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>
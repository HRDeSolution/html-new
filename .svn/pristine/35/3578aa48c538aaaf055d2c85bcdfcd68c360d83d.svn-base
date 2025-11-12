<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT a.idx , a.ContentsTitle , a.LectureTime , b.ContentsURL , b.MobileURL 
        FROM Contents a
        LEFT JOIN ContentsDetail b ON a.idx = b.Contents_idx
        WHERE a.Del = 'N' AND a.idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $ContentsTitle = $Row['ContentsTitle']; //과정명
    $LectureTime = $Row['LectureTime']; //교육시간
    $ContentsURL = $Row['ContentsURL']; //컨텐츠URL
    $MobileURL = $Row['MobileURL']; //모바일URL
}
mysqli_close($connect);
?>
<script type="text/javascript">
<!--
	top.$("#ContentsName").val("<?=$ContentsTitle?>");
	top.$("#ContentsTime").val("<?=$LectureTime?>");
	top.$("#ContentsURL").val("<?=$ContentsURL?>");
	top.$("#MobileURL").val("<?=$MobileURL?>");
	
	top.DataResultClose();
//-->
</script>
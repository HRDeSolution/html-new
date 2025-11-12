<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>
<body>
<?
//보안코드 체크
if($_SESSION["make_text_image"] != $SecurityCode) {
?>
<script type="text/javascript">
	alert("보안코드가 일치하지 않습니다.");
</script>
<?
    exit;
}

$Folder = "/Counsel";

$file = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$file_size = $_FILES['file']['size'];

//파일 업로드
if($file_size>0){
    if($file_size>52428800) {
?>
<SCRIPT LANGUAGE="JavaScript">
	alert("파일크기는 50M이하만 가능합니다.");
	history.back();
</SCRIPT>
<?
	   exit;
	}
	$ext = substr(strrchr($file_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext = strtolower($ext); //확장자를 소문자로 변환
	$str_name = str_replace($ext,"",$file_name); //확장자를 제외한 파일명

	$filename = date('YmdHis')."01.".$ext;

	//파일 경로를 제외한 파일명 검출
	$file_name_arrary = explode("\\",$file_name);
	$file_name_arrary_count = count($file_name_arrary);
	$file_name2 = $file_name_arrary[$file_name_arrary_count-1];

	copy($file,$UPLOAD_DIR.$Folder."/".$filename); 

	$FileName1 = $filename;
	$RealFileName1 = $file_name2;
}else{    
	$FileName1 = "";
	$RealFileName1 = "";
}

if($FileName1){
    $sql = "INSERT INTO Counsel(ID, Name, Category, Mobile, Email, Title, Contents, RegDate, Del, Status, FileName4Student, RealFileName4Student)
	        VALUES('$LoginMemberID', '$Name', '$CounselType', '$Mobile', '$Email', '$Title', '$Content', NOW(), 'N', 'A', '$FileName1', '$RealFileName1')";   
}else{
    $sql = "INSERT INTO Counsel(ID, Name, Category, Mobile, Email, Title, Contents, RegDate, Del, Status)
	        VALUES('$LoginMemberID', '$Name', '$CounselType', '$Mobile', '$Email', '$Title', '$Content', NOW(), 'N', 'A')";
}
$Row = mysqli_query($connect, $sql);

if($Row) {
?>
<script type="text/javascript">
	alert("등록되었습니다.");
	top.DataResultClose();
	top.location.reload();
</script>
<?
}else{
?>
<script type="text/javascript">
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
</script>
<?}?>
</body>
</html>
<?mysqli_close($connect);?>
<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

$mode = Replace_Check($mode);
$MenuCode = Replace_Check($MenuCode);

$idx = Replace_Check($idx);
$Title = Replace_Check($Title);
$Image = Replace_Check($Image);
$Link = Replace_Check($Link);
$UseYN = Replace_Check($UseYN);

//-----------------------------------------------------------------------------

//idx 최대값 찾기
$Sql = "SELECT MAX(idx)+1 FROM MainContentsImg";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$MAX_NO = $Row[0];
if($MAX_NO == null){
    $MAX_NO = "1";
}

Switch ($mode) {
    //신규 등록
    case "new":        
        $SqlA = "INSERT INTO MainContentsImg ";
        $SqlA .= "(idx, MenuCode, Title, Image, Link , RegDate , MdfDate, UseYN) ";
        $SqlA .= "VALUES('$MAX_NO', '$MenuCode', '$Title','$Image','$Link', now(), now(), '$UseYN') ";
        mysqli_query($connect, $SqlA);
        //echo $Sql;
        ?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_read.php?MenuCode=<?=$MenuCode?>";
        </script>
        <?
        break;
        
        //수정
    case "edit":
        //이미지 변경이 되었을 경우, 기존 이미지 삭제 후 이미지 수정
        //1.이미지 변경되었는지 확인
        $SqlC = "SELECT Image FROM MainContentsImg WHERE idx = '$idx'";
        $Result = mysqli_query($connect, $SqlC);
        $Row = mysqli_fetch_array($Result);
        $ImageChk = $Row[0];
        //2.변경되었을 경우, 기존 이미지 삭제후 수정
        if($ImageChk != $Image){
            unlink($ROOT_PATH."/upload/MainContents/".$ImageChk);
        }
        
        $SqlA = "UPDATE MainContentsImg ";
        $SqlA .= "SET Title = '$Title' , Image = '$Image', Link = '$Link', UseYN = '$UseYN', MdfDate = now() ";
        $SqlA .= "WHERE MenuCode = '$MenuCode' AND idx = '$idx' ";
        mysqli_query($connect, $SqlA);
        //echo $Sql;
        ?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_read.php?MenuCode=<?=$MenuCode?>";
        </script>
        <?
        break;
        
        //삭제
    case "del":
        //DB 데이터 삭제전, 이미지 먼저 삭제
        $SqlC = "SELECT Image FROM MainContentsImg WHERE idx = '$idx' AND MenuCode = '$MenuCode' ";
        $Result = mysqli_query($connect, $SqlC);
        $Row = mysqli_fetch_array($Result);
        $ImageChk = $Row[0];
        unlink($ROOT_PATH."/upload/MainContents/".$ImageChk);
        
        //데이터 삭제
        $Sql = "DELETE FROM MainContentsImg WHERE idx=$idx AND MenuCode = '$MenuCode' ";
        mysqli_query($connect, $Sql);
        //echo $Sql;
        ?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_read.php?MenuCode=<?=$MenuCode?>";
		</script>
		<?
        break;
    
    //정렬하기
    case "OrderByProc":
        $idx_value_array = explode("|",$idx_value);
        
        $i = 1;
        foreach($idx_value_array as $idx){
            $idx = trim($idx);
            if($idx) {
                $Sql = "UPDATE MainContentsImg SET OrderByNum=$i WHERE idx=$idx";
                $Row = mysqli_query($connect, $Sql);
                if(!$Row) { //쿼리 실패시 에러카운터 증가
                    $error_count++;
                }
            }
            $i++;
        }
        ?>
        <script>
        	alert("처리되었습니다.");
        	top.location.reload();
        </script>
        <?
        break;
        
}
?>
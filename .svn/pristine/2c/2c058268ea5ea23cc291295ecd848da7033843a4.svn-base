<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

$mode     = Replace_Check($mode);
$idx      = Replace_Check($idx);
$MenuCode = Replace_Check($MenuCode);
$MenuName = Replace_Check($MenuName);
$UseYN    = Replace_Check($UseYN);
$Link    = Replace_Check($Link);

//-----------------------------------------------------------------------------

//idx 최대값 찾기
$Sql = "SELECT MAX(idx)+1 FROM MainContents";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$MAX_NO = $Row[0];
if($MAX_NO == null){
    $MAX_NO = "1";
}

Switch ($mode) {
	//신규 등록  
	case "new":
	    $Sql = "INSERT INTO MainContents ";
    	$Sql .= "(idx, MenuCode, MenuName, RegDate, MdfDate, UseYN , Link) ";
    	$Sql .= "VALUES('$MAX_NO', CONCAT('AA','$MAX_NO'), '$MenuName', now(), now(), '$UseYN', '$Link') ";
    	mysqli_query($connect, $Sql);
    	//echo $Sql;
    	?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_list.php?";
        </script>
        <?
	   break;

    //수정
	case "edit":	    
    	$Sql = "UPDATE MainContents ";
	    $Sql .= "SET MenuName = '$MenuName' , UseYN  = '$UseYN', Link = '$Link' , MdfDate = now() ";
	    $Sql .= "where MenuCode = '$MenuCode' ";
	    mysqli_query($connect, $Sql);
	    //echo $Sql;	    
	    ?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_list.php?";
        </script>
        <?
        break;

	//삭제
	case "del":
	    //실물 이미지 삭제
	    $SqlC = "SELECT Image FROM MainContentsImg WHERE MenuCode = '$MenuCode' ";
	    $QUERY = mysqli_query($connect, $SqlC);
	    if($QUERY && mysqli_num_rows($QUERY)){
	        while($ROW = mysqli_fetch_array($QUERY)){
	            extract($ROW);
	            unlink($ROOT_PATH."/upload/MainContents/".$Image);
        	}
        	mysqli_free_result($QUERY);
        }
        //하위 컨텐츠 DB 데이터 삭제
        $Sql = "DELETE FROM MainContentsImg WHERE MenuCode = '$MenuCode' ";
        mysqli_query($connect, $Sql);
	    //상위 메뉴 삭제
        $SqlA = "DELETE FROM MainContents WHERE MenuCode = '$MenuCode' ";
        mysqli_query($connect, $SqlA);
        
        ?>
        <script>
        	alert("처리되었습니다.");
			location.href="main_contents_list.php?";
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
	            $Sql = "UPDATE MainContents SET OrderByNum=$i WHERE idx=$idx";
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
<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$clickVal    = Replace_Check_XSS2($clickVal);

$cmd = false;
$msg;

if($clickVal == "like"){
    $maxno = max_number("idx","CourseFlexLike");
    
    $Sql = "INSERT INTO CourseFlexLike (idx, LectureCode, ID, RegDate)
            VALUES ($maxno, '$LectureCode', '$LoginMemberID', NOW())";
    $Row = mysqli_query($connect, $Sql);
    
    $cmd = true;
    $msg = "like";
}else{
    $Sql = "DELETE FROM  CourseFlexLike  WHERE ID='$LoginMemberID' AND LectureCode = '$LectureCode'";
    $Row = mysqli_query($connect, $Sql);
    
    $cmd = true;
    $msg = "unlike";
}

if($Row && $cmd) {
    echo $msg;
}else{
    echo "N";
}

mysqli_close($connect);
?>
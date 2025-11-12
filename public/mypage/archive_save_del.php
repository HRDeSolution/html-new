<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$idx_value = Replace_Check($idx_value); //선택한 관심강의 idx

$idx_array = explode('|',$idx_value);

foreach($idx_array as $idx) {
    //해당 관심강의 삭제
    $Sql = "DELETE FROM CourseLike WHERE idx=".$idx;
    $Row = mysqli_query($connect, $Sql);
    
    //쿼리 실패시 에러카운터 증가
    if(!$Row) {
        $error_count++;
    }
}


if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    echo "N";
}else{
    mysqli_query($connect, "COMMIT");
    echo "Y";
}

mysqli_close($connect);
?>
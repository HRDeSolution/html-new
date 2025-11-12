<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$id_value = Replace_Check($id_value);
$id_array = explode('|',$id_value);

foreach($id_array as $id) {
    $Sql = "UPDATE Member SET MemberOut='N', MemberInDate=NOW() , MemberInAdminID = '$LoginAdminID' WHERE id = '$id'";
    $Row = mysqli_query($connect, $Sql);
    
    if(!$Row) { //쿼리 실패시 에러카운터 증가
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
